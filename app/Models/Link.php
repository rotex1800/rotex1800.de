<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property string $path
 * @property int $post_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post|null $post
 *
 * @method static \Database\Factories\LinkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Link whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Link extends Model implements HasPath
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];

    public static function fromFilePath(string $path): self
    {
        $noMdFileExtension = preg_replace(pattern: '/\\.md$/', replacement: '', subject: $path);
        $noIndex = preg_replace('/_index$/', '', $noMdFileExtension);
        $noStartingSlash = preg_replace('/^\\//', '', $noIndex);

        $sanitized = preg_replace('/\\/$/', '', $noStartingSlash);
        if ($sanitized == '') {
            $sanitized = '/';
        }
        return new Link(['path' => $sanitized]);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function path(): string
    {
        return $this->path;
    }


}
