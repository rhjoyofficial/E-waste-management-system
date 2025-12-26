<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\EwasteRequestController as AdminEwasteRequestController;

use App\Http\Controllers\Collector\DashboardController as CollectorDashboardController;
use App\Http\Controllers\Collector\EwasteRequestController as CollectorEwasteRequestController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\EwasteRequestController as UserEwasteRequestController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Redirect
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('collector')) {
        return redirect()->route('collector.dashboard');
    }

    return redirect()->route('user.dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Category Management
        Route::resource('categories', AdminCategoryController::class)
            ->except(['show']);

        // E-Waste Requests
        Route::get('requests', [AdminEwasteRequestController::class, 'index'])
            ->name('requests.index');

        Route::get('requests/{id}', [AdminEwasteRequestController::class, 'show'])
            ->name('requests.show');

        Route::post('requests/{id}/assign', [AdminEwasteRequestController::class, 'assignCollector'])
            ->name('requests.assign');

        Route::post('requests/{id}/status', [AdminEwasteRequestController::class, 'updateStatus'])
            ->name('requests.status');
    });

/*
|--------------------------------------------------------------------------
| Collector Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'collector'])
    ->prefix('collector')
    ->as('collector.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [CollectorDashboardController::class, 'index'])
            ->name('dashboard');

        // Assigned Requests
        Route::get('requests', [CollectorEwasteRequestController::class, 'index'])
            ->name('requests.index');

        Route::post('requests/{id}/collect', [CollectorEwasteRequestController::class, 'markCollected'])
            ->name('requests.collect');
    });

/*
|--------------------------------------------------------------------------
| User (Citizen) Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('user')
    ->as('user.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        // E-Waste Requests CRUD
        Route::resource('requests', UserEwasteRequestController::class);
    });

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
