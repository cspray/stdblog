<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class CaptionedImage extends AbstractComponent {

    public string $src;
    public string $alt;
    public string $caption;
    public string $figureClass;
    public string $class;

    public function __construct(
        string $src,
        string $alt,
        string $caption,
        string $figureClass = '',
        string $class = ''
    ) {
        parent::__construct();
        $this->src = $src;
        $this->alt = $alt;
        $this->caption = $caption;
        $this->figureClass = $figureClass;
        $this->class = $class;
    }

    protected function getTemplateName(): string {
        return 'captioned-image';
    }
}