<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

use Illuminate\View\Component;
use Laminas\Escaper\Escaper;

class SolidGlyph extends AbstractGlyphComponent {

    protected function getFontPrefix() : string {
        return 'fas';
    }
}