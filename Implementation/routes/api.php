<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommenterController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProfilJourController;
use App\Http\Controllers\ProfilManagerClubController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', \App\Http\Controllers\UserController::class);
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::apiResource('posts', \App\Http\Controllers\PostsController::class);
    Route::apiResource('experiences', \App\Http\Controllers\ExperienceController::class);
    Route::apiResource('comment', \App\Http\Controllers\CommenterController::class);
        Route::post('comment/{post_id}' , [CommenterController::class , 'store']);

        Route::post('like/{type}/{id}', [LikeController::class , 'store']);

    Route::get('/profile/{id}', [ProfilController::class, 'show']);
    Route::get('/profile', [ProfilController::class, 'getAuthenticatedProfile']);

});
