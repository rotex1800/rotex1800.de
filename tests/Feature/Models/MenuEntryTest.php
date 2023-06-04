<?php

use App\Models\MenuEntries;
use App\Models\MenuEntry;

it('has text', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->text->toBeString();
});

it('has path', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->path->toBeString();
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

it('has checksum', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->checksum->toBeString();
});

it('can be created from from markdown file with hugo frontmatter', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
menu: main
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;

    Storage::fake('content');
    Storage::disk('content')->put('example/path.md', $fileContent);

    $entries = MenuEntries::fromFile('/example/path.md');
    expect($entries)
        ->toBeArray()
        ->and($entries[0])
        ->path->toBe('/example/path')
        ->menu->toBe('main')
        ->text->toBe('JHV 2014')
        ->order->toBeOne();
});

it('can be created from from markdown file with multiple menus is hugo frontmatter', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
menu: [main, secondary]
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;

    Storage::fake('content');
    Storage::disk('content')->put('example/path.md', $fileContent);

    $entries = MenuEntries::fromFile('/example/path.md');
    expect($entries)
        ->toBeArray()
        ->toHaveLength(2)
        ->and($entries[0])
        ->menu->toBe('main')
        ->and($entries[1])
        ->menu->toBe('secondary');
});

it('returns empty array for no file at given path', function () {
    Storage::fake('content');
    expect(MenuEntries::fromFile('some/path'))
        ->toBeArray()
        ->toBeEmpty();
});
