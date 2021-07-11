<?php declare(strict_types=1);

namespace Cspray\StdBlog\Configuration;

use Cspray\StdBlog\Component\BrandGlyph;
use Cspray\StdBlog\Component\CaptionedImage;
use Cspray\StdBlog\Component\SolidGlyph;
use Cspray\StdBlog\Component\Tag;
use Illuminate\View\Compilers\BladeCompiler;

class ComponentConfig {

    public function registerComponents(BladeCompiler $bladeCompiler) {
        $bladeCompiler->component(SolidGlyph::class);
        $bladeCompiler->component(BrandGlyph::class);
        $bladeCompiler->component(Tag::class);
        $bladeCompiler->component(CaptionedImage::class);
    }

}