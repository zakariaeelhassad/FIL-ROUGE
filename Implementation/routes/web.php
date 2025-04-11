<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/profil_joueur', function () {
    return view('pages.profil_joueur');
});


Route::get('/profil_Club', function () {
    return view('pages.profil_club_manager');
});

Route::get('/reseau', function () {
    return view('pages.reseau');
});

Route::middleware('auth')->group(function () {
    Route::get('/reseau', [UserController::class, 'reseau'])->name('reseau');
});

Route::get('/notification', function () {
    return view('pages.notification');
});


Route::get('/signup', [UserController::class, 'create'])->name('signup');
Route::post('/signup', [UserController::class, 'store'])->name('signup.store');

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/', [PostsController::class, 'index'])->name('posts.index');

Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
