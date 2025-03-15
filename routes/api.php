<?php

use App\Http\Controllers\AuthController;
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
    Route::post('/post', [PostController::class , 'store']);
    Route::delete('/posts/{id}/delete', [PostController::class, 'destroy']);
    Route::put('/posts/{id}/update', [PostController::class, 'update']);
});