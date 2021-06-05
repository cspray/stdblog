<?php declare(strict_types=1);

namespace Cspray\StdBlog\Component;

class Tag extends AbstractComponent {

    private string $name;
    private string $class;
    private ?string $href = null;

    public function __construct(string $name, string $href = null, string $class = '') {
        $this->name = $name;
        $this->class = $class;
        $this->href = $href;
    }

    public function render() {
        return <<<'blade'
@if(isset($href))
<a href="{{ $href }}">
@endif
    <span class="py-0.5 px-2 border rounded-md text-xs {{ $class }}">{{ $name }}</span>
@if(isset($href))
</a>
@endif
blade;
    }
}