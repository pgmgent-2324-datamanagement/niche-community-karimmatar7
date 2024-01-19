<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Metadata\PostCondition;

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

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/posts/create', [PostController::class, 'create'])->name('welcome');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{id}/add-comment', [PostController::class, 'addComment'])->name('posts.addComment');
    Route::patch('/comments/{id}/update', [PostController::class, 'updateComment'])->name('posts.updateComment');
    Route::delete('/comments/{id}', [PostController::class, 'deleteComment'])->name('posts.deleteComment');
    Route::post('/user/{id}/follow', [PostController::class, 'follow'])->name('user.follow');
    Route::post('/user/{id}/unfollow', [PostController::class, 'unfollow'])->name('user.unfollow');
    Route::get('/user/{id}/followers', [PostController::class, 'followers'])->name('user.followers');
    Route::get('/user/{id}/followings', [PostController::class, 'followings'])->name('user.followings');
    Route::get('/posts/followings', [PostController::class, 'followingsPosts'])->name('posts.followings');
    Route::get('/game/{id}/posts', [PostController::class, 'gamePosts'])->name('posts.game');
    Route::post('/posts/{id}/toggle-like', [PostController::class, 'toggleLike'])->name('posts.toggleLike');

});

Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::get('/post/{id?}',[PostController::class, 'PostDetail'])->name('posts.detail');;
Route::get('/user/{id?}',[PostController::class, 'UserDetail']);

require __DIR__.'/auth.php';