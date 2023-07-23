<?php

use App\Console\Commands\ContentRefresh;
use App\Models\Link;
use App\Models\MenuEntries;
use App\Models\MenuEntry;
use App\Models\Post;
use function Pest\Laravel\assertDatabaseEmpty;
use Tests\TestData\FileContents;

it('is called using "content:refresh"', function () {
    $availableCommands = Artisan::all();
    expect($availableCommands)
        ->toBeArray()
        ->toHaveKey('content:refresh')
        ->and($availableCommands['content:refresh'])
        ->toBeInstanceOf(ContentRefresh::class);
});

it('loads content into database', function () {

    Storage::fake('content');
    Storage::disk('content')->makeDirectory('posts');

    Storage::disk('content')->put('kalender.md', FileContents::CALENDAR_FILE);
    Storage::disk('content')->put('posts/2014-jhv.md', FileContents::JHV_POST);

    Artisan::call('content:refresh');

    $this->assertDatabaseCount(Post::class, 2);
    $this->assertDatabaseCount(Link::class, 2);

    $this->assertDatabaseHas('links', ['path' => 'kalender']);
    $this->assertDatabaseHas('links', ['path' => 'posts/2014-jhv']);
});

it('creates a relation between post and link', function () {
    // Arrange
    Storage::fake('content');
    Storage::disk('content')->makeDirectory('posts');
    Storage::disk('content')->put('kalender.md', FileContents::CALENDAR_FILE);

    // Act
    Artisan::call('content:refresh');

    // Assert
    $this->assertDatabaseCount(Post::class, 1);
    $this->assertDatabaseCount(Link::class, 1);

    $post = Post::first();
    $link = Link::first();

    expect($post->links->first())
        ->toBeSameEntityAs($link);
    expect($link->post)
        ->toBeSameEntityAs($post);
});

it('does not create duplicate entries', function () {
    // Arrange
    Storage::fake('content');
    Storage::disk('content')->makeDirectory('posts');
    Storage::disk('content')->put('kalender.md', FileContents::CALENDAR_FILE);

    // Act
    Artisan::call('content:refresh');
    Artisan::call('content:refresh');

    // Assert
    $this->assertDatabaseCount(Post::class, 1);
    $this->assertDatabaseCount(Link::class, 1);

    $this->assertDatabaseHas('links', ['path' => 'kalender']);
});

it('does not create duplicate links after changing title', function () {
    // Arrange
    Storage::fake('content');
    Storage::disk('content')->makeDirectory('posts');
    Storage::disk('content')->put('kalender.md', FileContents::EXAMPLE);

    // Act
    Artisan::call('content:refresh');
    Storage::disk('content')->put('kalender.md', FileContents::EXAMPLE_CHANGED_TITLE);
    Artisan::call('content:refresh');

    // Assert
    $this->assertDatabaseCount(Post::class, 1);
    $this->assertDatabaseCount(Link::class, 1);

    $this->assertDatabaseHas('links', ['path' => 'kalender']);
});

it('sets post checksum to md5 hash of file', function () {
    // Arrange
    Storage::fake('content');
    Storage::disk('content')->put('kalender.md', FileContents::CALENDAR_FILE);

    // Act
    Artisan::call('content:refresh');

    // Assert
    $actual = Post::first();
    expect($actual->checksum)
        ->toBe(md5_file(Storage::disk('content')->path('kalender.md')));
});

it('removes posts from database that are not read from disk', function () {
    // Arrange
    Post::factory()->count(2)->create();
    Storage::fake('content');
    Storage::disk('content')->put('kalender.md', FileContents::CALENDAR_FILE);

    // Act
    Artisan::call('content:refresh');

    // Assert
    $this->assertDatabaseCount('posts', 1);
});

it('does not create post for empty file', function () {
    // Arrange
    Storage::fake('content');
    Storage::disk('content')->put('empty.md', '');

    // Act
    Artisan::call('content:refresh');

    // Assert
    assertDatabaseEmpty('posts');
    assertDatabaseEmpty('links');
});

it('creates menu entries for files with "menu" frontmatter', function () {
    // Arrange
    Storage::fake('content');
    Storage::disk('content')->put('kalender.md', FileContents::CALENDAR_FILE);

    // Act
    Artisan::call('content:refresh');

    // Assert
    $this->assertDatabaseCount('menu_entries', 1);
    $entry = MenuEntry::where('path', '=', 'kalender')->first();
    expect($entry)
        ->not->toBeNull()
        ->checksum->toBe(md5_file(Storage::disk('content')->path('kalender.md')));
});

it('removes outdated menu entries', function () {
    // Arrange
    Storage::fake('content');
    Storage::disk('content')->put('kalender.md', FileContents::CALENDAR_FILE);
    $entries = MenuEntries::fromFile('kalender.md');
    foreach ($entries as $entry) {
        $entry->save();
    }
    MenuEntry::factory()->create();
    $this->assertDatabaseCount('menu_entries', 2);

    // Act
    Artisan::call('content:refresh');

    // Assert
    $this->assertDatabaseCount('menu_entries', 1);
    $entry = MenuEntry::where('path', '=', 'kalender')->first();
    expect($entry)
        ->not->toBeNull()
        ->path->toBe('kalender');
});
