<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CharactersController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\ModifiersController;
use App\Http\Controllers\ActionsController;
use App\Http\Controllers\MonstersController;
use App\Http\Controllers\EncountersController;
use App\Http\Controllers\EncounterMonstersController;
use App\Http\Controllers\DiceTablesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user()) {
        return redirect('/dashboard');
    }

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/party', [UsersController::class, 'updateParty'])->name('users.party');

    Route::resource('characters', CharactersController::class);
    Route::patch('/characters/{character}/rest', [CharactersController::class, 'rest'])->name('characters.rest');
    Route::patch('/characters/{character}/archive', [CharactersController::class, 'archive'])->name('characters.archive');
    Route::patch('/characters/{character}/unarchive', [CharactersController::class, 'unarchive'])->name('characters.unarchive');

    Route::resource('monsters', MonstersController::class);
    Route::post('/monsters/{monster}/clone', [MonstersController::class, 'clone'])->name('monsters.clone');

    Route::post('/resources', [ResourcesController::class, 'store'])->name('resources.store');
    Route::patch('/resources/{resource}', [ResourcesController::class, 'update'])->name('resources.update');
    Route::delete('/resources/{resource}', [ResourcesController::class, 'destroy'])->name('resources.destroy');

    Route::post('/modifiers', [ModifiersController::class, 'store'])->name('modifiers.store');
    Route::patch('/modifiers/{modifier}', [ModifiersController::class, 'update'])->name('modifiers.update');
    Route::delete('/modifiers/{modifier}', [ModifiersController::class, 'destroy'])->name('modifiers.destroy');

    Route::post('/actions', [ActionsController::class, 'store'])->name('actions.store');
    Route::patch('/actions/{action}', [ActionsController::class, 'update'])->name('actions.update');
    Route::delete('/actions/{action}', [ActionsController::class, 'destroy'])->name('actions.destroy');

    Route::resource('encounters', EncountersController::class);
    Route::patch('/encounters/{encounter}/update_monster_weights', [EncountersController::class, 'updateMonsterWeights'])->name('encounters.update_monster_weights');

    Route::post('/encounters/{encounter}/monsters', [EncounterMonstersController::class, 'store'])->name('encounter_monsters.store');
    Route::get('/encounters/{encounter}/monsters/{encounter_monster}', [EncounterMonstersController::class, 'show'])->name('encounter_monsters.show');
    Route::get('/encounters/{encounter}/monsters/{encounter_monster}/edit', [EncounterMonstersController::class, 'edit'])->name('encounter_monsters.edit');
    Route::patch('/encounters/{encounter}/monsters/{encounter_monster}', [EncounterMonstersController::class, 'update'])->name('encounter_monsters.update');
    Route::delete('/encounters/{encounter}/monsters/{encounter_monster}', [EncounterMonstersController::class, 'destroy'])->name('encounter_monsters.destroy');
    Route::patch('/encounters/{encounter}/monsters/{encounter_monster}/rest', [EncounterMonstersController::class, 'rest'])->name('encounter_monsters.rest');

    Route::get('/dice_tables/select_list', [DiceTablesController::class, 'selectList'])->name('dice_tables.select_list');
    Route::resource('dice_tables', DiceTablesController::class);
});
