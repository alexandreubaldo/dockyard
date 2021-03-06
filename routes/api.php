<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\PatioController;
use App\Http\Controllers\YardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('yards/view/{id}', function($id){
    return DB::table('yards')
    ->select('id', 'locator', 'length', 'width', 'created_at', 'updated_at')
    ->whereRaw('id =' . $id)->first();
});
Route::apiResource('yards', YardController::class);
Route::apiResource('containers', ContainerController::class)->except(['update']);
Route::apiResource('boxes', BoxController::class)->except(['update']);



