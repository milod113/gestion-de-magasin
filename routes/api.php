<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::get('/articles', [ArticleApiController::class, 'getByCategorie']);
Route::get('/articles-by-categorie', [ArticleApiController::class, 'getByCategorie']);
