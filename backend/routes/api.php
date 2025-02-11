<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarUserController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/cars', [CarController::class, 'store']);
Route::post('/users', [UserController::class, 'storeU']);
Route::post('/caruser', [CarUserController::class, 'storeCU']);


Route::delete('/cars/{id}', [CarController::class, 'destroy']);
Route::patch('/cars/{id}/edit', [CarController::class, 'editCar']);
Route::patch('caruser/{id}/state', [CarUserController::class, 'updateState']);
Route::delete('/caruser/{id}', [CarUserController::class, 'destroy']);



Route::delete('/users/{id}', [UserController::class, 'destroyU']);
Route::patch('/users/{id}/edit', [UserController::class, 'editUser']);

Route::get('/cars', [CarController::class, 'index']);
Route::get('/cars', [CarController::class, 'getCars']);
Route::get('/caruser', [CarUserController::class, 'getCU']);
Route::get('/reservations', [CarUserController::class, 'getAllReservations']);


Route::get('/users', [UserController::class, 'indexU']);
Route::get('/users', [UserController::class, 'getUsers']);