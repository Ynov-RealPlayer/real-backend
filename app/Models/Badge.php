<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Badge
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property BadgeUser[] $users
 */
class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(BadgeUser::class);
    }
}
