<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Yaml\Yaml;

class Post extends Model
{
    use HasFactory;

    private const FRONTMATTER = 1;

    private const CONTENT = 2;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::deleting(function (Post $post) {
            $post->links()->delete();
        });
    }

    public static function fromHugo(string $hugoFile): Post
    {
        $post = new Post();

        $components = explode('---', $hugoFile);
        $content = trim($components[self::CONTENT]);
        $frontmatter = (array) Yaml::parse($components[self::FRONTMATTER]);

        if (array_key_exists('title', $frontmatter)) {
            $post->title = $frontmatter['title'];
        }
        if (array_key_exists('date', $frontmatter)) {
            $post->published_at = Carbon::parse($frontmatter['date']);
        }
        $post->content = $content;

        $post->checksum = md5($hugoFile);

        return $post;
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
