<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
//Route::get('/users/{user}/profile', [\App\Http\Controllers\UserController::class, 'indexProfile']);
//
//
//Route::get('/posts', [PostController::class, 'index']);
//Route::get('/posts/{post}/show', [PostController::class, 'show']);
//
//
//Route::get('/posts/{post}/comments', [PostController::class, 'showComments']);
//Route::get('/posts/{post}/send_comment', [PostController::class, 'storeComment']);
//Route::get('/posts/{post}/delete_comment', [PostController::class, 'destroyComment']);
//
//
//Route::get('/posts/{post}/likes', [PostController::class, 'showLikes']);
//Route::get('/posts/store', [PostController::class, 'store']);
//Route::get('/posts/{post}/update', [PostController::class, 'update']);
//Route::get('/posts/{post}/destroy', [PostController::class, 'destroy']);
//
//
//
//Route::get('/posts/{post}/comment', [PostController::class, 'comment']);
//Route::get('/posts/{post}/toggle_like', [PostController::class, 'toggleLike']);










