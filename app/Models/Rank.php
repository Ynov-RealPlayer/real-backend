<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Rank
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $experience_cap
 * @property string $description
 * @property string $color
 * @property string $icon
 * @property User[] $users
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Rank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'experience_cap',
        'description',
        'color',
        'icon',
    ];

    /**
     * @return BelongsToMany
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
