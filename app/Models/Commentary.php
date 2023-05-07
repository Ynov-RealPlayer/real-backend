<?php

namespace App\Models;

use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentary extends Model
{
    use HasFactory;

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
        return Like::where('resource_id', $this->id)->where('resource_type', 'App\Models\Commentary')->count();
    }

    public function hasLiked()
    {
        $user_id = auth()->user()->id;
        return Like::where('resource_id', $this->id)->where('resource_type', 'App\Models\Commentary')->where('user_id', $user_id)->count() > 0 ? true : false;
    }
}
