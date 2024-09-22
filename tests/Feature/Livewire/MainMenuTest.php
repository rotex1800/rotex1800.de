<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Menu;
use App\Models\MenuEntry;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

it('can render MainMenu', function () {
    Livewire::test(Menu::class, [
        'currentPath' => '/path',
    ])
        ->assertStatus(200);
});

it('contains top level entries with given strings', function () {
    $entries = MenuEntry::factory()
        ->count(4)
        ->create();
    Livewire::test(Menu::class, ['currentPath' => '/path'])->assertStatus(200)
        ->assertElementExists('nav', function (AssertElement $element) use ($entries) {
            foreach ($entries as $entry) {
                $element->contains('nav > ul', ['class' => 'flex-col md:flex-row flex']);
                $element->contains('nav > ul > li', ['text' => $entry->text]);
                $element->contains('nav > ul > li > a', ['href' => url($entry->path)]);
            }
        });
});

it('sorts entries by order if specified', function () {
    MenuEntry::factory()->create(['order' => 4, 'text' => 'a']);
    MenuEntry::factory()->create(['order' => 3, 'text' => 'b']);
    MenuEntry::factory()->create(['order' => 2, 'text' => 'c']);
    MenuEntry::factory()->create(['order' => 1, 'text' => 'd']);

    $menu = Livewire::test(Menu::class, ['currentPath' => '/path'])->assertStatus(200);
    /** @var Collection $entries */
    $entries = $menu->get('entries');
    expect($entries)
        ->toBeInstanceOf(Collection::class)
        ->and($entries->get(0))->text->toBe('d')
        ->and($entries->get(3))->text->toBe('a');

});

it('sorts entries by text if order not specified', function () {
    MenuEntry::factory()->create(['order' => null, 'text' => 'b']);
    MenuEntry::factory()->create(['order' => null, 'text' => 'a']);
    MenuEntry::factory()->create(['order' => null, 'text' => 'c']);
    MenuEntry::factory()->create(['order' => null, 'text' => 'd']);

    $menu = Livewire::test(Menu::class, ['currentPath' => '/path'])->assertStatus(200);
    /** @var Collection $entries */
    $entries = $menu->get('entries');
    expect($entries)
        ->toBeInstanceOf(Collection::class)
        ->and($entries->get(0))->text->toBe('a')
        ->and($entries->get(3))->text->toBe('d');
});

it('puts entries with order first', function () {
    MenuEntry::factory()->create(['order' => null, 'text' => 'b']);
    MenuEntry::factory()->create(['order' => null, 'text' => 'a']);
    MenuEntry::factory()->create(['order' => 1, 'text' => 'c']);
    MenuEntry::factory()->create(['order' => 2, 'text' => 'd']);

    $menu = Livewire::test(Menu::class, ['currentPath' => '/path'])->assertStatus(200);
    /** @var Collection $entries */
    $entries = $menu->get('entries');
    expect($entries)
        ->toBeInstanceOf(Collection::class)
        ->and($entries->get(0))->text->toBe('c')
        ->and($entries->get(1))->text->toBe('d')
        ->and($entries->get(2))->text->toBe('a')
        ->and($entries->get(3))->text->toBe('b');
});
