<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;
    protected $table = 'group';

    // Return list of group's members
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user')->get();
    }

    // Return list of group's tasks
    public function tasks()
    {
        return $this->hasMany(Todo::class)->get();
    }

    // Add user to group's members
    public function addUser(User $user)
    {
        $userGroup = new UserGroup();
        $userGroup->group_id = $this->id;
        $userGroup->user_id = $user->id;
        if (!$userGroup->isRelated()) {
            $userGroup->save();
            return true;
        } else {
            return false;
        }
    }

    // Remove user from group's members
    public function removeUser(User $user)
    {
        $userGroup = UserGroup::where('user_id', $this->user_id)->where('group_id', $this->group_id)->first();
        $userGroup->delete();
    }
}
