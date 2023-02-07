<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentary extends Model
{
    use HasFactory;

    protected $fillable = [
        'nb_like',
        'user_id',
        'media_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
