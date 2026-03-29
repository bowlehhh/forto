<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardProjectController;
use App\Http\Controllers\DashboardSkillController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiteLikeController;
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

Route::controller(SiteLikeController::class)->group(function (): void {
    Route::post('/site-like', 'store')->name('site-like.store');
});

Route::middleware('forto.auth')
    ->group(function (): void {
        Route::controller(PageController::class)->group(function (): void {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
        });

        Route::prefix('/dashboard/projects')
            ->name('dashboard.projects.')
            ->controller(DashboardProjectController::class)
            ->group(function (): void {
                Route::post('/', 'store')->name('store');
                Route::get('/{projectId}/edit', 'edit')->name('edit');
                Route::put('/{projectId}', 'update')->name('update');
                Route::delete('/{projectId}', 'destroy')->name('destroy');
            });

        Route::prefix('/dashboard/skills')
            ->name('dashboard.skills.')
            ->controller(DashboardSkillController::class)
            ->group(function (): void {
                Route::post('/', 'store')->name('store');
                Route::delete('/{skillId}', 'destroy')->name('destroy');
            });
    });
