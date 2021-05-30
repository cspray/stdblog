<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class BrandGlyph extends AbstractGlyphComponent {

    protected function getFontPrefix() : string {
        return 'fab';
    }

}