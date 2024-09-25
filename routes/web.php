<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;


//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', [MainController::class, 'index'])->name('main.index');




Route::get('/profiles/main', [ProfileController::class, 'main'])->middleware('auth')->name('dashboard');





require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
