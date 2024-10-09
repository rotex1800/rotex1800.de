<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rotex 1800 e.V.</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>
<livewire:main-menu current-path="{{ $path }}"/>
<div class="prose max-w-none pt-8">
    @isset($title)
        <h1 class="ms-56 text-center">{{ $title }}</h1>
    @endisset
    <div class="flex flex-row w-full">
        @isset($categoryMenu)
            <div class="">
                <livewire:category-menu current-path="{{ $path }}" menu="{{ $categoryMenu }}"/>
            </div>
        @endisset
        <div id="content" class="justify-center prose p-4 mx-auto">
            {!! $content !!}
        </div>
        @livewireScripts
    </div>
</div>
</body>
</html>
