<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/                       

Route::get('/example', function () {
    return response()->json(['message' => 'This is an example API route']);
});

Route::get('/membaca', [MainController::class, 'getMembaca']);
Route::get('/menyimak', [MainController::class, 'getMenyimak']);
Route::get('/menulis', [MainController::class, 'getMenulis']);
Route::get('/berbicara', [MainController::class, 'getBerbicara']);

Route::post('/membaca', [MainController::class, 'storeMembaca']);
Route::post('/menyimak', [MainController::class, 'storeMenyimak']);
Route::post('/menulis', [MainController::class, 'storeMenulis']);
Route::post('/berbicara', [MainController::class, 'storeBerbicara']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
