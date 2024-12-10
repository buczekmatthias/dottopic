<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'homepage'])->name('homepage');

Route::controller(SecurityController::class)->prefix('security')->name('security.')->group(function () {
	Route::get('/logout', 'logout')->name('logout')->middleware('web');

	Route::middleware('guest')->group(function () {
		Route::get('/login', 'login')->name('login');
		Route::post('/login', 'handleLogin');

		Route::get('/register', 'register')->name('register');
		Route::post('/register', 'handleRegister');
	});
});
