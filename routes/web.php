<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'index'])->name('home');
Route::resource('categories', CategoryController::class);
Route::view('/aboutus', 'aboutus')->name('aboutus');
Route::view('/contact', 'contact')->name('contact');
Route::get('/jobs/create',[JobController::class,'create'])->middleware('auth');
Route::post('/jobs',[JobController::class,'store'])->middleware('auth');
Route::get('/jobs/{job}',[JobController::class,'show'])->name('jobs.job-detail');
Route::get('/brows-jobs',[JobController::class,'brows']);
// Route::get('/jobs/{job}',[JobController::class,'show']);



Route::get('/search',[SearchController::class,'search'])->name('search');
Route::get('/tags/{tag:name}',TagController::class);

Route::middleware('guest')->group(function(){
Route::get('/register',[RegisterUserController::class,'create']);
Route::post('/register',[RegisterUserController::class,'store']);
Route::get('/login',[SessionController::class,'create']);
Route::post('/login',[SessionController::class,'store']);
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/dashboard/update', [ProfileController::class, 'update'])->name('profile.update');
});
Route::delete('/logout',[SessionController::class,'destroy'])->middleware('auth');

