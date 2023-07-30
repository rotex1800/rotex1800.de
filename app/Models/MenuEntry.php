<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'menu',
        'text',
        'order',
        'checksum',
    ];

    public function matches(string $string): bool
    {
        return preg_match('^'.$this->path.'^', $string) != false;
    }
}
