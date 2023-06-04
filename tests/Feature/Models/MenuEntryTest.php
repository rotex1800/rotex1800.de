<?php

use App\Models\MenuEntry;

it('has text', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->text->toBeString();
});

it('has href', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->href->toBeString();
});

it('has menu', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->menu->toBeString();
});

it('has order', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->order->toBeNumeric();
});
