<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Commentary
 * @package App\Models
 * @property int $id
 * @property string $content
 * @property int $media_id
 * @property int $user_id
 * @property User $user
 * @property Media $media
 * @property Like[] $likes
 * @property int $nb_likes
 * @property bool $has_liked
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Commentary extends Model
{
    use HasFactory;

    protected $appends = ['nb_likes', 'has_liked'];

    protected $fillable = [
        'content',
        // Foreign keys
        'media_id',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function media() : BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    /**
     * @return MorphMany
     */
    public function likes() : MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * @return int
     * @noinspection PhpUnused
     */
    public function getNbLikesAttribute(): int
    {
        return $this->likes()->count();
    }

    /**
     * @return bool
     * @noinspection PhpUnused
     */
    public function getHasLikedAttribute() : bool
    {
        return $this->likes()->where('user_id', auth()->user()->id)->count() > 0;
    }
}
