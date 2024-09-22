<?php

namespace App\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MainMenu extends Menu
{
    public function boot(): void
    {
        $this->menu = 'main';
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.main-menu', [
            'entries' => $this->entries,
            'currentPath' => $this->currentPath,
        ]);
    }
}
