<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encounter;
use App\Models\Monster;
use Inertia\Inertia;
use App\Http\Requests\EncounterRequest;

class EncountersController extends Controller
{
    public function index() {
        $encounters = auth()->user()->encounters->sortBy('name');
        return Inertia::render('Encounters/Index', compact(['encounters']));
    }

    public function create() {
        return Inertia::render('Encounters/Edit');
    }

    public function store(EncounterRequest $request) {
        $validated = $request->validated();

        $encounter = new Encounter;
        $encounter->fill($validated);
        $encounter->user_id = auth()->user()->id;
        $encounter->save();

        return redirect($encounter->path())->with(['flash_message' => $encounter->name . ' created', 'flash_status' => 'success']);
    }

    public function show(Encounter $encounter) {
        $this->authorize('update', $encounter);

        $encounters = auth()->user()->encounters()->select(['id', 'name'])->orderBy('name')->get();
        $monsters = Monster::userOrPublic(auth()->user()->id)->orderBy('name')->select(['id', 'name', 'user_id', 'type', 'size', 'challenge_rating', 'public'])->get()->load(['user']);

        $encounter->load(['monsters']);

        return Inertia::render('Encounters/Show', compact(['encounter', 'encounters', 'monsters']));
    }

    public function edit(Encounter $encounter) {
        $this->authorize('update', $encounter);

        return Inertia::render('Encounters/Edit', ['editing' => $encounter]);
    }

    public function update(EncounterRequest $request, Encounter $encounter) {
        $this->authorize('update', $encounter);

        $validated = $request->validated();

        $encounter->update($validated);

        if($request->input('no_alert')) {
            return redirect($encounter->path());
        }

        return redirect($encounter->path())->with(['flash_message' => $encounter->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Encounter $encounter) {
        $this->authorize('update', $encounter);

        $encounter->delete();

        return redirect(route('encounters.index'))->with(['flash_message' => $encounter->name . ' deleted', 'flash_status' => 'danger']);
    }
}
