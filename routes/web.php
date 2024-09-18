<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\MainController;
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

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts.index');

});



require __DIR__.'/auth.php';
