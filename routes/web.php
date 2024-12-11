<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'homepage'])->name('homepage');

Route::controller(SecurityController::class)->prefix('security')->name('security.')->group(function () {
	Route::get('/logout', 'logout')->name('logout')->middleware('auth');

	Route::middleware('guest')->group(function () {
		Route::get('/login', 'login')->name('login');
		Route::post('/login', 'handleLogin');

		Route::get('/register', 'register')->name('register');
		Route::post('/register', 'handleRegister');
	});
});

Route::resource('users', UserController::class)->only(['index', 'show']);
Route::resource('articles', ArticleController::class);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);
Route::resource('tags', TagController::class)->only(['index', 'show']);

Route::resource('comments', CommentController::class)->middleware('auth')->only(['store', 'update', 'destroy']);
Route::resource('reactions', ReactionController::class)->middleware('auth')->only(['store', 'destroy']);

Route::prefix('admin')->name('admin.')->middleware('mod')->group(function () {
	Route::get('/', [AppController::class, 'adminDashboard'])->name('dashboard');
	Route::resource('users', UserController::class)->only(['edit', 'update', 'destroy']);
	Route::get('users/{user}/promote', [UserController::class, 'promote'])->name('users.promote');
	Route::get('users/{user}/demote', [UserController::class, 'demote'])->name('users.demote');
	Route::resource('categories', CategoryController::class)->except(['index', 'show']);
	Route::resource('tags', TagController::class)->except(['index', 'show']);
});
