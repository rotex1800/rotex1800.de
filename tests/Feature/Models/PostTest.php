<?php

use App\Models\Post;
use Carbon\Carbon;

it('has title', function () {
    expect(Post::factory()->create())
        ->title->toBeString();
});

it('has a published date', function () {
    expect(Post::factory()->create())
        ->published_at->toBeInstanceOf(Carbon::class);
});

it('has content', function () {
    expect(Post::factory()->create())
        ->content->toBeString();
});

it('has checksum', function () {
    expect(Post::factory()->create())
        ->checksum->toBeString();
});

it('can be created from markdown file with hugo frontmatter', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;
    $post = Post::fromHugo($fileContent);

    expect($post)
        ->content->toBe('Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!')
        ->title->toBe('JHV 2014')
        ->and($post->published_at->equalTo(Carbon::parse('2014-08-10')))->toBeTrue();
});

it('can deal with unknown keys when creating from file with hugo frontmatter', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
unknown-key: and-value
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;
    $post = Post::fromHugo($fileContent);
    expect($post)->toBeInstanceOf(Post::class);
});

it('has function to calculate checksum', function () {
    $post = Post::factory()->make();
    $post->checksum = null;
    expect($post->checksum)->toBeNull()
        ->and(method_exists($post, 'updateChecksum'))
        ->toBeTrue();

    $post->updateChecksum();
    expect($post->checksum)
        ->not->toBeNull()
        ->toBeString();

});

it('sets checksum when creating through fromHugo method', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
unknown-key: and-value
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;
    $post = Post::fromHugo($fileContent);
    expect($post)
        ->checksum->toBeString();
});

it('updates checksum when saving', function () {
    $post = Post::factory()->create();
    $beforeChecksum = $post->checksum;

    $post->title = "Foo";
    $post->save();

    $afterChecksum = $post->checksum;

    expect($beforeChecksum)
        ->not->toBe($afterChecksum);
});
