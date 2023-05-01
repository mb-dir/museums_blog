<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

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

// Show all posts
Route::get('/', [PostController::class, 'index']);

// Create post view
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth');

// Create post logic
Route::post('/posts', [PostController::class, 'store'])->middleware('auth');

// Edit post
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth');

// Show single post
Route::get('/posts/{post}', [PostController::class, 'show']);

// Delete post
Route::delete('/posts/{post}', [PostController::class, 'delete'])->middleware('auth');

// Show Register/Create Form for not auth user
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
