<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class SolidGlyph extends AbstractGlyphComponent {

    protected function getFontPrefix() : string {
        return 'fas';
    }
}