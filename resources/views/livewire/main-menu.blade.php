<div>
    <nav class="bg-blue-500">
        <ul class="flex flex-col md:flex-row">
            @foreach($entries as $entry)
                <li class="text-white text-lg block w-fit p-2 hover:underline transition-all duration-200 ease-in-out"><a href={{ url($entry->path) }}>{{ $entry->text }}</a></li>
            @endforeach
        </ul>
    </nav>
</div>
