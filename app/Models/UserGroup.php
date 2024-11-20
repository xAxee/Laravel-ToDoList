<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'group_user';
    public $timestamps = false;
    use HasFactory;

    // Check if relationship exists
    public function isRelated()
    {
        return UserGroup::where('user_id', $this->user_id)->where('group_id', $this->group_id)->count() != 0;
    }
}
