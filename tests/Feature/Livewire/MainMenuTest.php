<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\MainMenu;
use App\Models\MenuEntry;
use Livewire\Livewire;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can render MainMenu', function () {
    Livewire::test(MainMenu::class)
        ->assertStatus(200);
});

it('contains top level entries with given strings', function () {
    $entries = MenuEntry::factory()
        ->count(4)
        ->create();
    Livewire::test(MainMenu::class)->assertStatus(200)
        ->assertElementExists('nav', function (AssertElement $element) use ($entries) {
            foreach ($entries as $entry) {
                $element->contains('nav > ul > li', ['text' => $entry->text]);
                $element->contains('nav > ul > li > a', ['href' => url($entry->path)]);
            }
        });
});
