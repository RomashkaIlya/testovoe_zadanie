<?php
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ControllerExample;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
// Добавьте это ↓
Route::post('register', [RegisterController::class, 'register'])
    ->middleware('restrictothers');
// Страница создания токена
Route::get('dashboard', function () {
    if(Auth::check() && Auth::user()->role === 1){
        return auth()
            ->user()
            ->createToken('auth_token', ['admin'])
            ->plainTextToken;
    }
    return redirect("/");
})->middleware('auth');

Route::get('clear/token', function () {
    if(Auth::check() && Auth::user()->role === 1) {
        Auth::user()->tokens()->delete();
        Auth::logout();
    }
    return 'Token Cleared';
})->middleware('auth');
Route::get('/posts',[PostsController::class,'posts'])->name('posts');//просмотр постов

Route::get('/posts/create',[PostsController::class,'create'])->name('posts.create');


