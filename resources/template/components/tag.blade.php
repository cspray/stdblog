@if(isset($href))
<a href="{{ $href }}">
@endif
   <span class="py-0.5 px-2 border rounded-md text-xs {{ $class }}" >{{ $name }}</span>
@if(isset($href))
</a>
@endif