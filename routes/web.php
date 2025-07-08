<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [Dashboard\HomeController::class, 'index'])->name('dashboard');

    Route::get('kuisioner', [Dashboard\AssesmentController::class, 'index'])->name('kuisioner.index');
    Route::get('kuisioner/create', [Dashboard\AssesmentController::class, 'create'])->name('kuisioner.create');
    Route::post('kuisioner', [Dashboard\AssesmentController::class, 'store'])->name('kuisioner.store');
    
    Route::get('kuisioner/history', [Dashboard\HistoryController::class, 'index'])->name('history.index');

    Route::get('recommendation', [Dashboard\RecommendationController::class, 'index'])->name('recommendation.index');

    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

require __DIR__ . '/auth.php';