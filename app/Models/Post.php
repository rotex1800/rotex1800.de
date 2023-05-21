<?php

namespace App\Models;

use Carbon\Carbon;

class Post
{
    private const FRONTMATTER = 1;

    private const CONTENT = 2;

    public string $title = '';

    public string $content = '';

    public Carbon $publishedAt;

    public static function fromHugo(string $hugoFile): Post
    {
        $post = new Post();

        $components = explode('---', $hugoFile);
        $content = trim($components[self::CONTENT]);
        $frontmatter = yaml_parse($components[self::FRONTMATTER]);
        $post->title = $frontmatter['title'];
        $post->publishedAt = Carbon::parse($frontmatter['date']);
        $post->content = $content;

        return $post;
    }
}
