<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $table = 'todo';

    // Return task's user
    public function user()
    {
        return $this->belongsTo(User::class)->get()->first();
    }

    // Return task's group
    public function group()
    {
        return $this->belongsTo(Group::class)->get()->first();
    }

    // Return task's assigned user
    public function assigned()
    {
        if ($this->assigned_id != null) {
            return User::find($this->assigned_id);
        }
        return null;
    }

    // Check if user has permission to modify todo
    public function hasPerm(User $user): bool
    {
        if ($this->user_id == $user->id) return true;
        if ($this->group_id == null) return false;
        $group = Group::find($this->group_id);
        foreach ($group->users()->get() as $user) {
            if ($user->id == $this->user_id) return true;
        }
        return false;
    }
}
