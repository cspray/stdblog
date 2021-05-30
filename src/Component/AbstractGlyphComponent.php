<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

abstract class AbstractGlyphComponent extends AbstractComponent {

    private string $name;
    private string $size;
    private string $class;

    public function __construct(string $name, string $size = '', string $class = '') {
        $this->name = $name;
        $this->size = $size;
        $this->class = $class;
    }

    final public function render() {
        if (empty($this->size)) {
            $fontClassString = sprintf(
                '%s fa-%s',
                self::escaper()->escapeHtmlAttr($this->getFontPrefix()),
                self::escaper()->escapeHtmlAttr($this->name)
            );
        } else {
            $fontClassString = sprintf(
                '%s fa-%s fa-%s',
                self::escaper()->escapeHtmlAttr($this->getFontPrefix()),
                self::escaper()->escapeHtmlAttr($this->name),
                self::escaper()->escapeHtmlAttr($this->size)
            );
        }
        return sprintf(
            '<span class="%s"><i class="%s"></i></span>',
            self::escaper()->escapeHtmlAttr($this->class),
            $fontClassString
        );
    }

    abstract protected function getFontPrefix() : string;
}