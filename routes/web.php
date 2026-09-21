<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (strtolower(auth()->user()->role) === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('pelanggan.dashboard');
    }
    return redirect()->route('login');
});

use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\StatusUnitController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $totalUnit = \App\Models\Unit::count();
        $unitTersedia = \App\Models\Unit::where('status_unit', 'Tersedia')->count();
        $unitDisewa = \App\Models\Unit::where('status_unit', 'Disewa')->count();
        return view('admin.dashboard', compact('totalUnit', 'unitTersedia', 'unitDisewa'));
    })->name('admin.dashboard');

    // Modul Kelola Data Unit (FR-010, FR-015, FR-020)
    Route::get('/admin/units', [UnitController::class, 'index'])->name('admin.units.index');
    Route::post('/admin/units', [UnitController::class, 'store'])->name('admin.units.store');
    Route::get('/admin/units/{id}', [UnitController::class, 'show'])->name('admin.units.show');
    Route::put('/admin/units/{id}', [UnitController::class, 'update'])->name('admin.units.update');
    Route::patch('/admin/units/{id}/status', [UnitController::class, 'updateStatus'])->name('admin.units.status');
    Route::delete('/admin/units/{id}', [UnitController::class, 'destroy'])->name('admin.units.destroy');

    // Modul Status Unit / Monitoring Status Unit ( FR-015, Use Case 10)
    Route::get('/admin/status-unit', [StatusUnitController::class, 'index'])->name('admin.status-unit.index');
    Route::post('/admin/status-unit', [StatusUnitController::class, 'store'])->name('admin.status-unit.store');
    Route::patch('/admin/status-unit/{id}', [StatusUnitController::class, 'updateStatus'])->name('admin.status-unit.update');
    Route::get('/admin/status-unit/{id}/history', [StatusUnitController::class, 'history'])->name('admin.status-unit.history');
});

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', function () {
        return view('pelanggan.dashboard');
    })->name('pelanggan.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
