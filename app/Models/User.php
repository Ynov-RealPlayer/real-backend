<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $pseudo
 * @property int $experience
 * @property string $picture
 * @property string $banner
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $description
 * @property int $rank_id
 * @property int $role_id
 * @property Rank $rank
 * @property Role $role
 * @property BadgeUser[] $badges
 * @property Media[] $medias
 * @property Commentary[] $comments
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    public function canAccessFilament(): bool
    {
        return str_ends_with($this->role_id, '1') && $this->hasVerifiedEmail();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo',
        'experience',
        'picture',
        'banner',
        'email',
        'password',
        'phone',
        'description',
        // Foreign keys
        'rank_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'refresh_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function rank() : BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * @return BelongsTo
     */
    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return HasMany
     */
    public function badges() : HasMany
    {
        return $this->hasMany(BadgeUser::class);
    }

    /**
     * @return HasMany
     */
    public function medias() : HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * @return HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Commentary::class);
    }

    /**
     * @return HasMany
     */
    public function likes() : HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * @return string
     * @noinspection PhpUnused
     */
    public function getPictureAttribute() : string
    {
        return Storage::disk('s3')->temporaryUrl(
            $this->attributes['picture'],
            now()->addMinutes(20)
        );
    }

    /**
     * @return string
     * @noinspection PhpUnused
     */
    public function getBannerAttribute() : string
    {
        return Storage::disk('s3')->temporaryUrl(
            $this->attributes['banner'],
            now()->addMinutes(20)
        );
    }

}
