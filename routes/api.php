<?php

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
Route::post('/register', [\App\Http\Controllers\Api\RegisterController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\LoginController::class, 'login']);
Route::post('/getsoal', [\App\Http\Controllers\Api\GameController::class, 'getSoal']);
Route::post('/savejawaban', [\App\Http\Controllers\Api\GameController::class, 'saveJawaban']);
Route::post('/cekjawaban', [\App\Http\Controllers\Api\GameController::class, 'cekJawaban']);

Route::middleware(['authtoken'])->group(function(){
    Route::post('/game', [\App\Http\Controllers\Api\GameController::class, 'index']);
});
