<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

class Group extends Model
{
    use HasFactory;

    protected $table = 'group';

    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'invite_link'
    ];

    protected $casts = [
        'owner_id' => 'integer'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

    public function getAllUsers(): Collection
    {
        return $this->users()->get();
    }

    public function getAllTasks(): Collection
    {
        return $this->tasks()->get();
    }

    public function addUser(User $user): bool
    {
        if ($this->users()->where('users.id', $user->id)->exists()) {
            return false;
        }

        $this->users()->attach($user->id);
        return true;
    }

    public function removeUser(User $user): bool
    {
        if (!$this->users()->where('users.id', $user->id)->exists()) {
            return false;
        }

        $this->users()->detach($user->id);
        return true;
    }

    public function isOwner(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    public function isMember(User $user): bool
    {
        return $this->users()->where('users.id', $user->id)->exists();
    }

    public function regenerateInviteLink(): void
    {
        $this->update([
            'invite_link' => \Illuminate\Support\Str::random(10)
        ]);
    }
}
