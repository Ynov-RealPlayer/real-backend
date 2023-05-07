<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Category;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Media extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'media';

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return Like::where('resource_id', $this->id)->where('resource_type', 'App\Models\Media')->count();
    }
}
