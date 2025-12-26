<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\EwasteRequestController as AdminEwasteRequestController;

use App\Http\Controllers\Collector\DashboardController as CollectorDashboardController;
use App\Http\Controllers\Collector\EwasteRequestController as CollectorEwasteRequestController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\EwasteRequestController as UserEwasteRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return redirect()->route('dashboard');
});


// Authentication Routes
require __DIR__ . '/auth.php';

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Dashboard Redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isCollector()) {
            return redirect()->route('collector.dashboard');
        }

        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Categories
        Route::resource('categories', AdminCategoryController::class);
        Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // E-Waste Requests
        Route::get('requests', [AdminEwasteRequestController::class, 'index'])->name('requests.index');
        Route::get('requests/{ewaste_request}', [AdminEwasteRequestController::class, 'show'])->name('requests.show');
        Route::post('requests/{ewaste_request}/assign', [AdminEwasteRequestController::class, 'assignCollector'])->name('requests.assign');
        Route::post('requests/{ewaste_request}/status', [AdminEwasteRequestController::class, 'updateStatus'])->name('requests.status');
        Route::post('requests/{ewaste_request}/remark', [AdminEwasteRequestController::class, 'updateRemark'])->name('requests.remark');
    });

    // Collector Routes
    Route::get('collector/requests/{ewaste_request}/details', [CollectorEwasteRequestController::class, 'showDetails'])->name('collector.requests.details');

    Route::middleware(['collector'])->prefix('collector')->name('collector.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [CollectorDashboardController::class, 'index'])->name('dashboard');

        // Assigned Requests
        Route::get('requests', [CollectorEwasteRequestController::class, 'index'])->name('requests.index');
        Route::post('requests/{ewaste_request}/collect', [CollectorEwasteRequestController::class, 'markCollected'])->name('requests.collect');
        Route::post('requests/{ewaste_request}/remark', [CollectorEwasteRequestController::class, 'updateRemark'])->name('requests.remark');
    });

    // User (Citizen) Routes
    Route::prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        // E-Waste Requests
        Route::resource('requests', UserEwasteRequestController::class);
        Route::post('requests/{ewaste_request}/cancel', [UserEwasteRequestController::class, 'cancel'])->name('requests.cancel');
    });
});
