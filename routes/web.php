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
use App\Http\Controllers\QuestionnaireController;

Route::get('/', function () {return view('homepage');})->name('home');
Route::get('/login', function () {return view('login');})->name('login');
Route::post('/login', [LoginController::class, 'final'])->name('logins');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admindash', [AdminController::class, 'viewDash'])->name('adminDashboard');
Route::post('/admindash', [AdminController::class, 'uploadvid'])->name('upload');

Route::get('/adminRequests', [AdminController::class, 'viewRequests'])->name('adminRequests');
Route::get('/adminRequests/{id}', [AdminController::class, 'viewRequestDetails'])->name('adminRequestsDetails');
Route::post('/adminRequests/{id}/approve', [QuestionnaireController::class, 'approve'])->name('approve');

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

Route::post('/doctorProfile/addQuestion', [QuestionnaireController::class , 'Addquestions'])->name('addQuestionnaire');
Route::post('/doctorProfile/editQuestion', [QuestionnaireController::class, 'editQuestions'])->name('editquestions');
Route::post('/doctorProfile/addCredential', [DoctorController::class, 'addcredentials'])->name('addcredentials');
Route::post('/doctorProfile/editDoctorDetails', [DoctorController::class, 'editDetails'])->name('editDetails');

Route::get('/doctor/patientAppointments', [DoctorController::class, 'showAppointments'])->name('showAppointments');
Route::post('/doctor/patientAction/{id}', [DoctorController::class, 'acceptPatient'])->name('patientAction');

Route::get('/doctor/patientlist', [DoctorController::class, 'viewPatients'])->name('viewPatients');
Route::get('/admin/patientList/patientDetails/{id}', [PatientController::class, 'viewPatientDetails'])->name('viewPatientDetails');
Route::get('/doctor/patientProfile/{id}', [PatientController::class, 'patientProfile'])->name('patientProfile');
Route::post('/doctor/patientProfile/{id}/report', [PatientController::class, 'reportPatient'])->name('reportPatient');
Route::get('admin/reportList', [AdminController::class, 'viewReports'])->name('viewReports');
Route::post('/sendmessage', [MessageController::class, 'sendMessage'])->name('sendmessage');
Route::post('/doctor/patientProfile/{id}/addNote', [PatientController::class, 'addNote'])->name('addnotes');
Route::post('/generate-token', [AccessTokenController::class, 'generateToken']);
Route::post('/dashboard/sampleData', [QuestionnaireController::class, 'sampleData'])->name('sampleData');
Route::get('/doctor/appointments', [DoctorController::class, 'viewAppointments'])->name('viewAppointments');
Route::post('/doctor/appointments/addAppointments', [DoctorController::class, 'addAppointments'])->name('addAppointments');