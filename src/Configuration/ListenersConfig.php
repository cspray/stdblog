<?php declare(strict_types=1);

namespace Cspray\StdBlog\Configuration;

use Cspray\StdBlog\EventListeners\AtomFeedGenerator;
use Cspray\StdBlog\EventListeners\TagHomepageGenerator;
use TightenCo\Jigsaw\Events\EventBus;

class ListenersConfig {

    public function registerListeners(EventBus $eventBus) : void {
        $eventBus->afterCollections(TagHomepageGenerator::class);
        $eventBus->afterBuild(AtomFeedGenerator::class);
    }

}