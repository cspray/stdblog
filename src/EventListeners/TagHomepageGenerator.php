<?php declare(strict_types=1);

namespace Cspray\StdBlog\EventListeners;

use Cspray\StdBlog\Model\Tag;
use TightenCo\Jigsaw\Console\ConsoleOutput;
use TightenCo\Jigsaw\Jigsaw;

class TagHomepageGenerator {

    private string $layout;
    private string $templatePath;

    public function __construct(string $layout = 'main') {
        $this->layout = $layout;
        $this->templatePath = dirname(__DIR__, 2) . '/resources/template/layouts/tag-index.template.php';
    }

    public function handle(Jigsaw $jigsaw) {
        /** @var ConsoleOutput $consoleOutput */
        $consoleOutput = $jigsaw->app->get(ConsoleOutput::class);
        $tagIndexContents = file_get_contents($this->templatePath);
        $uniqueTags = $this->gatherUniqueTags($jigsaw);
        $tagNames = array_map(fn(Tag $tag) => $tag->getName(), $uniqueTags);
        $layoutModifiedTime = filemtime($this->templatePath);

        $tagTemplates = scandir($jigsaw->getSourcePath() . '/tags');
        if (is_array($tagTemplates)) {
            foreach ($tagTemplates as $tagTemplate) {
                if ($tagTemplate === '.' || $tagTemplate === '..') {
                    continue;
                }
                $tag = explode('.', $tagTemplate)[0];
                if (!in_array($tag, $tagNames)) {
                    $consoleOutput->writeln("The tag template $tagTemplate no longer has a corresponding tag and will be removed.");
                    unlink($jigsaw->getSourcePath() . '/tags/' . $tagTemplate);
                }
            }
        }

        foreach ($uniqueTags as $tag) {
            if (is_file($jigsaw->getSourcePath() . "/tags/$tag.blade.php")) {
                $templateModifiedTime = filemtime($jigsaw->getSourcePath() . "/tags/$tag.blade.php");
                if ($layoutModifiedTime < $templateModifiedTime) {
                    continue;
                }
            }
            $cleanContents = preg_replace('/<<TAG>>/', (string) $tag, $tagIndexContents);
            $cleanContents = preg_replace('/<<LAYOUT>>/', $this->layout, $cleanContents);
            $jigsaw->writeSourceFile("/tags/$tag.blade.php", $cleanContents);
        }
    }

    private function gatherUniqueTags(Jigsaw $jigsaw) : array {
        $posts = $jigsaw->getCollection('posts');
        $tags = [];
        foreach ($posts as $post) {
            $tags = array_merge($tags, iterator_to_array($post->tags));
        }

        return array_unique($tags);
    }

}