<?php declare(strict_types=1);

namespace Cspray\StdBlog\Model;

use ArrayIterator;
use Exception;
use IteratorAggregate;
use TightenCo\Jigsaw\Jigsaw;
use Traversable;

class AtomFeed implements IteratorAggregate {

    private array $entries = [];

    public function __construct(Jigsaw $jigsaw) {
    }

    public function addEntry(AtomEntry $atomEntry) : void {

    }

    public function getIterator() {
        return new ArrayIterator($this->entries);
    }
}