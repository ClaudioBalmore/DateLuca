<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/@{slug}', function (string $slug) {
    $user = App\Models\User::where('slug', $slug)->firstOrFail();

    return Inertia::render('Dashboard', [
        'user' => $user,
        'links' => $user->links,
        'donations' => $user->donations,
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('dashboard.slug');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('links', \App\Http\Controllers\LinksController::class);

    Route::resource('donations', \App\Http\Controllers\DonationsController::class);
});

require __DIR__.'/auth.php';
