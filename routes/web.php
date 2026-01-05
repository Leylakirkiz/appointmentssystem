<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TeacherAuthController;
use App\Http\Controllers\FacultyController;

// --- GENERAL ROUTES ---
Route::get('/', function () { return view('welcome'); });
Route::get('/neu', function () { return view('neu'); });

// --- STUDENT AUTHENTICATION ROUTES ---
Route::get('/login', [RegisterController::class, 'loginview'])->name('login');
Route::post('/login', [RegisterController::class, 'login'])->name('login.submit');
Route::get('/register', [RegisterController::class, 'registerview'])->name('registerview');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// --- TEACHER AUTHENTICATION ROUTES ---
Route::get('/loginth', [TeacherAuthController::class, 'loginviewth'])->name('loginviewth'); 
Route::post('/loginth', [TeacherAuthController::class, 'loginth'])->name('loginth');
Route::get('/registerth', [TeacherAuthController::class, 'registerviewth'])->name('registerviewth');
Route::post('/registerth', [TeacherAuthController::class, 'registerth'])->name('registerth');

// --- STUDENT PANEL (Authenticated Students Only) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () { return view('home'); })->name('home');
    Route::get('/informations', [RegisterController::class, 'profile'])->name('informations');   
    Route::put('/student/profile/update', [RegisterController::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/reservations', [FacultyController::class, 'reservations'])->name('reservations');
    Route::get('/student/notifications', [FacultyController::class, 'notifications'])->name('student.notifications');
    
    // Faculty and Teacher Listings
    Route::get('/createreservations', [FacultyController::class, 'index'])->name('createreservations');
    Route::get('/faculty/{id}/teachers', [FacultyController::class, 'showTeachers'])->name('faculty.teachers');
    Route::get('/faculty/reserve/{id}', [FacultyController::class, 'reserve'])->name('faculty-reserve-detail');
    
    // Appointment Operations
    Route::post('/appointment/request', [FacultyController::class, 'storeAppointment'])->name('appointment.request');
    Route::post('/appointment/{id}/cancel', [FacultyController::class, 'cancelAppointment'])->name('appointment.cancel');

    Route::post('/logout', [RegisterController::class, 'logout'])->name('student.logout');
});

// --- TEACHER PANEL (Authenticated Teachers Only) ---
Route::middleware(['auth:teacher'])->group(function () {
    Route::get('/hometh', [TeacherAuthController::class, 'dashboard'])->name('hometh');

    // Appointment Management (Approve/Reject/Complete)
    Route::get('/teacher/notifications', [TeacherAuthController::class, 'notifications'])->name('teacher.notifications');
    Route::post('/teacher/appointment/{id}/handle', [TeacherAuthController::class, 'handleAppointment'])->name('teacher.appointment.handle');
    // Route::post('/complete-appointment/{id}', [TeacherAuthController::class, 'completeAppointment'])->name('appointment.complete');

    // Schedule Management
    Route::get('/teacher/my-schedule', [TeacherAuthController::class, 'showScheduleOnly'])->name('teacher.schedule');
    Route::post('/teacher/update-schedule-bulk', [TeacherAuthController::class, 'updateScheduleBulk'])->name('teacher.update.schedule.bulk');
    Route::post('/teacher/update-schedule', [TeacherAuthController::class, 'updateSchedule'])->name('teacher.update.schedule');

    // Profile Settings
    Route::get('/teacher/profile-settings', [TeacherAuthController::class, 'showProfileSettings'])->name('teacher.profile.edit');
    Route::post('/teacher/profile-update', [TeacherAuthController::class, 'updateProfile'])->name('teacher.profile.update');

    // Teacher Logout & Reservations List
    Route::post('/teacher/logout', [TeacherAuthController::class, 'logoutTeacher'])->name('teacher.logout');
    Route::get('/teacher/reservations-list', [TeacherAuthController::class, 'showReservations'])->name('teacher.reservations.list');
});