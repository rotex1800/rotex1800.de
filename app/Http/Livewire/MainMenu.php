<?php

namespace App\Http\Livewire;

use App\Models\MenuEntry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class MainMenu extends Component
{
    public string $menu = 'main';

    public string $currentPath;

    /**
     * @var Collection<MenuEntry>
     */
    public Collection $entries;

    public function mount(): void
    {
        $this->entries = MenuEntry::whereMenu($this->menu)->get();
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.main-menu', [
            'entries' => $this->entries,
            'currentPath' => $this->currentPath,
        ]);
    }
}
