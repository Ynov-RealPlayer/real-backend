<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BadgeUser
 * @package App\Models
 * @property int $id
 * @property int $badge_id
 * @property int $user_id
 * @property Badge $badge
 * @property User $user
 */
class BadgeUser extends Model
{
    use HasFactory;

    protected $table = 'badge_user';

    protected $fillable = [
        'badge_id',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function badge() : BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
