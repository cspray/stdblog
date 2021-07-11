@extends('_layouts.<<LAYOUT>>')
@section('body')
    <div class="w-9/12 mx-auto">
        <p>
            Posts tagged <x-tag name="<<TAG>>" class="dark:bg-gray-300 dark:text-black" />
            @includeIf("_descriptions.tags.<<TAG>>")
        </p>
    </div>

    <x-blog-post-card-list class="w-9/12 mx-auto" :page="$page" :posts="$posts" filterByTag="<<TAG>>" />
@endsection
