@if(isset($href))
<a class="flex tag" href="{{ $href }}">
@else
<span class="flex tag">
@endif
   <span class="py-0.5 px-2 border rounded-md text-xs {{ $class }}" >{{ $name }}</span>
@if(isset($href))
</a>
@else
</span>
@endif