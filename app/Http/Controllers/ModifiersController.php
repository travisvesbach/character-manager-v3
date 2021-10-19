<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modifier;
use App\Http\Requests\ModifierRequest;
use Inertia\Inertia;

class ModifiersController extends Controller
{
    public function store(ModifierRequest $request) {
        $this->authorize('update', $request['creature_type']::find($request['creature_id']));
        $validated = $request->validated();

        $modifier = new Modifier;
        $modifier->fill($validated);
        $modifier->save();

        return back()->with(['flash_message' => $modifier->name . ' added to ' . $modifier->creature->name, 'flash_status' => 'success']);
    }

    public function update(ModifierRequest $request, Modifier $modifier) {
        $this->authorize('update', $modifier->creature);

        $validated = $request->validated();

        $modifier->update($validated);

        if($request->input('no_alert')) {
            return back();
        }

        return back()->with(['flash_message' => $modifier->creature->name . '\'s ' .  $modifier->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Modifier $modifier) {
        $this->authorize('update', $modifier->creature);

        $modifier->delete();

        return back()->with(['flash_message' => $modifier->creature->name . '\'s ' .  $modifier->name . ' deleted', 'flash_status' => 'danger']);
    }
}
