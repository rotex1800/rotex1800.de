<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MainMenu extends Component
{
    /**
     * @var string[]
     */
    public array $entries = ['Hallo', 'Tschüss'];

    public function render(): View|Factory|Application
    {
        return view('livewire.main-menu', [
            'entries' => $this->entries,
        ]);
    }
}
