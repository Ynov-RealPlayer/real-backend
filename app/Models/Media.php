<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Media
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $media_type
 * @property string $url
 * @property int $duration
 * @property int $category_id
 * @property int $user_id
 * @property Category $category
 * @property User $user
 * @property Like[] $likes
 * @property int $nb_likes
 * @property bool $has_liked
 * @property int $nb_comments
 * @property Commentary[] $comments
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Media extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'media';

    protected $appends = [
        'nb_likes',
        'has_liked',
        'nb_comments',
    ];

    protected $fillable = [
        'name',
        'description',
        'media_type',
        'url',
        'duration',
        // Foreign keys
        'category_id',
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
     * @return HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Commentary::class);
    }

    /**
     * @param $value
     * @return string
     * @noinspection PhpUnused
     */
    public function getUrlAttribute($value) : string
    {
        return Storage::disk('s3')->temporaryUrl(
            $value,
            now()->addMinutes(20)
        );
    }

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
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
    public function getNbLikesAttribute() : int
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

    /**
     * @return int
     * @noinspection PhpUnused
     */
    public function getNbCommentsAttribute() : int
    {
        return $this->comments()->count();
    }
}
