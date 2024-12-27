<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AgoraTokenController;


Route::get('/', function () {return view('homepage');})->name('home');
Route::get('/login', function () {return view('login');})->name('login');
Route::post('/login', [LoginController::class, 'final'])->name('logins');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/AdminDashboard', function () {return view('administrator.adminSidebar');})->name('adminSidebar');

Route::get('/admindash', [AdminController::class, 'viewDash'])->name('adminDashboard');
Route::post('/admindash', [AdminController::class, 'uploadvid'])->name('upload');

Route::get('/adminRequests', [AdminController::class, 'viewRequests'])->name('adminRequests');
Route::get('/adminRequests/{id}', [AdminController::class, 'viewRequestDetails'])->name('adminRequestsDetails');
Route::post('/adminRequests/{id}/approve', [AdminController::class, 'approve'])->name('approve');

Route::get('/adminDoctors', [AdminController::class, 'viewDocList'])->name('doctors');
Route::get('/doctorDetails/{id}', [AdminController::class, 'viewdoctor'])->name('viewdoctor');
Route::post('/doctorDetails/{id}/deactivate', [AdminController::class, 'deactivate'])->name('deactivate');

Route::get('/archive', [AdminController::class, 'viewArchive'])->name('archive');
Route::post('/archive/{id}/activate', [AdminController::class, 'activate'])->name('activate');

Route::get('/register', function () {return view('register');})->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/register-details', function() {return view('register-details');})->name('register-details');
Route::post('/register-details', [RegisterController::class, 'registerDetails'])->name('register-details');

Route::get('/patientlist', [AdminController::class, 'viewPatients'])->name('patients'); 

Route::get('/doctorDashboard', [DoctorController::class, 'docDashboard'])->name('docDashboard');
Route::get('/doctorProfile', [DoctorController::class, 'doctorProfile'])->name('docProfile');
Route::post('/doctorProfile/uploadpp', [DoctorController::class , 'uploadpp'])->name('uploadpp');
Route::post('/doctorProfile/uploadDetails', [DoctorController::class, 'getDetails'])->name('uploadDetails');
Route::post('/doctorProfile/editDetails', [DoctorController::class, 'editDetails'])->name('editDetails');
Route::post('/doctorProfile/updateQuestions', [DoctorController::class, 'updateQuestions'])->name('updateQuestions');
Route::post('/doctorProfile/defaultQuestion', [DoctorController::class, 'defaultQuestion'])->name('defaultQuestion');
Route::post('/doctorProfile/editQuestions', [DoctorController::class, 'editQuestions'])->name('editQuestions');
Route::post('/doctorProfile/newQuestion', [DoctorController::class, 'newTemplate'])->name('newTemplate');
Route::post('/doctorProfile/addGrad', [DoctorController::class, 'addGraduate'])->name('addGraduate');
Route::get('/doctor/requests', [DoctorController::class, 'showRequests'])->name('showRequests');
Route::post('/doctor/patientAction/{id}', [DoctorController::class, 'acceptPatient'])->name('patientAction');
Route::get('/doctor/patientlist', [DoctorController::class, 'viewPatients'])->name('viewPatients');
Route::get('/admin/patientList/patientDetails/{id}', [PatientController::class, 'viewPatientDetails'])->name('viewPatientDetails');
Route::get('/doctor/patientProfile/{id}', [PatientController::class, 'patientProfile'])->name('patientProfile');
Route::post('/sendmessage', [MessageController::class, 'sendMessage'])->name('sendmessage');

Route::post('/generate-token', [AccessTokenController::class, 'generateToken']);
