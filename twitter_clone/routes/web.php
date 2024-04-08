<?php

use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

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

// Route::get('/adminOnly', function () {
//     if(Gate::allows('visitAdminOnly')){
//         return view('adminOnly');
//     }
//     return redirect('/');}); //can use instead of if condition ->middleware('can:visitAdminOnly');

//user related routes
Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm']);
Route::post('/manage-avatar', [UserController::class, 'storeAvatar']);

//follow related routes
Route::post('/create-follow/{user:username}', [FollowController::class, 'createFollow']);
Route::post('/delete-follow/{user:username}', [FollowController::class, 'deleteFollow']);

//post related routes
Route::get('/create-post',[PostController::class, 'showCreateForm'])->middleware('auth');
Route::post('/create-post',[PostController::class, 'storeNewPost'])->middleware('auth');
Route::get('/post/{post}',[PostController::class, 'viewSinglePost']);//use {} to make it dynamic(the name refer to nothing)
Route::delete('/post/{post}', [PostController::class, 'delete']);
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm']);
Route::put('/post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');

//profile related routes
Route::get('/profile/{user:username}',[UserController::class, 'profile']);

