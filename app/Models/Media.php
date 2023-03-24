<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'nb_like',
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
}
