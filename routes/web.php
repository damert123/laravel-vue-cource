<?php


use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Api\ProfileController;
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

Route::get('/', [MainController::class, 'index'])->middleware('auth')->name('main.index');




Route::get('/profile', [ProfileController::class, 'indexProfile'])->name('profile.index');
Route::get('/posts/{post}/comments', [PostController::class, 'commentList'])->name('posts.comments.index');
Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
Route::delete('/posts/{post}/comments/{comment}', [PostController::class, 'destroyComment'])->name('posts.comments.destroy');







//Route::get('/profiles/main', [ProfileController::class, 'main'])->middleware('auth')->name('dashboard');





require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
