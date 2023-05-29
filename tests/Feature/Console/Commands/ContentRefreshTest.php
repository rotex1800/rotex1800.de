<?php

use App\Console\Commands\ContentRefresh;
use App\Models\Post;
use Tests\TestData\FileContents;

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

    expect(Post::all()->count())->toEqual(2);
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