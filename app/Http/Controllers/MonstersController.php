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
        $monsters = Monster::userOrPublic(auth()->user()->id)->orderBy('name')->get();
        $monsters->load(['user']);
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

    public function clone(Request $request, Monster $monster) {
        $new_monster = $monster->replicate();
        $new_monster->name = $request->input('name');
        $new_monster->save();

        foreach($monster->modifiers as $modifier) {
            $new_modifier = $modifier->replicate();
            $new_modifier->creature_id = $new_monster->id;
            $new_modifier->save();
        }

        foreach($monster->resources as $resource) {
            $new_resource = $resource->replicate();
            $new_resource->creature_id = $new_monster->id;
            $new_resource->save();
        }

        foreach($monster->actions as $action) {
            $new_action = $action->replicate();
            $new_action->creature_id = $new_monster->id;
            $new_action->save();
        }

        return redirect($new_monster->path())->with(['flash_message' => $new_monster->name . ' cloned from ' . $monster->name, 'flash_status' => 'success']);
    }
}
