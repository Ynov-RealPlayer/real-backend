<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Like
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $likeable_id
 * @property string $likeable_type
 * @property User $user
 * @property Model $likeable
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Like extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Foreign keys
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphTo
     * @noinspection PhpUnused
     */
    public function likeable() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param $query
     * @param Model $resource
     * @return bool
     * @noinspection PhpUnused
     */
    public function scopeWhereResource($query, Model $resource) : bool
    {
        if (!empty($resource->id)) {
            return $query->where('likeable_id', $resource->id)
                ->where('likeable_type', get_class($resource));
        }
        return false;
    }

    /**
     * @param $query
     * @param User $user
     * @return bool
     * @noinspection PhpUnused
     */
    public function scopeWhereUser($query, $user) : bool
    {
        return $query->where('user_id', $user->id);
    }
}
