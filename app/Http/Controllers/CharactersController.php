<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\CharacterRequest;
use Carbon\Carbon;

class CharactersController extends Controller
{
    public function index() {
        $characters = auth()->user()->characters->sortBy('name');
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

        $character->load(['resources', 'modifiers', 'actions']);

        $characters = auth()->user()->characters()->whereNull('archive_date')->select(['id', 'name', 'level', 'race', 'class'])->orderBy('name')->get();

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

        if($request->input('no_alert')) {
            return redirect($character->path());
        }

        return redirect($character->path())->with(['flash_message' => $character->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Character $character) {
        $this->authorize('update', $character);

        $character->delete();

        return redirect(route('characters.index'))->with(['flash_message' => $character->name . ' deleted', 'flash_status' => 'danger']);
    }

    public function rest(Character $character, Request $request) {
        $this->authorize('update', $character);

        $flash_message = $character->rest($request->input('length'));

        return redirect($character->path())->with(['flash_message' => $flash_message, 'flash_status' => 'success']);
    }

    public function archive(Character $character, Request $request) {
        $this->authorize('update', $character);

        if(!$character->archive_date) {
            $character->archive_date = Carbon::now();
            $character->save();
            $flash = ['flash_message' => $character->name . ' has been archived', 'flash_status' => 'success'];
        } else {
            $flash = ['flash_message' => $character->name . ' is already archived', 'flash_status' => 'danger'];
        }
        return redirect(route('characters.index'))->with($flash);
    }

    public function unarchive(Character $character, Request $request) {
        $this->authorize('update', $character);

        if($character->archive_date) {
            $character->archive_date = null;;
            $character->save();
            $flash = ['flash_message' => $character->name . ' has been unarchived', 'flash_status' => 'success'];
        } else {
            $flash = ['flash_message' => $character->name . ' is not archived', 'flash_status' => 'danger'];
        }
        return redirect($character->path())->with($flash);

    }
}
