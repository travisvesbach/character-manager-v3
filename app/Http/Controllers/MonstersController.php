<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monster;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\MonsterRequest;

class MonstersController extends Controller
{
    public function index() {
        $monsters = Monster::userOrPublic(auth()->user()->id)->get();
        return Inertia::render('Monsters/Index', compact(['monsters']));
    }

    public function create() {
        return Inertia::render('Monsters/Edit');
    }

    public function store(MonsterRequest $request) {
        $validated = $request->validated();

        $monster = new Monster;
        $monster->fill($validated);
        $monster->user_id = auth()->user()->id;
        $monster->save();

        return redirect($monster->path())->with(['flash_message' => $monster->name . ' created', 'flash_status' => 'success']);
    }

    public function show(Monster $monster) {
        if(!$monster->public) {
            $this->authorize('update', $monster);
        }

        $monster->load(['resources', 'modifiers', 'actions']);

        return Inertia::render('Monsters/Show', compact(['monster']));
    }

    public function edit(Monster $monster) {
        $this->authorize('update', $monster);

        return Inertia::render('Monsters/Edit', ['editing' => $monster]);
    }

    public function update(MonsterRequest $request, Monster $monster) {
        $this->authorize('update', $monster);

        $validated = $request->validated();

        $monster->update($validated);

        if($request->input('no_alert')) {
            return redirect($monster->path());
        }

        return redirect($monster->path())->with(['flash_message' => $monster->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Monster $monster) {
        $this->authorize('update', $monster);

        $monster->delete();

        return redirect(route('monsters.index'))->with(['flash_message' => $monster->name . ' deleted', 'flash_status' => 'danger']);
    }
}
