<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\RallyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//unprotected routes
Route::post('auth/login', [AuthenticationController::class, "login"])->name("login");

Route::get("rally", [RallyController::class, "index"]);
Route::get("rally/{rally}", [RallyController::class, "show"]);

Route::get("album", [AlbumController::class, "index"]);
Route::get("album/{album}", [AlbumController::class, "show"]);

Route::get("foto", [FotoController::class, "index"]);
Route::get("foto/{foto}", [FotoController::class, "show"]);

//protected routes
Route::middleware("auth:sanctum")->group(function (){
    Route::post("rally", [RallyController::class, "store"]);
    Route::put("rally/{rally}", [RallyController::class, "update"]);
    Route::delete("rally/{rally}", [RallyController::class, "destroy"]);

   Route::post("album", [AlbumController::class, "store"]);
   Route::put("album/{album}", [AlbumController::class, "update"]);
   Route::delete("album/{album}", [AlbumController::class, "destroy"]);

    Route::post("foto", [FotoController::class, "store"]);
    Route::put("foto/{foto}", [FotoController::class, "update"]);
    Route::delete("foto/{foto}", [FotoController::class, "destroy"]);

    Route::get('/user', function (Request $request) {
        return Auth::user();
    });
});
