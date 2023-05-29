<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    public function getRouteKeyName(): string
    {
        return 'path';
    }

    public static function fromFilePath(string $path): self
    {
        $sanitized = preg_replace(pattern: '/\\.md$/', replacement: '', subject: $path);
        return new Link(['path' => $sanitized]);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
