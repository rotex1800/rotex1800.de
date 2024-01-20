<?php

use App\Models\Link;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

it('belongs to one post', function () {
    $link = new Link();
    expect($link->post())
        ->toBeInstanceOf(BelongsTo::class);
});

it('has path', function () {
    $link = Link::factory()
        ->for(Post::factory())
        ->create(['path' => 'path']);
    expect($link)
        ->path->toBeString()
        ->path->toBe('path');
});

test('has index on path column', function () {
    $schemaManager = Schema::getConnection()->getDoctrineSchemaManager();
    $indexes = $schemaManager->listTableIndexes('links');
    expect(array_key_exists('links_path_index', $indexes))
        ->toBeTrue();
});

it('can be created from file path', function () {
    $link = Link::fromFilePath('/posts/über-uns.md');
    expect($link->path)
        ->toBe('posts/über-uns');
});

it('uses directory root for _index.md files', function () {
    $link = Link::fromFilePath('/posts/_index.md');

    expect($link)
        ->path->toBe('posts');
});

it('uses / for _index in root', function () {
    $link = Link::fromFilePath('_index.md');

    expect($link)
        ->path->toBe('/');
});
