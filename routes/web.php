<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;



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

Route::get('/posts',[PostController::class ,'index'])  -> name ('posts.index') ;

Route::get('/posts/create',[PostController::class,'create'] )->name('posts.create');

Route::post('/posts',[PostController::class,'store']   )->name('posts.store');

Route::get('/posts/{id}',[PostController::class,'show'] )-> name ('posts.show') ;
Route::post('/posts/{postId}/like', [LikeController::class, 'like'])->name('posts.like');
Route::post('/posts/{postId}/unlike', [LikeController::class, 'unlike'])->name('posts.unlike');



Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
->name('posts.edit');

Route::put('/posts/{id}', [PostController::class, 'update'])
->name('posts.update');

Route::delete('/posts/{id}', [PostController::class, 'destroy'])
->name('posts.destroy');



require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// comments route
Route::post('/posts/{id}/comments',[CommentController::class,('store')]) ->name('comment.store');
Route::delete('/posts/{id}/comments', [CommentController::class, 'destroy'])->name('comment.destroy');