<?php

use App\Http\Controllers\HostController;
use Illuminate\Support\Facades\Route;


/*
 * Publicly accessible routes
 */
Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

Route::get('hosts', [HostController::class, 'index']);
Route::get('hosts/{id}', [HostController::class, 'show']);

Route::get('events', [\App\Http\Controllers\EventController::class, 'index'] )->name('events.index');
Route::get('events/{id}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');

Route::post('comments', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');


require __DIR__.'/auth.php';
/*
 * Routes that require authentication
 */
Route::middleware('auth')->group(function () {
    Route::get('management/events', [\App\Http\Controllers\EventManagementController::class, 'index'])->name('events.index');
    Route::get('management/events/create', [\App\Http\Controllers\EventManagementController::class, 'create'])->name('events.create');
    Route::post('management/events', [\App\Http\Controllers\EventManagementController::class, 'store'])->name('events.store');
    Route::get('management/events/{id}/edit', [\App\Http\Controllers\EventManagementController::class, 'edit'])->name('events.edit');
    Route::put('management/events/{id}', [\App\Http\Controllers\EventManagementController::class, 'update'])->name('events.update');
    Route::delete('management/events/{id}', [\App\Http\Controllers\EventManagementController::class, 'destroy'])->name('events.destroy');
});
