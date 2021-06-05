<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class TagLink extends Tag {

    private string $href;

    public function __construct(string $name, string $href, string $class = '') {
        parent::__construct($name, $class);
        $this->href = $href;
    }

    public function render() {
        $tagHtml = parent::render();
        return sprintf(
            '<a href="%s">%s</a>',
            self::escaper()->escapeHtmlAttr($this->href),
            $tagHtml
        );
    }
}