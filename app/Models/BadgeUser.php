<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeUser extends Model
{
    use HasFactory;

    protected $table = 'badge_user';

    protected $fillable = [
        'badge_id',
        'user_id',
    ];

    public function badge()
    {
        return $this->belongsToMany(Badge::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}