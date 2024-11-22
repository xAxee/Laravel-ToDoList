<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todo';

    public const STATUS_TODO = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_DONE = 3;

    protected $fillable = [
        'title',
        'description',
        'task_status',
        'user_id',
        'group_id',
        'assigned_id'
    ];

    protected $casts = [
        'task_status' => 'integer',
        'user_id' => 'integer',
        'group_id' => 'integer',
        'assigned_id' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }

    public function hasPerm(User $user): bool
    {
        if ($this->user_id === $user->id) {
            return true;
        }

        if ($this->group_id === null) {
            return false;
        }

        return $this->group
            ->users()
            ->where('users.id', $user->id)
            ->exists();
    }

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_TODO => 'Do zrobienia',
            self::STATUS_IN_PROGRESS => 'W trakcie',
            self::STATUS_DONE => 'Ukończone'
        ];
    }
}
