<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

abstract class AbstractGlyphComponent extends AbstractComponent {

    public string $name;
    public string $size;
    public string $class;
    public string $prefix;

    public function __construct(string $name, string $size = '', string $class = '') {
        parent::__construct();
        $this->name = $name;
        $this->size = $size;
        $this->class = $class;
        $this->prefix = $this->getFontPrefix();
    }

    protected function getTemplateName() : string {
        return 'glyph';
    }

    abstract protected function getFontPrefix() : string;
}