<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardProjectController;
use App\Http\Controllers\DashboardSkillController;
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

        Route::controller(DashboardProjectController::class)->group(function (): void {
            Route::post('/dashboard/projects', 'store')->name('dashboard.projects.store');
            Route::get('/dashboard/projects/{project}/edit', 'edit')->name('dashboard.projects.edit');
            Route::put('/dashboard/projects/{project}', 'update')->name('dashboard.projects.update');
            Route::delete('/dashboard/projects/{project}', 'destroy')->name('dashboard.projects.destroy');
        });

        Route::controller(DashboardSkillController::class)->group(function (): void {
            Route::post('/dashboard/skills', 'store')->name('dashboard.skills.store');
            Route::get('/dashboard/skills/{skill}/edit', 'edit')->name('dashboard.skills.edit');
            Route::put('/dashboard/skills/{skill}', 'update')->name('dashboard.skills.update');
            Route::delete('/dashboard/skills/{skill}', 'destroy')->name('dashboard.skills.destroy');
        });
    });
