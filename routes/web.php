<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/registerview', [RegisterController::class, 'registerview'])->name('registerview');

Route::post('/login', [RegisterController::class, 'login'])->name('login');
Route::get('/loginview', [RegisterController::class, 'loginview'])->name('loginview');

Route::get('/home',function(){
 return view('home');})->name('home');

