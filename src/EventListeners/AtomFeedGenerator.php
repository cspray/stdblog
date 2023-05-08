<?php declare(strict_types=1);

namespace Cspray\StdBlog\EventListeners;

use Cspray\StdBlog\Model\AtomEntry;
use Cspray\StdBlog\Model\AtomFeed;
use Illuminate\View\Factory;
use TightenCo\Jigsaw\Jigsaw;

class AtomFeedGenerator {

    private string $templatePath;

    public function __construct() {
        $this->templatePath = dirname(__DIR__, 2) . '/resources/template/atom-feed.blade.php';
    }

    public function handle(Jigsaw $jigsaw) {
        $atomFeed = $this->createAtomFeedModel($jigsaw);
        $this->generateAtomFeedFile($jigsaw, $atomFeed);
    }

    private function createAtomFeedModel(Jigsaw $jigsaw) : AtomFeed {
        $posts = $jigsaw->getCollection('posts');
        $atomFeed = new AtomFeed($jigsaw);

        foreach ($posts as $post) {
            if (!$post->isPublished()) {
                continue;
            }
            $atomFeed->addEntry(new AtomEntry($jigsaw, $post));
        }

        return $atomFeed;
    }

    private function generateAtomFeedFile(Jigsaw $jigsaw, AtomFeed $atomFeed) : void {
        $xmlHeader = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
        /** @var Factory $view */
        $view = $jigsaw->app->get('view');
        $jigsaw->writeOutputFile('feed.atom', $xmlHeader . $view->file($this->templatePath, ['atomFeed' => $atomFeed]));
    }


}