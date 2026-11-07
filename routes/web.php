<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ConfectionController;
use Illuminate\Support\Facades\Route;
Route::get('/',[HomeController::class,'home'])->name('home');
Route::get('/database',[HomeController::class,'database'])->name('database');
Route::get('/graph',[HomeController::class,'graph'])->name('graph');
Route::get('/contact',[ContactController::class,'create'])->name('contact');
Route::post('/contact',[ContactController::class,'store'])->name('contact.store')->middleware('throttle:10,1');
Route::middleware('guest')->group(function(){
  Route::get('/login',[AuthController::class,'loginForm'])->name('login');
  Route::post('/login',[AuthController::class,'login'])->name('login.submit')->middleware('throttle:10,1');
  Route::get('/register',[AuthController::class,'registerForm'])->name('register');
  Route::post('/register',[AuthController::class,'register'])->name('register.submit')->middleware('throttle:10,1');
});
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');
Route::get('/messages',[ContactController::class,'index'])->middleware('auth')->name('messages');
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function(){
  Route::resource('confections',ConfectionController::class)->except(['show']);
});
