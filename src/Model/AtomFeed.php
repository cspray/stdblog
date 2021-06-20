<?php declare(strict_types=1);

namespace Cspray\StdBlog\Model;

use ArrayIterator;
use Iterator;
use IteratorAggregate;
use TightenCo\Jigsaw\Jigsaw;

class AtomFeed implements IteratorAggregate {

    private Jigsaw $jigsaw;
    private array $entries = [];

    public function __construct(Jigsaw $jigsaw) {
        $this->jigsaw = $jigsaw;
    }

    public function getId() : string {
        return $this->jigsaw->getConfig('atomFeed.id');
    }

    public function getTitle() : string {
        return $this->jigsaw->getConfig('title');
    }

    public function addEntry(AtomEntry $atomEntry) : void {
        $this->entries[] = $atomEntry;
    }

    public function getIterator() : Iterator {
        return new ArrayIterator($this->entries);
    }
}