<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Middleware\DynamicRoleMiddleware;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\RoleCRUDMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('posts/process', [PostController::class, 'testProcessPost']);


Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::apiResource('posts', PostController::class);


});


Route::group(['middleware' => ['jwt.auth', IsAdminMiddleware::class]], function () {



});

Route::group(['middleware' => ['jwt.auth', DynamicRoleMiddleware::class, RoleCRUDMiddleware::class], 'prefix' => 'moderator'], function () {

    Route::apiResource('posts', PostController::class);
    Route::apiResource('comments', CommentController::class);

});

Route::apiResource('comments', \App\Http\Controllers\Api\CommentController::class);
Route::apiResource('tags', \App\Http\Controllers\Api\TagController::class);
Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class);
Route::apiResource('profile', \App\Http\Controllers\Api\ProfileController::class);
//Route::apiResource('profiles', \App\Http\Controllers\Api\ProfileController::class);



//Route::get('/posts', [\App\Http\Controllers\Api\PostController::class, 'index']);
//Route::get('/posts/{post}', [\App\Http\Controllers\Api\PostController::class, 'show']);
//Route::post('/posts', [\App\Http\Controllers\Api\PostController::class, 'store']);
//Route::patch('/posts/{post}', [\App\Http\Controllers\Api\PostController::class, 'update']);
//Route::delete('/posts/{post}', [\App\Http\Controllers\Api\PostController::class, 'destroy']);
