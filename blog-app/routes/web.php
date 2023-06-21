<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

// PostController
Route::get('/', [PostController::class, 'index']); // Show all posts (homepage)
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth'); // Show create post view
Route::post('/posts', [PostController::class, 'store'])->middleware('auth'); // Save new post
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth'); // Show edit post view
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth'); // Update post
Route::get('/posts/{post}', [PostController::class, 'show']); // Show single post
Route::delete('/posts/{post}', [PostController::class, 'delete'])->middleware('auth'); // Delete post

// CommentController
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth'); // Add new comment

// AuthController
Route::get('/register', [AuthController::class, 'create'])->middleware('guest'); // Show registration form for non-authenticated user
Route::post('/users', [AuthController::class, 'store']); // Create new user
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth'); // Log out user
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest'); // Show login form
Route::post('/users/authenticate', [AuthController::class, 'authenticate']); // Authenticate user

// UserController
Route::get('/user-info/{user}', [UserController::class, 'show'])->middleware('auth'); // Show user information
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware("auth"); // Delete user
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth'); // Show user edit view
Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth'); // Update user
Route::patch('/users/status-change/{user}', [UserController::class, 'changeUserStatus'])->middleware('auth'); // Change user status
Route::get('/admin-panel', [UserController::class, 'getAdminPanel'])->middleware('auth');
Route::get('/users/{user}', [UserController::class, 'showUser'])->middleware("auth"); // Show user (for admin)

