<?php

use App\Http\Controllers\Api\FutsalController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::get('/users/edit/{id}', [UserController::class, 'edit']);
Route::apiResource('futsals', FutsalController::class);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
