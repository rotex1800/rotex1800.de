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
<div id="content" class="prose p-4">
{!! $content !!}
</div>
@livewireScripts
</body>
</html>
