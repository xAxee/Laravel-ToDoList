<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): RedirectResponse
    {
        return redirect()->route('group');
    }

    public function list($tasks, $group = null): View
    {
        return view("todo.index", [
            'group' => $group,
            'count' => $tasks->count(),
            'first' => $tasks->where("task_status", "=", Todo::STATUS_TODO),
            'second' => $tasks->where("task_status", "=", Todo::STATUS_IN_PROGRESS),
            'third' => $tasks->where("task_status", "=", Todo::STATUS_DONE)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100', 'min:1'],
            'description' => ['required', 'string', 'max:1500', 'min:1'],
            'status' => ['required', 'integer', 'in:' . implode(',', array_keys(Todo::getAvailableStatuses()))],
            'group_id' => ['required', 'integer', 'exists:group,id']
        ]);

        try {
            DB::beginTransaction();

            $todo = Todo::create([
                ...$validated,
                'user_id' => Auth::id(),
                'task_status' => $request->status
            ]);

            if ($request->filled('assign')) {
                DB::commit();
                return redirect()->route('group.user.assign', [
                    'id' => $request->group_id,
                    'email' => $request->assign,
                    'todo_id' => $todo->id
                ]);
            }

            DB::commit();
            return redirect()->route('group.list', $todo->group_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Wystąpił błąd podczas zapisywania zadania.']);
        }
    }

    public function edit(int $id, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100', 'min:1'],
            'description' => ['required', 'string', 'max:1500', 'min:1'],
            'status' => ['required', 'integer', 'in:' . implode(',', array_keys(Todo::getAvailableStatuses()))],
            'group_id' => ['required', 'integer', 'exists:group,id']
        ]);

        $todo = $this->findAndAuthorize($id);

        try {
            DB::beginTransaction();

            $todo->update([
                ...$validated,
                'task_status' => $request->status
            ]);

            DB::commit();
            return redirect()->route('todo.assign', [
                'id' => $request->group_id,
                'email' => $request->assign ?? "",
                'todo_id' => $todo->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Wystąpił błąd podczas aktualizacji zadania.']);
        }
    }

    public function delete(int $id): RedirectResponse
    {
        $todo = $this->findAndAuthorize($id);
        $groupId = $todo->group_id;

        try {
            DB::beginTransaction();
            $todo->delete();
            DB::commit();

            return redirect()->route('group.list', $groupId);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Wystąpił błąd podczas usuwania zadania.']);
        }
    }

    public function up(int $id): RedirectResponse
    {
        $todo = $this->findAndAuthorize($id);

        if ($todo->task_status === Todo::STATUS_DONE) {
            return redirect()->back();
        }

        $todo->update(['task_status' => $todo->task_status + 1]);
        return redirect()->route('group.list', $todo->group_id);
    }

    public function down(int $id): RedirectResponse
    {
        $todo = $this->findAndAuthorize($id);

        if ($todo->task_status === Todo::STATUS_TODO) {
            return redirect()->back();
        }

        $todo->update(['task_status' => $todo->task_status - 1]);
        return redirect()->route('group.list', $todo->group_id);
    }

    private function findAndAuthorize(int $id): Todo
    {
        $todo = Todo::findOrFail($id);
        $user = Auth::user();

        if (!$todo->hasPerm($user)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $todo;
    }

    public function assign(int $id, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $todo = Todo::findOrFail($request->todo_id);
            $user = $request->email ? User::where('email', $request->email)->first() : null;

            $todo->update(['assigned_id' => $user?->id]);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Wystąpił błąd podczas przypisywania zadania.']);
        }
    }
}