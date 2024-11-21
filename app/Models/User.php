<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Return list of user's all tasks
    public function tasks()
    {
        return $this->hasMany(Todo::class);
    }

    // Return list of user's groups
    public function groups()
    {
        $groups = $this->belongsToMany(Group::class, 'group_user')->get();
        if(sizeof($groups) == 0){
            
            $g = new Group();
            $g->name = "Prywatna lista";
            $g->description = "Prywatna lista zadań do zrobienia";
            $g->owner_id = $this->id;
            $g->invite_link = Str::random(10);
            $g->save();
            $g->addUser($this);
            $groups = $this->belongsToMany(Group::class, 'group_user')->get();
        }
        return $groups;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
