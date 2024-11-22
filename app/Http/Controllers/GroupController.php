<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Group;
use App\Models\Todo;
use App\Models\UserGroup;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = Auth::user();
        $groups = $user->groups();

        return view('group.index', ['groups' => $groups]);
    }

    public function tasks(int $id): View
    {
        $group = Group::findOrFail($id);
        $tasks = $group->getAllTasks();

        return (new TaskController)->list($tasks, $group);
    }

    public function settings(int $id): View
    {
        $group = $this->findAndAuthorizeOwner($id);

        return view('group.settings', [
            'group' => $group,
            'allUsers' => User::select('id', 'email', 'name')->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100', 'min:1'],
            'description' => ['required', 'string', 'max:1500', 'min:1']
        ]);

        try {
            DB::beginTransaction();

            $group = Group::create([
                'name' => $validated['title'],
                'description' => $validated['description'],
                'owner_id' => Auth::id(),
                'invite_link' => Str::random(10)
            ]);

            $group->addUser(Auth::user());

            DB::commit();
            return redirect()->back()->with(['message' => 'Poprawnie dodano grupę']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Wystąpił błąd podczas tworzenia grupy.']);
        }
    }

    public function delete(int $id): RedirectResponse
    {
        $group = $this->findAndAuthorizeOwner($id);

        try {
            DB::beginTransaction();
            $group->delete();
            DB::commit();

            return redirect()->route('group')->with(['message' => 'Poprawnie usunięto grupę']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Wystąpił błąd podczas usuwania grupy.']);
        }
    }

    public function edit(int $id, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100', 'min:1'],
            'description' => ['required', 'string', 'max:1500', 'min:1']
        ]);

        $group = $this->findAndAuthorizeOwner($id);

        try {
            DB::beginTransaction();

            $group->update([
                'name' => $validated['title'],
                'description' => $validated['description']
            ]);

            DB::commit();
            return redirect()->back()->with(['message' => 'Poprawnie edytowano grupę']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Wystąpił błąd podczas edycji grupy.']);
        }
    }

    public function invite(string $invite): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $group = Group::where('invite_link', $invite)->firstOrFail();
            $user = Auth::user();

            $result = $group->addUser($user);

            DB::commit();

            if ($result) {
                return redirect()->route('group')->with(['message' => 'Poprawnie dołączono do grupy']);
            }

            return redirect()->route('group')->with([
                'message' => 'Jesteś już w tej grupie',
                'alert' => 'info'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('home');
        }
    }

    public function addUser(int $id, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $group = Group::findOrFail($id);
            $userToAdd = User::where('email', $request->email)->firstOrFail();

            $result = $group->addUser($userToAdd);

            DB::commit();

            if ($result) {
                return redirect()->back()->with(['message' => 'Poprawnie dodano członka']);
            }

            return redirect()->back()->with([
                'message' => 'Ta osoba już jest członkiem',
                'alert' => 'info'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors' => 'Błąd grupy lub użytkownika']);
        }
    }

    public function removeUser(int $id, Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $userGroup = UserGroup::where('user_id', $request->user_id)
                ->where('group_id', $id)
                ->firstOrFail();

            $userGroup->delete();

            DB::commit();
            if($request->leave){
                return redirect()->back()->with(['message' => 'Poprawnie opuszczono grupe']);
            }
            return redirect()->back()->with(['message' => 'Poprawnie usunięto członka']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['errors' => 'Błąd grupy lub użytkownika']);
        }
    }

    private function findAndAuthorizeOwner(int $id): Group
    {
        $group = Group::findOrFail($id);
        
        if ($group->owner_id !== Auth::id()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $group;
    }
}
