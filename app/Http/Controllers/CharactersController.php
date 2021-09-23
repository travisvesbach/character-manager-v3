<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\CharacterRequest;

class CharactersController extends Controller
{
    public function index() {
        $characters = auth()->user()->characters;
        return Inertia::render('Characters/Index', compact(['characters']));
    }

    public function create() {
        return Inertia::render('Characters/Edit');
    }

    public function store(CharacterRequest $request) {
        $validated = $request->validated();

        $character = new Character;
        $character->fill($validated);
        $character->user_id = auth()->user()->id;
        $character->save();

        return redirect($character->path())->with(['flash_message' => $character->name . ' created', 'flash_status' => 'success']);
    }

    public function show(Character $character) {
        $this->authorize('update', $character);

        $character->load('resources');

        $characters = auth()->user()->characters()->select(['id', 'name', 'level', 'race', 'class'])->orderBy('name')->get();

        return Inertia::render('Characters/Show', compact(['character', 'characters']));
    }

    public function edit(Character $character) {
        $this->authorize('update', $character);

        return Inertia::render('Characters/Edit', ['editing' => $character]);
    }

    public function update(CharacterRequest $request, Character $character) {
        $this->authorize('update', $character);

        $validated = $request->validated();

        $character->update($validated);

        return redirect($character->path())->with(['flash_message' => $character->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Character $character) {
        $this->authorize('update', $character);

        $character->delete();

        return redirect(route('characters.index'))->with(['flash_message' => $character->name . ' deleted', 'flash_status' => 'danger']);
    }
}
