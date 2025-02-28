<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/toggle-like', [LikeController::class, 'togglePostLike'])->name('posts.like');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Profile routes
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes des commentaires
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Routes des connexions
    Route::get('/connections', [ConnectionController::class, 'getAllConnections'])->name('connections.index');
    Route::get('/connections/pending', [ConnectionController::class, 'getPendingRequests'])->name('connections.pending');
    Route::post('/connections/{user}', [ConnectionController::class, 'sendRequest'])->name('connections.send');
    Route::post('/connections', [ConnectionController::class, 'store'])->name('connections.store'); // Ajout de cette ligne
    Route::post('/connections/{connection}/accept', [ConnectionController::class, 'acceptRequest'])->name('connections.accept');
    Route::delete('/connections/{connection}/reject', [ConnectionController::class, 'rejectRequest'])->name('connections.reject');
    Route::delete('/connections/{connection}/cancel', [ConnectionController::class, 'cancelRequest'])->name('connections.cancel');
    Route::delete('/connections/{connection}', [ConnectionController::class, 'removeConnection'])->name('connections.remove');
});

require __DIR__ . '/auth.php';
