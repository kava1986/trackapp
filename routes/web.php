
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [TrackingController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get(uri: '/tracking/generate', action: [TrackingController::class, 'create'])->name(name: 'tracking.generate');
Route::post(uri: '/tracking/generate', action: [TrackingController::class, 'store'])->name(name: 'tracking.store');

Route::get(uri: '/tracking/{code}', action: [TrackingController::class, 'show'])->name(name: 'tracking.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/tracking/{code}', [TrackingController::class, 'show'])->name('tracking.show');
});

Route::put('/tracking/{id}/update-status1', [TrackingController::class, 'updateStatus1'])->name('tracking.updateStatus1');
Route::put('/tracking/{id}/update-status2', [TrackingController::class, 'updateStatus2'])->name('tracking.updateStatus2');
Route::get('/download-qr/{code}', [TrackingController::class, 'downloadPDF']);


require __DIR__.'/auth.php';
