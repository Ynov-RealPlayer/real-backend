<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
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
