<?php

use App\Livewire\Menu;

test('"app.blade.php" contains MainMenu livewire component', function () {
    $view = $this->view('app', ['content' => 'Foo', 'path' => '/path']);
    $view->assertSeeLivewire(Menu::class);
});
