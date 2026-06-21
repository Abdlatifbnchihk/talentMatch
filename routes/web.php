<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('offers.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('offers', JobOfferController::class);
    Route::get('candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::resource('offers.candidates', CandidateController::class)->except(['index']);
    Route::get('candidates/{candidate}/chat', [ChatController::class, 'show'])->name('candidates.chat.show');
    Route::post('candidates/{candidate}/chat', [ChatController::class, 'message'])->name('candidates.chat.message');
});

require __DIR__.'/auth.php';
