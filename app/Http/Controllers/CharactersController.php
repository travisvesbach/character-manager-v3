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
        return Inertia::render('Characters/Index');
    }

    public function create() {
        return Inertia::render('Characters/Create');
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
        return Inertia::render('Characters/Show', compact(['character']));
    }
}
