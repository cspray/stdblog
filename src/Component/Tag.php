<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class Tag extends AbstractComponent {

    public string $name;
    public string $class;
    public ?string $href = null;

    public function __construct(string $name, string $href = null, string $class = '') {
        parent::__construct();
        $this->name = $name;
        $this->class = $class;
        $this->href = $href;
    }

    protected function getTemplateName() : string {
        return 'tag';
    }

}