<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

use Illuminate\View\Component;
use Laminas\Escaper\Escaper;

class SolidGlyph extends Component {

    private string $name;
    private Escaper $escaper;

    public function __construct(string $name) {
        $this->name = $name;
        $this->escaper = new Escaper('utf-8');
    }

    public function render() {
        return sprintf('<i class="fas fa-%s"></i>', $this->escaper->escapeHtmlAttr($this->name));
    }
}