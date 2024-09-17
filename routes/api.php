<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(\App\Http\Controllers\Api\AuthenticationController::class)->group(function (){
    Route::post('/users/register', 'register');
    Route::post('/users/token', 'login');
});

Route::controller(\App\Http\Controllers\Api\PostController::class)->middleware('auth:sanctum')->group(function (){
    Route::post('/posts', 'store');
    Route::patch('/posts/{post}', 'update');
    Route::get('/posts', 'index');
    Route::get('/post/{post}', 'show');
    Route::delete('/posts/{post}', 'destroy');
});

Route::controller(\App\Http\Controllers\Api\CommentController::class)->middleware('auth:sanctum')->group(function (){
    Route::post('/posts/{post}/comment', 'store');
    Route::patch('/comments/{comment}', 'update');
    Route::delete('/comments/{comment}', 'destroy');
});
