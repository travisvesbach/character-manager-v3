<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserCreated;

class UsersController extends Controller
{

    public function index() {
        $this->authorize('manageUsers', User::class);

        $users = User::orderBy('name')->get();

        return Inertia::render('Users/Index', compact('users'));
    }

    public function create() {
        $this->authorize('manageUsers', User::class);

        return Inertia::render('Users/Edit');
    }

    public function store(Request $request) {
        $this->authorize('manageUsers', User::class);

        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password, 'confirmed'],
            'admin' => ['boolean'],
        ]);

        $user = User::create([
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'password' => Hash::make(request()->input('password')),
            'admin' => request()->input('admin'),
        ]);

        $user->notify(new UserCreated());

        return redirect('/users')->with(['flash_message' => $user->name . ' created', 'flash_status' => 'success']);
    }

    public function edit(User $user) {
        $this->authorize('manageUsers', User::class);

        return Inertia::render('Users/Edit', ['editing' => $user]);
    }

    public function update(Request $request, User $user) {
        $this->authorize('manageUsers', User::class);

        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['string', new Password, 'confirmed', 'nullable'],
            'admin' => ['boolean'],
        ]);

        $user->name = request()->input('name');
        $user->email = request()->input('email');
        $user->admin = request()->input('admin');
        if($request->filled('password')) {
            $user->password = Hash::make(request()->input('password'));
        }

        $user->save();

        return redirect('/users')->with(['flash_message' => $user->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(User $user) {
        $this->authorize('manageUsers', User::class);

        $user->delete();

        return redirect('/users')->with(['flash_message' => $user->name . ' deleted', 'flash_status' => 'danger']);
    }

    public function updateParty(Request $request, User $user) {
        $this->authorize('manageUsers', User::class);
        request()->validate([
            'party' => ['required', 'array'],
        ]);

        $user->party = request()->input('party');
        $user->save();

        return redirect(route('encounters.index'));
    }
}
