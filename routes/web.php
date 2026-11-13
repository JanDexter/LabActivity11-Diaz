<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/posts');

// manual login from Lab 9
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// /posts/create has to come before /posts/{id}, or "create" gets treated as an id
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
