<?php declare(strict_types=1);

namespace Cspray\StdBlog\Model;

class Tag {

    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getUrl() : string {
        return sprintf('/tags/%s', $this->name);
    }

    public function __toString() : string {
        return $this->getName();
    }

}