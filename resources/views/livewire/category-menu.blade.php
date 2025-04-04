<nav class="w-56">
    <ul class="flex flex-col gap-2 m-2">
        @foreach($entries as $entry)
            <li class="list-none first:gap-0 first:mb-0 first:text-xl text-sm">
                @if(str_ends_with($currentPath, $entry->path))
                    <mark
                        class="box-decoration-clone -mx-2 px-2 bg-transparent rounded-tl-3xl rounded-br-3xl rounded-bl-lg rounded-tr-lg
                        bg-gradient-to-r from-yellow-200 from-0% via-yellow-300 via-5% to-lime-200">
                        @endif
                        <a class="no-underline"
                           href={{ url($entry->path) }}>{{ $entry->text }}</a>
                        @if(str_ends_with($currentPath, $entry->path))
                    </mark>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
