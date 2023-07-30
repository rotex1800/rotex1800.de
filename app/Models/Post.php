<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::deleting(function (Post $post) {
            $post->links()->delete();
        });
    }

    public static function fromHugoContent(string $fileContent): Post
    {
        $file = HugoFile::fromContent($fileContent);
        $content = $file->getContent();
        $frontmatter = $file->getFrontmatter();

        $post = new Post();
        if (array_key_exists('title', $frontmatter)) {
            $post->title = $frontmatter['title'];
        }
        if (array_key_exists('date', $frontmatter)) {
            $post->published_at = Carbon::parse($frontmatter['date']);
        }
        $post->content = $content;
        $post->checksum = md5($fileContent);

        return $post;
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
