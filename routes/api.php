<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TranslationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('translations')->group(function () {
        Route::get('/', [TranslationController::class, 'index']);
        Route::post('/', [TranslationController::class, 'store']);
        Route::post('/{translation}', [TranslationController::class, 'update']);
        Route::delete('/{translation}', [TranslationController::class, 'destroy']);
        Route::get('/search', [TranslationController::class, 'search']);
        Route::get('/export', [TranslationController::class, 'export']);
    });

    Route::post('logout', [AuthController::class, 'logout']);
});
