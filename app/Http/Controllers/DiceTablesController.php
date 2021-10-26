<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiceTable;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\DiceTableRequest;

class DiceTablesController extends Controller
{
    public function index() {
        $dice_tables = DiceTable::userOrPublic(auth()->user()->id)->orderBy('name')->get();
        $dice_tables->load(['user']);
        return Inertia::render('DiceTables/Index', compact(['dice_tables']));
    }

    public function create() {
        return Inertia::render('DiceTables/Edit');
    }

    public function store(DiceTableRequest $request) {
        $validated = $request->validated();

        $dice_table = new DiceTable;
        $dice_table->fill($validated);
        $dice_table->user_id = auth()->user()->id;
        $dice_table->save();

        return redirect($dice_table->path())->with(['flash_message' => $dice_table->name . ' created', 'flash_status' => 'success']);
    }

    public function show(DiceTable $dice_table) {
        if(!$dice_table->public) {
            $this->authorize('update', $dice_table);
        }

        return Inertia::render('DiceTables/Show', compact(['dice_table']));
    }

    public function edit(DiceTable $dice_table) {
        $this->authorize('update', $dice_table);

        return Inertia::render('DiceTables/Edit', ['editing' => $dice_table]);
    }

    public function update(DiceTableRequest $request, DiceTable $dice_table) {
        $this->authorize('update', $dice_table);

        $validated = $request->validated();

        $dice_table->update($validated);

        if($request->input('no_alert')) {
            return redirect($dice_table->path());
        }

        return redirect($dice_table->path())->with(['flash_message' => $dice_table->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(DiceTable $dice_table) {
        $this->authorize('update', $dice_table);

        $dice_table->delete();

        return redirect(route('dice_tables.index'))->with(['flash_message' => $dice_table->name . ' deleted', 'flash_status' => 'danger']);
    }
}
