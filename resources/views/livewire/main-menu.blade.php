<div>
    <menu>
        @foreach($entries as $entry)
            <li><a href={{ url($entry->path) }}>{{ $entry->text }}</a></li>
        @endforeach
    </menu>
</div>
