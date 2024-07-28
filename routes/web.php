<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {return view('homepage');})->name('home');
Route::get('/login', function () {return view('login');})->name('login');
Route::post('/login', [LoginController::class, 'final'])->name('login');

Route::get('/admindash', function () {return view('administrator/adminHome');})->name('adminDashboard');


Route::get('/register', function () {return view('register');})->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/register-details', function() {return view('register-details');})->name('register-details');
Route::post('/register-details', [RegisterController::class, 'registerDetails'])->name('register-details');


// Route::Get('/check', [FirebaseController::class, 'getValue']);
// Route::get('add-account', [FirebaseController::class, 'view'])->name('add-account');
// Route::post('add-account', [FirebaseController::class, 'testConnection']);
// Route::post('/authenticate', [FirebaseController::class, 'authenticate']);