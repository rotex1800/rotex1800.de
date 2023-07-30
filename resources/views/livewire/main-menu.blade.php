<div>
    <nav class="bg-blue-500 p-2">
        <ul class="flex flex-col md:flex-row gap-2">
            @foreach($entries as $entry)
                <li class="{{ $entry->matches($currentPath) ? "bg-blue-400" : ""}} rounded text-white text-lg block w-fit p-2 hover:underline transition-all duration-200 ease-in-out">
                    <a href={{ url($entry->path) }}>{{ $entry->text }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
</div>
