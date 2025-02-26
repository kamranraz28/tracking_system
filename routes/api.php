<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\SrController;
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


Route::get('/test', [LoginController::class, 'test']);
Route::post('/login', [LoginController::class, 'login']);

Route::group(['prefix' => 'admin'], function () {
    Route::post('/settings', [LoginController::class, 'settings'])->middleware(['auth:api']);
    Route::get('/colors', [LoginController::class, 'colors']);
});



//SR Panel Start

Route::group(['prefix' => 'sr'], function () {
    Route::post('/location-store', [SrController::class, 'locationStore'])->middleware(['auth:api']);
    Route::post('/attendance-store', [SrController::class, 'attendanceStore'])->middleware(['auth:api']);

});
//SR Panel End
