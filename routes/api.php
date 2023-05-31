<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjecManagement;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/project-department/{id}', [ProjecManagement::class, 'show'])->name('show');
Route::put('/project-department/{id}', [ProjecManagement::class, 'update'])->name('update');

Route::get('/project-work/{id}', [ProjecManagement::class, 'showWork'])->name('showWork');
Route::put('/project-work/{id}', [ProjecManagement::class, 'updateWork'])->name('updateWork');

Route::get('/project-Lv4/{id}', [ProjecManagement::class, 'showLv4'])->name('showLv4');
Route::put('/project-Lv4/{id}', [ProjecManagement::class, 'updateLv4'])->name('updateLv4');