<?php

use App\Http\Livewire\MainMenu;

test('"app.blade.php" contains MainMenu livewire component', function () {
    $view = $this->view('app', ['content' => 'Foo']);
    $view->assertSeeLivewire(MainMenu::class);
});
