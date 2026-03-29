<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/projects', 'projects')->name('projects');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/skills', 'skills')->name('skills');
    Route::get('/community', 'community')->name('community');
});

Route::controller(AuthController::class)->group(function (): void {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.store');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware('forto.auth')
    ->group(function (): void {
        Route::controller(PageController::class)->group(function (): void {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
        });
    });
