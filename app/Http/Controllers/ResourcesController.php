<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Http\Requests\ResourceRequest;
use Inertia\Inertia;

class ResourcesController extends Controller
{
    public function store(ResourceRequest $request) {
        $this->authorize('update', $request['creature_type']::find($request['creature_id']));
        $validated = $request->validated();

        $resource = new Resource;
        $resource->fill($validated);
        $resource->save();

        return back()->with(['flash_message' => $resource->name . ' added to ' . $resource->creature->name, 'flash_status' => 'success']);
    }

    public function update(ResourceRequest $request, Resource $resource) {
        $this->authorize('update', $resource->creature);

        $validated = $request->validated();

        $resource->update($validated);

        if($request->input('no_alert')) {
            return back();
        }

        return back()->with(['flash_message' => $resource->creature->name . '\'s ' .  $resource->name . ' updated', 'flash_status' => 'success']);
    }

    public function destroy(Resource $resource) {
        $this->authorize('update', $resource->creature);

        $resource->delete();

        return back()->with(['flash_message' => $resource->creature->name . '\'s ' .  $resource->name . ' deleted', 'flash_status' => 'danger']);
    }
}
