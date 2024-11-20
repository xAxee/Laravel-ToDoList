<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Group;
use App\Models\Todo;
use App\Models\UserGroup;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    // Authentication
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Return group's list view
    public function Index()
    {
        $user = User::find(Auth::id());
        $groups = $user->groups();

        return view('group.index', ['groups' => $groups]);
    }

    // Return list of tasks
    public function Tasks(int $id)
    {
        $group = Group::find($id);
        $tasks = $group->tasks();

        return (new TaskController)->List($tasks, $group);
    }

    // Return settings view
    public function Settings(int $id)
    {
        $user = User::find(Auth::id());
        $group = Group::find($id);

        if ($group == null) abort(404);
        if ($group->owner_id != $user->id) abort(403);

        return view('group.settings', ['group' => $group, 'allUsers' => User::all()]);
    }

    // Store group
    public function Store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:100', 'min:1'],
            'description' => ['required', 'max:1500', 'min:1']
        ]);
        $user = User::find(Auth::id());

        // Create a new Group
        $group = new Group();
        $group->name = $request->title;
        $group->description = $request->description;
        $group->owner_id = $user->id;
        $group->invite_link = Str::random(10);
        $group->save();

        $group->addUser($user);

        return redirect()->back()->with(['message' => 'Poprawnie dodano grupe']);
    }

    // Delete group
    public function Delete(int $id)
    {
        $group = Group::find($id);
        $group->delete();

        return redirect()->route('group')->with(['message' => 'Poprawnie usunięto grupe']);
    }

    // Edit group
    public function Edit(int $id, Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:100', 'min:1'],
            'description' => ['required', 'max:1500', 'min:1']
        ]);
        $user = User::find(Auth::id());
        $group = Group::find($id);

        if ($group == null) abort(404);
        if ($group->owner_id != $user->id) abort(403);

        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();
        return redirect()->back()->with(['message' => 'Poprawnie edytowano grupe']);
    }

    // Assign user logic
    public function Assign(int $id, Request $request)
    {
        $todo = Todo::find($request->todo_id);
        $user = User::where('email', '=', $request->email)->first();
        if ($user == null) {
            $todo->assigned_id = null;
            $todo->save();
            return redirect()->back();
        }
        $todo->assigned_id = $user->id;
        $todo->save();
        return redirect()->back();
    }

    // Invite logic
    public function Invite(string $invite)
    {
        $group = Group::where('invite_link', $invite)->first();
        $user = User::find(Auth::id());
        if ($group == null || $user == null) return redirect()->route('home');

        if ($group->addUser($user)) {
            return redirect()->route('group')->with(['message' => 'Poprawnie dołączono do grupy']);
        } else {
            return redirect()->route('group')->with(['message' => 'Jesteś już w tej grupue', 'alert' => 'info']);
        }
    }

    // Add user logic
    public function AddUser(int $id, Request $request)
    {
        $group = Group::find($id);
        $addUser = User::where('email', $request->email)->get()->first();
        if ($addUser == null || $group == null) {
            return redirect()->back()->withErrors(['errors' => 'Błąd grupy lub użytkownika']);
        }

        if ($group->addUser($addUser)) {
            return redirect()->back()->with(['message' => 'Poprawnie dodano członka']);
        } else {
            return redirect()->back()->with(['message' => 'Ta osoba już jest członkiem', 'alert' => 'info']);
        }
    }

    // Remove user logic
    public function RemoveUser(int $id, Request $request)
    {
        $user_group = UserGroup::where('user_id', $request->user_id)->where('group_id', $id)->first();
        if ($user_group == null) {
            return redirect()->back()->withErrors(['errors' => 'Błąd grupy lub użytkownika']);
        }

        $user_group->delete();

        return redirect()->back()->with(['message' => 'Poprawnie usunięto członka']);
    }
}
