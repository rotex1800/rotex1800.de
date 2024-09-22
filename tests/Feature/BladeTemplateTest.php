<?php

use App\Livewire\MainMenu;

test('"app.blade.php" contains MainMenu livewire component', function () {
    $view = $this->view('app', ['content' => 'Foo', 'path' => '/path']);
    $view->assertSeeLivewire(MainMenu::class);
});
