<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

use Illuminate\View\Component;
use Laminas\Escaper\Escaper;

class SolidGlyph extends AbstractComponent {

    private string $name;
    private string $class;

    public function __construct(string $name, string $class = '') {
        parent::__construct();
        $this->name = $name;
        $this->class = $class;
    }

    public function render() {
        return sprintf(
            '<span class="%s"><i class="fas fa-%s"></i></span>',
            $this->escaper->escapeHtmlAttr($this->class),
            $this->escaper->escapeHtmlAttr($this->name)
        );
    }
}