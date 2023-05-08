<?php
/** @var \Cspray\StdBlog\Model\AtomFeed $atomFeed */
/** @var \Cspray\StdBlog\Model\AtomEntry $entry */
?>
<\?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <id>{{ $atomFeed->getId() }}</id>
    <title>{{ $atomFeed->getTitle() }}</title>
    <updated>{{ $atomFeed->getUpdated() }}</updated>
    <link href="{{ $atomFeed->getBlogUrl() }}" />
    <link href="{{ $atomFeed->getFeedUrl() }}" rel="self" />
    <rights>Copyright (c) 2023 Charles Sprayberry</rights>
    <generator uri="https://github.com/cspray/stdblog" version="0.1.0">
        cspray/stdblog
    </generator>

    @foreach($atomFeed as $entry)
        <entry>
            <title>{{ $entry->getTitle() }}</title>
            <id>{{ $entry->getId() }}</id>
            <published>{{ $entry->getUpdated() }}</published>
            <author>
                <name>{{ $entry->getAuthor()->getName() }}</name>
            </author>
            <content type="xhtml" xml:lang="en">
                {!! $entry->getContent() !!}
            </content>
        </entry>
    @endforeach
</feed>


