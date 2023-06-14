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
Route::get('/', [PostController::class, 'index']); // Wyświetl wszystkie posty (strona główna)
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth'); // Wyświetl widok tworzenia postu
Route::post('/posts', [PostController::class, 'store'])->middleware('auth'); // Zapisz nowy post
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth'); // Wyświetl widok edycji postu
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth'); // Aktualizuj post
Route::get('/posts/{post}', [PostController::class, 'show']); // Wyświetl pojedynczy post
Route::delete('/posts/{post}', [PostController::class, 'delete'])->middleware('auth'); // Usuń post

// CommentController
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth'); // Dodaj nowy komentarz

// AuthController
Route::get('/register', [AuthController::class, 'create'])->middleware('guest'); // Wyświetl formularz rejestracji dla niezalogowanego użytkownika
Route::post('/users', [AuthController::class, 'store']); // Stwórz nowego użytkownika
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth'); // Wyloguj użytkownika
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest'); // Wyświetl formularz logowania
Route::post('/users/authenticate', [AuthController::class, 'authenticate']); // Zaloguj użytkownika

// UserController
Route::get('/user-info/{user}', [UserController::class, 'show'])->middleware('auth'); // Wyświetl informacje o użytkowniku
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware("auth"); // Usuń użytkownika
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('auth'); // Wyświetl widok edycji użytkownika
Route::put('/users/{user}', [UserController::class, 'update'])->middleware('auth'); // Aktualizuj użytkownika
Route::patch('/users/status-change/{user}', [UserController::class, 'changeUserStatus'])->middleware('auth'); // Zmień status użytkownika
Route::get('/users/{user}', [UserController::class, 'showUser'])->middleware("auth"); // Wyświetl użytkownika (dla administratora)
