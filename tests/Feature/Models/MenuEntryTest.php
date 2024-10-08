<?php

use App\Models\MenuEntries;
use App\Models\MenuEntry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

it('has many links', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->links()->toBeInstanceOf(BelongsToMany::class);
});

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

it('has type', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->type->toBeString();
});

it('has created_at date', function () {
    $entry = MenuEntry::factory()->create();
    expect($entry)
        ->created_at->toBeInstanceOf(Carbon::class);
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
        ->path->toBe('example/path')
        ->menu->toBe('main')
        ->text->toBe('JHV 2014')
        ->order->toBe(null);
});

it('can be created from from markdown file with extended hugo frontmatter', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
menu:
    - name: extended syntax
      order: 3
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
        ->path->toBe('example/path')
        ->menu->toBe('extended syntax')
        ->text->toBe('JHV 2014')
        ->order->toBe(3);
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

it('assigns order 0 to _index.md if order unspecified', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
menu:
    - name: extended syntax
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;

    Storage::fake('content');
    Storage::disk('content')->put('example/_index.md', $fileContent);

    $entries = MenuEntries::fromFile('/example/_index.md');
    expect($entries)
        ->toBeArray()
        ->and($entries[0])
        ->order->toBe(0);
});

it('keeps order of _index.md if specified', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
menu:
    - name: extended syntax
      order: 2
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;

    Storage::fake('content');
    Storage::disk('content')->put('example/_index.md', $fileContent);

    $entries = MenuEntries::fromFile('/example/_index.md');
    expect($entries)
        ->toBeArray()
        ->and($entries[0])
        ->order->toBe(0)
        ->and($entries[1])
        ->order->toBe(2);
});

it('does not crash for _index file with simple menu syntax', function () {
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
    Storage::disk('content')->put('example/_index.md', $fileContent);

    $entries = MenuEntries::fromFile('/example/_index.md');
    expect($entries)
        ->toBeArray()
        ->and($entries[0])
        ->order->toBe(0);
});

it('returns empty array for no file at given path', function () {
    Storage::fake('content');
    expect(MenuEntries::fromFile('some/path'))
        ->toBeArray()
        ->toBeEmpty();
});

it('returns true when it matches the given path', function () {
    $entry = MenuEntry::factory()->state(['path' => '/path'])->create();
    expect($entry->matches('/path'))
        ->toBeTrue();
});

it('returns false when it does not match the given path', function () {
    $entry = MenuEntry::factory()->state(['path' => '/path'])->create();
    expect($entry->matches('/other'))
        ->toBeFalse();
});
