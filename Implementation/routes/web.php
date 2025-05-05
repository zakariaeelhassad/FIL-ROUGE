<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClubAdminProfileController;
use App\Http\Controllers\CommenterController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TitreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/users/admin', [adminController::class, 'users'])->name('users.admin');
    Route::delete('user/{id}/delete' , [UserController::class , 'destroy'])->name('delete.user');
    Route::get('/posts/admin', [adminController::class, 'posts'])->name('posts.admin');
    Route::get('/comments/admin', [adminController::class, 'comments'])->name('comments');
    Route::get('/reports/admin', [adminController::class, 'reports'])->name('reports');
    Route::get('/dashboard', [adminController::class , 'dashboard'])->name('dashboard.admin');
});




Route::middleware('auth')->group(function () {
    Route::get('/reseau', [FollowController::class, 'reseau'])->name('reseau');
    Route::get('/', [PostsController::class, 'index'])->name('posts.index');
    Route::put('/profiles/{userId}', [ClubAdminProfileController::class, 'update'])->name('profiles.update');
    Route::get('/profil/joueur', [ProfilController::class, 'profil'])->name('profil.joueur');
    Route::get('/profiles/{userId}', [ClubAdminProfileController::class, 'show'])->name('profiles.show');
    Route::get('/profil/{id}', [ProfilController::class, 'showprofil'])->name('profil.show');
    Route::post('/titres', [TitreController::class, 'store'])->name('titres.store');
    Route::post('/titres/{id}/delete', [TitreController::class, 'destroy'])->name('titres.delete');
    Route::get('edit/{id}/titre', [TitreController::class, 'edit'])->name('edit.titre');
    Route::put('update/{id}/titre', [TitreController::class, 'update'])->name('update.titre');    
    Route::put('/user/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::post('/experience', [ExperienceController::class, 'store'])->name('experiences.store');
    Route::post('/experience/{id}/delete', [ExperienceController::class, 'destroy'])->name('experiences.delete');

    Route::get('/social-media/edit', [SocialMediaController::class, 'edit'])->name('social-media.edit');
    Route::put('/social-media/update', [SocialMediaController::class, 'update'])->name('social-media.update');
});

Route::middleware('auth')->group(function () {    
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
    Route::delete('/post/{id}/delete' ,[PostsController::class , 'destroy'])->name('delete.post');
    Route::get('edit/{id}/post', [PostsController::class, 'edit'])->name('edit.post');
    Route::put('updat/{id}/post' , [PostsController::class , 'update'])->name('update.post');
    Route::post('/posts/{postId}/react', [ReactionController::class, 'store'])->name('posts.react.store');
    Route::delete('/posts/{postId}/react', [ReactionController::class, 'destroy'])->name('posts.react.destroy');
});

Route::middleware('auth')->group(function () {    
    Route::post('/posts/{postId}/comment', [CommenterController::class, 'store'])->name('comments.store');
    Route::get('/comments/{id}', [CommenterController::class, 'show'])->name('comments.show');
    Route::put('/comments/{id}', [CommenterController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommenterController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/replies', [CommentReplyController::class, 'store'])->name('comment.replies.store');
});

Route::middleware('auth')->group(function () {    
    Route::post('/follow/{userId}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{userId}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::post('/follow/{followId}/accept', [FollowController::class, 'acceptFollowRequest'])->name('follow.accept');
    Route::post('/follow/{followId}/reject', [FollowController::class, 'rejectFollowRequest'])->name('follow.reject');
    Route::get('/followers/{userId?}', [FollowController::class, 'followers'])->name('followers');
    Route::get('/following/{userId?}', [FollowController::class, 'following'])->name('following');
    Route::get('/suggestions', [FollowController::class, 'suggestions'])->name('suggestions');
});

Route::middleware('auth')->group(function () {    
    Route::get('/chats', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chats/create', [ChatController::class, 'create'])->name('chat.create');
    Route::post('/chats', [ChatController::class, 'storeChat'])->name('chat.storeChat');
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chats/{chat}/messages', [ChatController::class, 'store'])->name('chat.messages.store');
});

Route::middleware('auth')->group(function () {    
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports', [ReportController::class, 'index']); 
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('repost.delete');
});




Route::get('/notification', function () {
    return view('pages.notification');
});

Route::get('/signup', [UserController::class, 'create'])->name('signup');
Route::post('/signup', [UserController::class, 'store'])->name('signup.store');

Route::get('/posts', [PostsController::class, 'show'])->name('posts.show');

Route::get('/login', [SessionController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [SessionController::class, 'login'])->name('login');

Route::post('/logout', [SessionController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    
    Route::get('/invitations/player', [InvitationController::class, 'playerInvitations'])->name('invitations.player');
    Route::post('/invitations/{id}/accept', [InvitationController::class, 'acceptInvitation'])->name('invitations.accept');
    Route::post('/invitations/{id}/reject', [InvitationController::class, 'rejectInvitation'])->name('invitations.reject');
    
});