<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\MainMenu;
use Livewire\Livewire;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can render MainMenu', function () {
    Livewire::test(MainMenu::class)
        ->assertStatus(200);
});

it('contains top level entries with given strings', function () {
    $expectedEntries = [
        'Posts', 'Über uns', 'Kalender', 'Downloads'
    ];
    Livewire::test(MainMenu::class, [
        'entries' => $expectedEntries
    ])
        ->assertStatus(200)
        ->assertElementExists('menu', function (AssertElement $element) use ($expectedEntries) {
            foreach ($expectedEntries as $entry) {
                $element->contains('li', [
                    'text' => $entry
                ]);
            }
        });
});
