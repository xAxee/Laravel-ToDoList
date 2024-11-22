<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserGroup extends Model
{
    use HasFactory;

    protected $table = 'group_user';
    
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'group_id'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'group_id' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function isRelated(): bool
    {
        return static::where('user_id', $this->user_id)
            ->where('group_id', $this->group_id)
            ->exists();
    }

    public static function isUserInGroup(int $userId, int $groupId): bool
    {
        return static::where('user_id', $userId)
            ->where('group_id', $groupId)
            ->exists();
    }
}
