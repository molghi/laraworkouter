<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

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

// show workout entry form
Route::get('/', [PageController::class, 'show_form']);

// preview workout
Route::post('/preview', [PageController::class, 'preview_workout'])->name('workout.preview');

// begin workout
Route::post('/workout', [PageController::class, 'begin_workout'])->name('workout.begin');