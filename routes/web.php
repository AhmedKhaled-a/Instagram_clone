<?php

use App\Mail\testmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;


use App\Http\Controllers\FollowerController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/send', function () {
    Mail::to('may.ahmed.kassem@gmail.com')->send( new testmail());
    return response ('sending');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // posts routes
    Route::get('/posts/create',[PostController::class,'create'])->name('posts.create');
    Route::post('/posts',[PostController::class,'store'])->name('posts.store');
});

// posts routes
Route::get('/posts',[PostController::class ,'index'])->name('posts.index');

Route::get('/posts/{id}',[PostController::class,'show'] )->name('posts.show')->middleware('auth');

Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
->name('posts.edit')->middleware('auth');

Route::put('/posts/{id}', [PostController::class, 'update'])
->name('posts.update')->middleware('auth');

Route::delete('/posts/{id}', [PostController::class, 'destroy'])
->name('posts.destroy')->middleware('auth');

// search
Route::get('/search', [PostController::class, 'search'])
->name('posts.search')->middleware('auth');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/block/{blockedUser}', [UserController::class, 'blockUser'])->name('users.block');
    Route::post('/unblock/{blockedUser}', [UserController::class, 'unblockUser'])->name('users.unblock');

});

Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile.index')->where('id', '[0-9]+');

Route::post('/profile/{user}/follow',[FollowerController::class,'follow'])->middleware('auth')->name('user.follow');
Route::post('/profile/{user}/unfollow',[FollowerController::class,'unfollow'])->middleware('auth')->name('user.unfollow');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

use Illuminate\Foundation\Auth\EmailVerificationRequest;
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

use Illuminate\Http\Request;
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

require __DIR__.'/auth.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/tags/{id}',[TagController::class,'show'] )->name('tags.show');

Route::get('/posts/saved/index',[PostController::class,'showSaved'])->name('saved-posts.show');
