<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MenuEntry
 *
 * @property int $id
 * @property string $text
 * @property string $path
 * @property string $menu
 * @property int $order
 * @property string $checksum
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\MenuEntryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry whereChecksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry whereMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry whereUpdatedAt($value)
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|MenuEntry whereType($value)
 * @mixin \Eloquent
 */
class MenuEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'menu',
        'text',
        'order',
        'checksum',
        'type',
    ];

    public function matches(string $string): bool
    {
        return preg_match('^' . $this->path . '^', $string) != false;
    }
}
