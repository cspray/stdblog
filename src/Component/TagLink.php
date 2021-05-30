<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class TagLink extends AbstractComponent {

    private string $name;
    private string $href;

    public function __construct(string $name, string $href) {
        $this->name = $name;
        $this->href = $href;
    }

    public function render() {
        return sprintf(
            '<a href="%s"><span class="py-0.5 px-2 border rounded-md text-xs">%s</span></a>',
            self::escaper()->escapeHtmlAttr($this->href),
            self::escaper()->escapeHtml($this->name)
        );
    }
}