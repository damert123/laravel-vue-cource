<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', IsAdminMiddleware::class]], function () {
    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts.index');
    Route::get('/posts/{post}/comments', [PostController::class, 'commentList'])->name('admin.posts.comments.index');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('admin.posts.show');
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/posts', [PostController::class, 'store'])->name('admin.posts.store');
    Route::post('/comment', [CommentController::class, 'store'])->name('admin.comment.store');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');


});

