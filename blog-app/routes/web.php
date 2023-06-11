<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

// Show all posts(main page)
Route::get('/', [PostController::class, 'index']);

// Create post view
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth');

// Create post logic
Route::post('/posts', [PostController::class, 'store'])->middleware('auth');

// Create new comment
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth');

// Edit post view
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth');

// Update post
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth');

// Show single post
Route::get('/posts/{post}', [PostController::class, 'show']);

// Delete post
Route::delete('/posts/{post}', [PostController::class, 'delete'])->middleware('auth');

// Show Register/Create Form for not auth user
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Show user info
Route::get('/user-info/{user}', [UserController::class, 'show'])->middleware('auth');

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Delete user
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware("auth");

// Show user for admin
Route::get('/users/{user}', [UserController::class, 'showUser'])->middleware("auth");

// Update user view
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth');

// Update user
Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth');

// Change user status
Route::put('/users/status-change/{user}', [UserController::class, 'changeUserStatus'])->middleware('auth');


