<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;
use App\Http\Requests\ActionRequest;
use Inertia\Inertia;

class ActionsController extends Controller
{
    public function store(ActionRequest $request) {
        $this->authorize('update', $request['creature_type']::find($request['creature_id']));
        $validated = $request->validated();

        $action = new Action;
        $action->fill($validated);
        $action->save();

        return redirect($action->creature->path())->with(['flash_message' => $action->name . ' added to ' . $action->creature->name, 'flash_status' => 'success']);
    }

    public function update(ActionRequest $request, Action $action) {
        $this->authorize('update', $action->creature);

        $validated = $request->validated();

        $action->update($validated);

        return redirect($action->creature->path())->with(['flash_message' => $action->creature->name . '\'s ' .  $action->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Action $action) {
        $this->authorize('update', $action->creature);

        $action->delete();

        return redirect($action->creature->path)->with(['flash_message' => $action->creature->name . '\'s ' .  $action->name . ' deleted', 'flash_status' => 'danger']);
    }
}
