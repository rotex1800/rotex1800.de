<?php

use App\Models\Link;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

it('belongs to one post', function () {
    $link = new Link;
    expect($link->post())
        ->toBeInstanceOf(BelongsTo::class);
});

it('has many menus entries', function () {
    $link = new Link;
    expect($link->menusEntries())
        ->toBeInstanceOf(BelongsToMany::class);
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
    $indexes = Schema::getIndexes('links');
    $filtered = array_filter($indexes, function ($element) {
       return $element['name'] == 'links_path_index';
    });
    expect($filtered)->not->toBeEmpty();
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
