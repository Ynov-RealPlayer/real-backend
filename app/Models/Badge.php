<?php

namespace App\Models;

use App\Models\User;
use App\Models\BadgeUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function users()
    {
        return $this->hasMany(BadgeUser::class);
    }
}
