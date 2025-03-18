<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
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
Route::post('/register' , [AuthController::class , 'register']);
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::get('/my-posts', [PostController::class, 'myPosts']);
    Route::post('/posts', [PostController::class , 'store']);
    Route::delete('/posts/{postId}/delete', [PostController::class, 'destroy']);
    Route::put('/posts/{postId}/update', [PostController::class, 'update']);
    Route::post('posts/{postId}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);
    Route::post('likes/{type}/{id}', [LikeController::class, 'store']);
    Route::delete('likes/{type}/{id}', [LikeController::class, 'destroy']); 
});