<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClaseController;
use App\Http\Controllers\Api\HorarioController;

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

Route::apiResource('horarios', HorarioController::class);
Route::apiResource('clases', ClaseController::class);
Route::get('listarClasesSelect', [HorarioController::class, 'listarClasesSelect'])->name('horarios.listarClasesSelect');

