<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class Tag extends AbstractComponent {

    private string $name;

    private string $class;

    public function __construct(string $name, string $class = '') {
        $this->name = $name;
        $this->class = $class;
    }

    public function render() {
        return sprintf(
            '<span class="py-0.5 px-2 border rounded-md text-xs %s">%s</span>',
            self::escaper()->escapeHtmlAttr($this->class),
            self::escaper()->escapeHtml($this->name)
        );
    }
}