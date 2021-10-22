<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Character;
// use App\Models\Encounter;
// use App\Models\Monster;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        $characters = auth()->user()->characters()->whereNull('archive_date')->select(['id', 'name', 'class', 'race', 'level', 'updated_at'])->orderByDesc('updated_at')->take(5)->get();
        $encounters = auth()->user()->encounters()->select(['id', 'name'])->orderByDesc('updated_at')->take(5)->get()->loadCount('monsters');

        return Inertia::render('Dashboard', compact(['characters', 'encounters']));
    }
}
