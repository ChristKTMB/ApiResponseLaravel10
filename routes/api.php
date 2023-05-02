<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Public Routes 
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    //User
    Route::get('/user',[AuthController::class, 'user']);
    Route::post('/user',[AuthController::class, 'update']);
    Route::post('/logout',[AuthController::class, 'logout']);

    //Post
    Route::get('/posts',[PostController::class, 'index']); // tout les postes
    Route::post('/posts',[PostController::class, 'store']); //creation de postes
    Route::get('/posts/{id}',[PostController::class, 'show']); // avoir un poste en detail
    Route::put('/posts/{id}',[PostController::class, 'update']); //telecharger le post
    Route::delete('/posts/{id}',[PostController::class, 'destroy']); //supprimer

    // Comment
    Route::get('/posts/{id}/comments',[CommentController::class, 'index']); // tout les commentaire
    Route::post('/posts/{id}/comments',[CommentController::class, 'store']); //creation de commentaire
    Route::put('/comments/{id}',[CommentController::class, 'update']); //telecharger le commentaire
    Route::delete('/comments/{id}',[CommentController::class, 'destroy']); //supprimer

    // Like
    Route::post('/posts/{id}/likes',[LikeController::class, 'likeOrUnlike']); //like or dislike

});