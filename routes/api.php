<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Main\FarmController;
use App\Http\Controllers\Api\Main\FarmerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(["redirectIfAuth:api"])->prefix('auth')->group(function () {
    Route::post('login',[AuthController::class, 'login']);
    Route::post('register',[AuthController::class, 'register']);
    Route::post('resetToken',[AuthController::class, 'sendResetToken']);
    Route::post('resetPassword',[AuthController::class, 'resetPassword']);
});

Route::middleware(['auth:sanctum'])->prefix('auth')->group(function () {
    Route::post('logout',[AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('farmers',FarmerController::class);
    Route::post('farmers/{farmer}/picture', [FarmerController::class, 'addPicture']);
    Route::patch('farmers/{farmer}/picture', [FarmerController::class, 'changePicture']);
    Route::delete('farmers/{farmer}/picture', [FarmerController::class, 'deletePicture']);
    Route::match(["get","post"],'farmers/{farmer}/key', [FarmerController::class, 'addKey']);

    Route::apiResource('farms', FarmController::class);

});
