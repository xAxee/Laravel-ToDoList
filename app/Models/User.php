<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

    public function groupsRelation(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_user')
            ->orderBy('created_at');
    }

    public function groups(): Collection
    {
        $groups = $this->groupsRelation()->get();
        
        if ($groups->isEmpty()) {
            DB::transaction(function () use (&$groups) {
                $group = Group::create([
                    'name' => 'Prywatna lista',
                    'description' => 'Prywatna lista zadań do zrobienia',
                    'owner_id' => $this->id,
                    'invite_link' => Str::random(10)
                ]);

                $group->addUser($this);
                $groups = $this->groupsRelation()->get();
            });
        }

        return $groups;
    }

    public function getAllTasks(): Collection
    {
        return $this->tasks()->get();
    }

    public function ownedGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'owner_id');
    }

    public function isGroupOwner(Group $group): bool
    {
        return $this->id === $group->owner_id;
    }

    public function isMemberOf(Group $group): bool
    {
        return $this->groupsRelation()
            ->where('group_id', $group->id)
            ->exists();
    }
}
