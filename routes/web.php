<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile.index')->where('id', '[0-9]+');

Route::post('/profile/{user}/follow',[FollowerController::class,'follow'])->middleware('auth')->name('user.follow');
Route::post('/profile/{user}/unfollow',[FollowerController::class,'unfollow'])->middleware('auth')->name('user.unfollow');

require __DIR__.'/auth.php';
