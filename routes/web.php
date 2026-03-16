<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationsController;
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

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    $user = $request->user();

    return redirect()->route('dashboard.slug', ['slug' => $user->slug]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/@{slug}', function (string $slug) {
    $user = App\Models\User::where('slug', $slug)->firstOrFail();

    return Inertia::render('Dashboard', [
        'user' => $user,
        'links' => $user->links()->latest()->get(),
        'donations' => $user->donations()->orderByDesc('created_at')->get(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('dashboard.slug');

Route::post('/@{slug}/donations', [DonationsController::class, 'storeFromPublicProfile'])
    ->name('donations.public.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/links', [\App\Http\Controllers\LinksController::class, 'store'])->name('links.store');
    Route::put('/links/{link}', [\App\Http\Controllers\LinksController::class, 'update'])->name('links.update');
    Route::delete('/links/{link}', [\App\Http\Controllers\LinksController::class, 'destroy'])->name('links.destroy');

    Route::resource('donations', DonationsController::class);
});

require __DIR__.'/auth.php';
