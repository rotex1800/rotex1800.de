<?php

use App\Console\Commands\ContentWipe;
use App\Models\Link;
use App\Models\Post;

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;

it('is called using "content:wipe"', function () {
    $availableCommands = Artisan::all();
    expect($availableCommands)
        ->toBeArray()
        ->toHaveKey('content:wipe')
        ->and($availableCommands['content:wipe'])
        ->toBeInstanceOf(ContentWipe::class);
});

it('removes all posts and links from database', function () {
    Post::factory(4)
        ->has(Link::factory())
        ->create();

    \App\Models\MenuEntry::factory(4)->create();

    assertDatabaseCount('posts', 4);
    assertDatabaseCount('links', 4);
    assertDatabaseCount('menu_entries', 4);

    artisan('content:wipe')
        ->expectsChoice(
            'Do you really want to delete all content?',
            'yes',
            ['no', 'yes']
        )
        ->assertExitCode(0);

    assertDatabaseCount('posts', 0);
    assertDatabaseCount('links', 0);
    assertDatabaseCount('menu_entries', 0);
});

it('skips confirmation when using force flag', function () {
    Post::factory(4)
        ->has(Link::factory())
        ->create();

    MenuEntry::factory(4)->create();

    assertDatabaseCount('posts', 4);
    assertDatabaseCount('links', 4);
    assertDatabaseCount('menu_entries', 4);

    artisan('content:wipe', ['--force' => true])
        ->assertExitCode(0);

    assertDatabaseCount('posts', 0);
    assertDatabaseCount('links', 0);
    assertDatabaseCount('menu_entries', 0);
});
