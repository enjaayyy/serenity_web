<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {return view('homepage');})->name('home');
Route::get('/login', function () {return view('login');})->name('login');
Route::post('/login', [LoginController::class, 'final'])->name('login');

Route::get('/admindash', function () {return view('administrator/adminHome');})->name('adminDashboard');
Route::get('/adminRequests', [AdminController::class, 'viewRequests'])->name('adminRequests');
Route::get('/adminRequests/{id}', [AdminController::class, 'viewRequestDetails'])->name('adminRequestsDetails');
Route::post('/adminRequests/{id}/approve', [AdminController::class, 'approve'])->name('approve');

Route::get('/doctorList', function() {return view('administrator/doctors');})->name('doctorlists');

Route::get('/register', function () {return view('register');})->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/register-details', function() {return view('register-details');})->name('register-details');
Route::post('/register-details', [RegisterController::class, 'registerDetails'])->name('register-details');

