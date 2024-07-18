<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\SearchController;




//auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


//guarded routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('websites', WebsiteController::class)->except('index', 'show');
    Route::apiResource('categories', CategoryController::class)->only('store');
    Route::post('votes', [VoteController::class, 'store']);
    Route::delete('votes/{website}', [VoteController::class, 'destroy']);
});


//unguarded routes
Route::get('websites', [WebsiteController::class, 'index']);
Route::get('websites/{id}', [WebsiteController::class, 'show']);
Route::get('categories', [CategoryController::class, 'index']);
Route::post('/search', [SearchController::class, 'search']);