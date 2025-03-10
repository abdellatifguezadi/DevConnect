<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\JobOfferController;
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
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/conversations', [ChatController::class, 'getConversations'])->name('chat.conversations');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/messages', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/unread', [ChatController::class, 'getUnreadCount'])->name('chat.unread');
    Route::post('/chat/messages/{messageId}/read', [ChatController::class, 'markAsRead'])->name('chat.read');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::get('/load-more-posts', [PostController::class, 'loadMorePosts'])->name('posts.loadMore');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/toggle-like', [LikeController::class, 'togglePostLike'])->name('posts.like');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');


    Route::get('/tweet', [TweetController::class, 'create'])->name('tweets.create');
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');
    Route::view('pusher1', 'pusher1');
    Route::view('pusher2', 'pusher2');

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
    Route::delete('/connections/{user}', [ConnectionController::class, 'destroy'])->name('connections.destroy');

    // Recherche d'utilisateurs et hashtags
    Route::get('/search/users', [SearchController::class, 'searchUsers'])->name('search.users');
    Route::get('/hashtags/{hashtag}', [SearchController::class, 'showHashtag'])->name('hashtags.show');
    Route::get('/languages/{language}', [SearchController::class, 'showLanguage'])->name('languages.show');

    // Ajouter routes pour les notifications
    Route::get('/notifications/get', [NotificationController::class, 'getNotifications']);
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
    Route::get('/notifications/count', [NotificationController::class, 'getUnreadCount']);
    
    // // Route de test pour les notifications
    // Route::get('/test-notification', function() {
    //     $user = auth()->user();
    //     if (!$user) return redirect()->back();
        
    //     // Envoyer une notification de test
    //     event(new \App\Events\TestNotification($user));
    //     return redirect()->back()->with('success', 'Notification de test envoyée!');
    // })->name('test-notification');

    // Routes pour les offres d'emploi
    Route::resource('job-offers', JobOfferController::class);
});

require __DIR__ . '/auth.php';
