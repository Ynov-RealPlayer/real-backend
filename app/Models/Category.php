<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Category
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $symbol
 * @property Media[] $media
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'symbol',
    ];

    /**
     * @return BelongsToMany
     */
    public function media() : BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }
}
