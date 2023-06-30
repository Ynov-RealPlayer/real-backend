<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Like;
use App\Models\Rank;
use App\Models\Role;
use App\Models\Badge;
use App\Models\Media;
use App\Models\BadgeUser;
use App\Models\Commentary;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
     * Get the user's rank.
     */
    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * Get the user's role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's badges.
     */
    public function badges()
    {
        return $this->hasMany(BadgeUser::class);
    }

    /**
     * Get the user's medias.
     */
    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Get the user's comments.
     */
    public function comments()
    {
        return $this->hasMany(Commentary::class);
    }

    /**
     * Get the user's likes that he gave.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function getPictureAttribute()
    {
        return Storage::disk('s3')->temporaryUrl(
            $this->attributes['picture'],
            now()->addMinutes(20)
        );
    }

    public function getBannerAttribute()
    {
        return Storage::disk('s3')->temporaryUrl(
            $this->attributes['banner'],
            now()->addMinutes(20)
        );
    }

}
