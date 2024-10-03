<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string|null $title
 * @property string $content
 * @property string $checksum
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Link> $links
 * @property-read int|null $links_count
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereChecksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    /**
     * @return HasMany<Link>
     */
    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
