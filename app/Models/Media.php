<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Category;
use App\Models\Commentary;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Media extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'media';

    protected $appends = ['nb_likes', 'has_liked'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Commentary::class);
    }

    public function getUrlAttribute($value)
    {
        return Storage::disk('s3')->temporaryUrl(
            $value,
            now()->addMinutes(20)
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function getNbLikesAttribute()
    {
        return $this->likes()->count();
    }

    public function getHasLikedAttribute()
    {
        return $this->likes()->where('user_id', auth()->user()->id)->count() > 0 ? true : false;
    }
}
