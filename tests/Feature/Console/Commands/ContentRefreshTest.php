<?php

use App\Console\Commands\ContentRefresh;
use App\Models\Link;
use App\Models\Post;
use Tests\TestData\FileContents;
use function Pest\Laravel\assertDatabaseEmpty;

it('is called using "content:refresh"', function () {
    $availableCommands = Artisan::all();
    expect($availableCommands)
        ->toBeArray()
        ->toHaveKey("content:refresh")
        ->and($availableCommands["content:refresh"])
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
