<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RallyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/login', [AuthenticationController::class, "login"])->name("login");

    Route::apiResource("rally", RallyController::class);
    Route::apiResource("album", AlbumController::class);
