<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/news/{news_id}/visit', 'VisitController@recordVisit');
    Route::get('/visits/aggregates', 'VisitController@getAggregates');
    Route::post('/logout', [AuthController::class, 'logout']);

});



