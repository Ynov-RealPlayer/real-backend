<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'experience_cap',
        'description',
        'color',
        'icon',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
