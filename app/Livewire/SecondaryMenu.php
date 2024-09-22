<?php

namespace App\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SecondaryMenu extends Menu
{

    public string $menu;

    public function render(): View|Factory|Application
    {
        return view('livewire.secondary-menu', [
            'entries' => $this->entries,
            'currentPath' => $this->currentPath,
        ]);
    }
}
