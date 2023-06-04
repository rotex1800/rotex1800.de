<div>
    <menu>
        @foreach($entries as $entry)
            <li>{{ $entry->text }}</li>
        @endforeach
    </menu>
</div>
