<?php

namespace App\Models;

use Carbon\Carbon;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;
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
 * @property string $device_token
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
        //'device_token',
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

    protected $appends = [
        'next_rank',
        'xp_progress',
        'bar_colors',
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
     * @return Rank
     * @noinspection PhpUnused
     */
    public function getNextRankAttribute() : Rank
    {
        $rank = Rank::where('id', $this->rank_id + 1)->first();
        if (!$rank) {
            return $this->rank;
        }
        return $rank;
    }

    /**
     * @return float
     * @noinspection PhpUnused
     */
    public function getXpProgressAttribute(): float
    {
        $next_rank = $this->next_rank;
        if (!$next_rank) {
            $next_rank = $this->rank;
        }
        $experience_cap = $next_rank->experience_cap;
        $xp = $this->experience;
        return $xp / $experience_cap;
    }

    public function getBarColorsAttribute(): array
    {
        $next_rank = $this->next_rank;
        if (!$next_rank) {
            $next_rank = $this->rank;
        }
        $experience_cap = $next_rank->experience_cap;
        $xp = $this->experience;
        $percent = $xp / $experience_cap;
        if ($percent < 0.20) {
            return [255, 40, 0];
        } elseif ($percent < 0.40) {
            return [255, 80, 0];
        } elseif ($percent < 0.60) {
            return [255, 120, 0];
        } elseif ($percent < 0.80) {
            return [255, 160, 0];
        } else {
            return [255, 200, 0];
        }
    }

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
