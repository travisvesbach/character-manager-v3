<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EncounterMonster;
use App\Models\Monster;
use App\Models\Encounter;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\EncounterMonsterRequest;
use Illuminate\Support\Str;

class EncounterMonstersController extends Controller
{
    public function store(Request $request, Encounter $encounter) {
        $validated = $request->validate([
            'monster_id' => 'required|integer',
        ]);

        $monster = Monster::find($validated['monster_id']);

        $encounter_monster = $monster->replicate()->setTable('encounter_monsters');
        unset($encounter_monster->public);
        $encounter_monster->user_id = $encounter->user_id;
        $encounter_monster->encounter_id = $encounter->id;
        $encounter_monster->weight = $encounter->nextAvailableWeight();
        $encounter_monster->name_number = $encounter->nextNameNumber($monster->name);
        $encounter_monster->save();

        $encounter_monster = EncounterMonster::find($encounter_monster->id);

        $relationships = ['modifiers', 'resources', 'actions'];

        foreach($relationships as $relationship) {
            foreach($monster->{$relationship} as $item) {
                $new_item = $item->replicate();
                $new_item->creature_id = $encounter_monster->id;
                $new_item->creature_type = 'App\Models\EncounterMonster';
                $new_item->save();
            }
        }

        return redirect($encounter_monster->encounter->path())->with(['flash_message' => $encounter_monster->display_name . ' added to ' . $encounter_monster->encounter->name, 'flash_status' => 'success']);
    }

    public function show(Encounter $encounter, EncounterMonster $encounter_monster) {
        if(!$encounter_monster->public) {
            $this->authorize('update', $encounter_monster);
        }

        $encounter_monster->load(['resources', 'modifiers', 'actions']);

        return Inertia::render('EncounterMonsters/Show', compact(['encounter_monster']));
    }

    public function edit(Encounter $encounter, EncounterMonster $encounter_monster) {
        $this->authorize('update', $encounter_monster);

        return Inertia::render('EncounterMonsters/Edit', ['editing' => $encounter_monster]);
    }

    public function update(EncounterMonsterRequest $request, Encounter $encounter, EncounterMonster $encounter_monster) {
        $this->authorize('update', $encounter_monster);

        $validated = $request->validated();
        $encounter_monster->update($validated);

        $flash = null;
        if(!$request->input('no_alert')) {
            $flash = ['flash_message' => $encounter_monster->name . ' updated', 'flash_status' => 'success'];
        }

        if(Str::contains(request()->headers->get('referer'), $encounter_monster->path() . '/edit')) {
            return redirect($encounter_monster->path())->with($flash);
        }
        return back()->with($flash);
    }

    public function destroy(Encounter $encounter, EncounterMonster $encounter_monster) {
        $this->authorize('update', $encounter_monster);

        $encounter_monster->delete();

        return redirect($encounter_monster->encounter->path())->with(['flash_message' => $encounter_monster->name . ' deleted', 'flash_status' => 'danger']);
    }

    public function rest(Encounter $encounter, EncounterMonster $encounter_monster, Request $request) {
        $this->authorize('update', $encounter_monster);

        $flash_message = $encounter_monster->rest($request->input('length'));

        return redirect($encounter_monster->path())->with(['flash_message' => $flash_message, 'flash_status' => 'success']);
    }
}
