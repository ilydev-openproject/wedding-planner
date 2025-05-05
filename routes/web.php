<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\UserActivationPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\Auth\GoogleController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::middleware(['auth'])->group(function () {
    Route::get('/aktivasi', UserActivationPage::class)->name('aktivasi');
});
// require __DIR__ . '/auth.php';
