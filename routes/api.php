<?php

use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    $user = auth()->user();
    return $request->user();
})->middleware('auth:api');


Route::resource('users', AdminUserController::class)->parameters(['id' => 'id']);
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::put('user/{user}/change-role', [AdminUserController::class, 'changeRole']);
//Route::get('user/search', [AdminUserController::class, 'search']);
Route::delete('user/delete-bulk', [AdminUserController::class, 'deleteBulk']);

Route::resource('appointments', 'App\Http\Controllers\Api\AppointmentController');
Route::get('appointment-status', [AppointmentController::class, 'getStatus']);
Route::get('clients', [ClientController::class, 'clients']);


Route::middleware(['auth:api'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('loginGrant', [AuthController::class, 'loginGrant']);
});
