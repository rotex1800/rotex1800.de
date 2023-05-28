<?php

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;

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

it('sets date to null if missing', function () {
    $fileContent = <<<'EOD'
---
title: JHV 2014
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;
    $post = Post::fromHugo($fileContent);
    expect($post)
        ->published_at->toBeNull();
});

it('sets title to null if missing', function () {
    $fileContent = <<<'EOD'
---
date: 2023-06-09
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;
    $post = Post::fromHugo($fileContent);
    expect($post)
        ->title->toBeNull();
});

it('has index on checksum column', function () {
    Schema::table('posts', function (Blueprint $blueprint) {
        $schemaManager = Schema::getConnection()->getDoctrineSchemaManager();
        $indexes = $schemaManager->listTableIndexes('posts');

        $foundIndex = array_key_exists("posts_checksum_index", $indexes);

        expect($foundIndex)->toBeTrue();
    });
});
