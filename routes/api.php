<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EntidadeController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\PatrocinioController;
use App\Http\Controllers\RallyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//unprotected routes
Route::post('auth/login', [AuthenticationController::class, "login"])->name("login");

Route::get("rally", [RallyController::class, "index"]);
Route::get("rally/{rally}", [RallyController::class, "show"]);

Route::get("noticia", [NoticiaController::class, "index"]);
Route::get("noticia/{noticia}", [NoticiaController::class, "show"]);

Route::get("album", [AlbumController::class, "index"]);
Route::get("album/{album}", [AlbumController::class, "show"]);

Route::get("foto", [FotoController::class, "index"]);
Route::get("foto/{foto}", [FotoController::class, "show"]);

Route::get("entidade", [EntidadeController::class, "index"]);
Route::get("entidade/{entidade}", [EntidadeController::class, "show"]);

Route::get("patrocinio", [PatrocinioController::class, "index"]);
Route::get("patrocinio/{patrocinio}", [PatrocinioController::class, "show"]);



//protected routes
Route::middleware("auth:sanctum")->group(function (){
    Route::post("rally", [RallyController::class, "store"]);
    Route::put("rally/{rally}", [RallyController::class, "update"]);
    Route::delete("rally/{rally}", [RallyController::class, "destroy"]);

   Route::post("album", [AlbumController::class, "store"]);
   Route::put("album/{album}", [AlbumController::class, "update"]);
   Route::delete("album/{album}", [AlbumController::class, "destroy"]);

   Route::post("noticia", [NoticiaController::class, "store"]);
   Route::put("noticia/{noticia}", [NoticiaController::class, "update"]);
   Route::delete("noticia/{noticia}", [NoticiaController::class, "destroy"]);

    Route::post("entidade", [EntidadeController::class, "store"]);
    Route::put("entidade/{entidade}", [EntidadeController::class, "update"]);
    Route::delete("entidade/{entidade}", [EntidadeController::class, "destroy"]);


    Route::post("foto", [FotoController::class, "store"]);
    Route::put("foto/{foto}", [FotoController::class, "update"]);
    Route::delete("foto/{foto}", [FotoController::class, "destroy"]);

    Route::post("patrocinio", [PatrocinioController::class, "store"]);
    Route::put("patrocinio/{patrocinio}", [PatrocinioController::class, "update"]);
    Route::delete("patrocinio/{patrocinio}", [PatrocinioController::class, "destroy"]);

    Route::get('/user', function (Request $request) {
        return Auth::user();
    });
});
