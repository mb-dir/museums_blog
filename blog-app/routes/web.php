<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// PostController
Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth')->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');

// CommentController
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

// AuthController
Route::get('/register', [AuthController::class, 'create'])->middleware('guest')->name('register');
Route::post('/users', [AuthController::class, 'store'])->name('users.store');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/users/authenticate', [AuthController::class, 'authenticate'])->name('users.authenticate');

// UserController
Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth')->name('users.show');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('auth')->name('users.destroy');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth')->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth')->name('users.update');
Route::patch('/users/{user}', [UserController::class, 'changeStatus'])->middleware('auth')->name('users.changeStatus');

// AdminController
Route::get('/admin-panel', [AdminController::class, 'index'])->middleware('auth')->name('adminPanel');
Route::get('/admin-panel/users/{user}', [AdminController::class, 'show'])->middleware('auth')->name('adminPanel.users.show');


