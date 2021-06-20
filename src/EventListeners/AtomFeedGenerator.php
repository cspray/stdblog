<?php declare(strict_types=1);

namespace Cspray\StdBlog\EventListeners;

use Cspray\StdBlog\Model\AtomEntry;
use Cspray\StdBlog\Model\AtomFeed;
use TightenCo\Jigsaw\Jigsaw;

class AtomFeedGenerator {

    private string $templatePath;

    public function __construct() {
        $this->templatePath = dirname(__DIR__, 2) . '/resources/template/atom';
    }

    public function handle(Jigsaw $jigsaw) {
        $atomFeed = $this->createAtomFeedModel($jigsaw);
        $this->generateAtomFeedFile($jigsaw, $atomFeed);
    }

    private function createAtomFeedModel(Jigsaw $jigsaw) : AtomFeed {
        $posts = $jigsaw->getCollection('posts');
        $atomFeed = new AtomFeed($jigsaw);

        foreach ($posts as $post) {
            $atomFeed->addEntry(new AtomEntry($post));
        }

        return $atomFeed;
    }

    private function generateAtomFeedFile(Jigsaw $jigsaw, AtomFeed $atomFeed) : void {
        $jigsaw->writeOutputFile('atom.xml', var_export($atomFeed, true));
    }

}