<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ImagemNoticiaController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\RallyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/login', [AuthenticationController::class, "login"])->name("login");

Route::apiResource("rally", RallyController::class);
Route::apiResource("noticias", NoticiaController::class);
Route::apiResource("imagensNoticia", ImagemNoticiaController::class);
