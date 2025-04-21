<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClubAdminProfileController;
use App\Http\Controllers\CommenterController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TitreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/profil_joueur', function () {
    return view('pages.profil_joueur');
});

Route::get('/h', function () {
    return view('pages.h');
});

Route::middleware('auth')->group(function () {
    Route::get('/reseau', [UserController::class, 'reseau'])->name('reseau');
    Route::get('/', [PostsController::class, 'index'])->name('posts.index');
    Route::get('/h', [PostsController::class, 'h'])->name('posts.index');
    Route::put('/profiles/{userId}', [ClubAdminProfileController::class, 'update'])->name('profiles.update');
    Route::get('/profil/joueur', [PostsController::class, 'profil'])->name('profil.joueur');
    Route::get('/profiles/{userId}', [ClubAdminProfileController::class, 'show'])->name('profiles.show');
    Route::post('/titres', [TitreController::class, 'store'])->name('titres.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
    Route::post('/experience', [ExperienceController::class, 'store'])->name('experiences.store');
    // Routes for Reactions
    Route::post('/posts/{postId}/react', [ReactionController::class, 'store'])->name('posts.react.store');
    Route::delete('/posts/{postId}/react', [ReactionController::class, 'destroy'])->name('posts.react.destroy');
    // Routes for Comments
    Route::post('/posts/{postId}/comment', [CommenterController::class, 'store'])->name('comments.store');
    Route::get('/comments/{id}', [CommenterController::class, 'show'])->name('comments.show');
    Route::put('/comments/{id}', [CommenterController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommenterController::class, 'destroy'])->name('comments.destroy');
    // Routes for Comment Replies
    Route::post('/comments/{comment}/replies', [CommentReplyController::class, 'store'])->name('comment.replies.store');

    Route::post('/follow/{userId}', [FollowController::class, 'follow'])->name('follow.send');
    Route::post('/follow/accept/{userId}', [FollowController::class, 'acceptFollow'])->name('follow.accept');
    Route::post('/follow/reject/{userId}', [FollowController::class, 'rejectFollow'])->name('follow.reject');
    Route::post('/unfollow/{userId}', [FollowController::class, 'unfollow'])->name('follow.unfollow');
    Route::get('/pending-requests', [FollowController::class, 'pendingRequests'])->name('follow.pending');
    Route::get('/friends', [FollowController::class, 'friendsList'])->name('friends.list');

});

Route::middleware('auth')->group(function () {    
    // Chat routes
    Route::get('/chats', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chats/create', [ChatController::class, 'create'])->name('chat.create');
    Route::post('/chats', [ChatController::class, 'storeChat'])->name('chat.storeChat');
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chats/{chat}/messages', [ChatController::class, 'store'])->name('chat.messages.store');
});

Route::post('/chats/{chat}/messages/{message}/read', function (App\Models\Chat $chat, App\Models\Message $message) {
    // Check if the authenticated user is the receiver of this message
    if ($message->receiver_id === auth()->id()) {
        $message->update(['read' => true]);
        return response()->json(['status' => 'Message marked as read']);
    }
    
    return response()->json(['status' => 'Unauthorized'], 403);
})->middleware('auth')->name('chat.messages.read');


Route::get('/notification', function () {
    return view('pages.notification');
});

Route::get('/signup', [UserController::class, 'create'])->name('signup');
Route::post('/signup', [UserController::class, 'store'])->name('signup.store');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/posts', [PostsController::class, 'show'])->name('posts.show');

Route::get('/login', [SessionController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [SessionController::class, 'login']);

Route::post('/logout', [SessionController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
