<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Foreign keys
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likeable()
    {
        return $this->morphTo();
    }

    public function scopeWhereResource($query, $resource)
    {
        return $query->where('likeable_id', $resource->id)
            ->where('likeable_type', get_class($resource));
    }

    public function scopeWhereUser($query, $user)
    {
        return $query->where('user_id', $user->id);
    }
}
