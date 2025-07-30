<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Settings;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Public Article routes
Route::get('/articles', [App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

Route::get('/storage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);
    if (!file_exists($path) || !in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['jpg', 'png', 'pdf', 'svg'])) {
        abort(404);
    }
    return response()->file($path);
})->where('filename', '.*');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [Dashboard\HomeController::class, 'index'])->name('dashboard');

    Route::get('kuisioner', [Dashboard\AssesmentController::class, 'index'])->name('kuisioner.index');
    Route::get('kuisioner/create', [Dashboard\AssesmentController::class, 'create'])->name('kuisioner.create');
    Route::post('kuisioner', [Dashboard\AssesmentController::class, 'store'])->name('kuisioner.store');

    Route::get('kuisioner/history', [Dashboard\HistoryController::class, 'index'])->name('history.index');

    Route::get('recommendation', [Dashboard\RecommendationController::class, 'index'])->name('recommendation.index');

    Route::get('chat/dokter', [Dashboard\DokterController::class, 'index'])->name('dokter.index');

    // Chat routes
    Route::get('chat/doctors', [ChatController::class, 'doctors'])->name('chat.doctors');
    Route::post('chat/start/{doctor}', [ChatController::class, 'startChat'])->name('chat.start');
    Route::get('chat/room/{chat}', [ChatController::class, 'room'])->name('chat.room');
    Route::post('chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('chat/{chat}/close', [ChatController::class, 'closeChat'])->name('chat.close');
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/history', [ChatController::class, 'history'])->name('chat.history');
    Route::get('chat/{chat}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

    // Dashboard Article routes (admin only)
    Route::resource('dashboard/articles', Dashboard\ArticleController::class, ['as' => 'dashboard']);

    // User Management routes (admin only)
    Route::resource('dashboard/users', Dashboard\UserController::class, ['as' => 'dashboard']);

    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});

require __DIR__ . '/auth.php';
