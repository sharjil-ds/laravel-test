<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/warmupevents', [EventsController::class, 'getWarmupEvents']);
Route::get('/events', [EventsController::class, 'getEventsWithWorkshops']);
Route::get('/futureevents', [EventsController::class, 'getFutureEventsWithWorkshops']);
Route::get('/menu', [MenuController::class, 'getMenuItems']);
