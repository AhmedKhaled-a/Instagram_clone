<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\ImageController;

use App\Http\Middleware\Cors;



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

// like / unlike

// delete image
Route::delete('/images/{id}', [ImageController::class, 'destroy'])
->name('images.destroy')->middleware('auth:sanctum');

// delete post
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/posts/{id}/likes', [PostController::class, 'likes']);

// toggle like
Route::post('/posts/{id}/togglelike', [PostController::class, 'toggleLike'])->name('posts.toggle-like')->middleware('auth:sanctum');

Route::post('/posts/save', [PostController::class, 'savePost'])->name('posts.save-post')->middleware('auth:sanctum');

// comments route

Route::delete('/posts/{id}/comments', [CommentController::class, 'destroy'])->name('comment.destroy')->middleware('auth:sanctum');
Route::post('/posts/{id}/comments',[CommentController::class,'store']) ->name('comment.store')->middleware('auth:sanctum');

