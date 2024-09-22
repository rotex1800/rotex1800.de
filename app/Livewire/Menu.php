<?php

namespace App\Livewire;

use App\Models\MenuEntry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Nette\NotImplementedException;

abstract class Menu extends Component
{
    public string $menu;

    public string $currentPath;

    /**
     * @var Collection<MenuEntry>
     */
    public Collection $entries;

    public function mount(): void
    {
        $this->entries = MenuEntry::whereMenu($this->menu)
            ->orderByRaw('`order` is null')
            ->orderBy('order')
            ->orderBy('text')
            ->get();
    }

    public function render(): View|Factory|Application
    {
        throw new NotImplementedException("The render function of the Livewire Menu needs to be overridden!");
    }
}
