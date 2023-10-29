<?php

namespace App\Models;

use App\Utils;
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
        $sanitized = Utils::sanitizePath($path);
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
