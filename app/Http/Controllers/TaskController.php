<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function __construct()
    {
        // Authentication
        $this->middleware('auth');
    }

    // Przekierowanie do widoku grup
    public function Index()
    {
        return redirect()->route('group');
    }

    // Return todo list view
    public function List($tasks, $group = null)
    {
        return View("todo.index", [
            'group' => $group,
            'count' => $tasks->count(),
            'first' => $tasks->where("task_status", "=", 1),
            'second' => $tasks->where("task_status", "=", 2),
            'third' => $tasks->where("task_status", "=", 3)
        ]);
    }

    // Store new task
    public function Store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:100', 'min:1'],
            'description' => ['required', 'max:1500', 'min:1'],
            'status' => ['required'],
            'group_id' => ['required'] // Dodany wymóg grupy
        ]);

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->task_status = $request->status;
        $todo->user_id = Auth::id();
        $todo->group_id = $request->group_id;
        $todo->save();
        
        if($request->assign != null){
            return redirect()->route('group.user.assign', ['id' => $request->group_id, 'email' => $request->assign, 'todo_id' => $todo->id]);
        }
        return redirect()->route('group.list', $todo->group_id);
    }

    // Edit task
    public function Edit(int $id, Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:100', 'min:1'],
            'description' => ['required', 'max:1500', 'min:1'],
            'status' => ['required'],
            'group_id' => ['required'] // Dodany wymóg grupy
        ]);

        $todo = Todo::find($id);
        $user = User::find(Auth::id());
        if ($todo == null || $user == null) abort(404);
        if (!$todo->hasPerm($user)) abort(403);

        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->task_status = $request->status;
        $todo->group_id = $request->group_id;
        $todo->save();
        
        return redirect()->route('group.list', $todo->group_id);
    }

    // Delete task
    public function Delete(int $id, Request $request)
    {
        $todo = Todo::find($id);
        $user = User::find(Auth::id());
        if ($todo == null || $user == null) abort(404);
        if (!$todo->hasPerm($user)) abort(403);

        $group_id = $todo->group_id;
        $todo->delete();

        return redirect()->route('group.list', $group_id);
    }

    // Edit task status to position up
    public function Up(int $id, Request $request)
    {
        $todo = Todo::find($id);
        $user = User::find(Auth::id());
        if ($todo == null || $user == null) abort(404);
        if (!$todo->hasPerm($user)) abort(403);

        if ($todo->task_status == 3) return redirect()->back();
        $todo->task_status += 1;
        $todo->save();

        return redirect()->route('group.list', $todo->group_id);
    }

    // Edit task status to position down
    public function Down(int $id, Request $request)
    {
        $todo = Todo::find($id);
        $user = User::find(Auth::id());
        if ($todo == null || $user == null) abort(404);
        if (!$todo->hasPerm($user)) abort(403);

        if ($todo->task_status == 1) return redirect()->back();
        $todo->task_status -= 1;
        $todo->save();

        return redirect()->route('group.list', $todo->group_id);
    }
}
