<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

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
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::apiResource('student', StudentController::class);

// Route::get('/User',[UserController::class, 'index']);
// Route::get('/User/{id}',[UserController::class, 'show']);
// // Route::post('/User',[UserController::class, 'store']);
// Route::put('/User/{id}',[UserController::class, 'update']);
// Route::delete('/User/{id}',[UserController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
