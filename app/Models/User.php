<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    public function canAccessFilament(): bool
    {
        return str_ends_with($this->role_id, '0') && $this->hasVerifiedEmail();
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
        'media_id',
        'badge_id',
        'commentary_id',
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
        return $this->hasOne(Rank::class);
    }

    /**
     * Get the user's role.
     */
    public function role()
    {
        return $this->hasOne(Role::class);
    }

    /**
     * Get the user's badges.
     */
    public function badges()
    {
        return $this->hasMany(Badge::class);
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
        return $this->hasMany(Comment::class);
    }

}
