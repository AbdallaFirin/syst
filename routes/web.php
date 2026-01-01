<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlaceCategoryController;
use App\Http\Controllers\PlaceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Place Management Routes
    Route::resource('place-categories', PlaceCategoryController::class);
    Route::resource('places', PlaceController::class);

    // Staff Management Routes
    Route::resource('staff', \App\Http\Controllers\StaffController::class);

    // Asset Management Routes
    Route::resource('vehicles', \App\Http\Controllers\VehicleController::class);
    Route::resource('chemicals', \App\Http\Controllers\ChemicalController::class);

    // Policy Management Routes
    Route::resource('policies', \App\Http\Controllers\PolicyController::class);

    // Fire Incident Management Routes
    Route::resource('incident-causes', \App\Http\Controllers\IncidentCauseController::class);
    Route::resource('fire-incidents', \App\Http\Controllers\FireIncidentController::class);

    // Reports
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    // Organization Settings
    Route::get('/organization', [\App\Http\Controllers\OrganizationController::class, 'edit'])->name('organization.edit');
    Route::post('/organization', [\App\Http\Controllers\OrganizationController::class, 'update'])->name('organization.update');
});

require __DIR__.'/auth.php';
