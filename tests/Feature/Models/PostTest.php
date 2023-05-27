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
        ->and($post->publishedAt->equalTo(Carbon::parse('2014-08-10')))->toBeTrue();
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
