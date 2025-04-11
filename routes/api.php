<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FutsalController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::apiResource('futsals', FutsalController::class);
Route::get('/allfutsals', [FutsalController::class, 'allFutsal']);
Route::get('/futsals/edit/{id}', [FutsalController::class, 'edit']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
