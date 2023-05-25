<?php

namespace App\Http\Controllers;

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

// user 
Route::get('/register', function () { return view('register'); });
Route::get('/login', function () { return view('login'); })->name('login');
Route::get('/logout',  [UserController::class, 'logout']);
Route::post('/register', [UserController::class, 'create']);
Route::post('/login', [UserController::class, 'login']);

// article
Route::get('/', [ArticleController::class, 'index']);
Route::get('/create', [ArticleController::class, 'create'])->middleware('auth'); 
Route::get('/article/{id}', [ArticleController::class, 'show']);
Route::get('/edit/{id}', [ArticleController::class, 'edit'])->middleware('auth');
Route::get('/search', [ArticleController::class, 'search'])->name('search');
Route::post('/create', [ArticleController::class, 'store']); 
Route::patch('/update', [ArticleController::class, 'update']); 
Route::delete('/delete/{id}', [ArticleController::class, 'destroy']); 

// comment
Route::post('/comment/store', [CommentController::class, 'store']);
Route::patch('/comment/update', [CommentController::class, 'update']); 
Route::delete('/comment/delete/{id}', [CommentController::class, 'destroy']); 

// hashtag
Route::get('/hashtag', [HashtagController::class, 'index'])->middleware('auth');
Route::post('/hashtag/store', [HashtagController::class, 'store']); 