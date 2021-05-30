<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class Tag extends AbstractComponent {

    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function render() {
        return sprintf(
            '<span class="py-0.5 px-2 border rounded-md text-xs">%s</span>',
            self::escaper()->escapeHtml($this->name)
        );
    }
}