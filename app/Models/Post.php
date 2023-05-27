<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    private const FRONTMATTER = 1;
    private const CONTENT = 2;

    protected $casts = [
        'published_at' => 'datetime',
    ];

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