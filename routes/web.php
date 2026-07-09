<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Coordinator\AdminController as CoordinatorAdminController;
use App\Http\Controllers\Coordinator\InternshipController as CoordinatorInternshipController;
use App\Http\Controllers\Coordinator\ReportController as CoordinatorReportController;
use App\Http\Controllers\Coordinator\StudentController as CoordinatorStudentController;
use App\Http\Controllers\Coordinator\SupervisorController as CoordinatorSupervisorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\ActivityLogController as StudentActivityLogController;
use App\Http\Controllers\Student\DocumentController as StudentDocumentController;
use App\Http\Controllers\Student\InternshipController as StudentInternshipController;
use App\Http\Controllers\Student\ReportController as StudentReportController;
use App\Http\Controllers\Supervisor\ActivityLogController as SupervisorActivityLogController;
use App\Http\Controllers\Supervisor\EvaluationController as SupervisorEvaluationController;
use App\Http\Controllers\Supervisor\StudentController as SupervisorStudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// 'nocache' stops the browser from serving a cached copy of any authenticated
// page (e.g. via the back button after logging out) instead of re-checking
// the session with the server.
Route::middleware(['auth', 'nocache'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ---------------- Student module ----------------
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/internship/create', [StudentInternshipController::class, 'create'])->name('internship.create');
        Route::post('/internship', [StudentInternshipController::class, 'store'])->name('internship.store');
        Route::put('/internship/{internship}', [StudentInternshipController::class, 'update'])->name('internship.update');

        Route::get('/logs', [StudentActivityLogController::class, 'index'])->name('logs.index');
        Route::get('/logs/create', [StudentActivityLogController::class, 'create'])->name('logs.create');
        Route::post('/logs', [StudentActivityLogController::class, 'store'])->name('logs.store');
        Route::get('/logs/{log}', [StudentActivityLogController::class, 'show'])->name('logs.show');
        Route::get('/logs/{log}/edit', [StudentActivityLogController::class, 'edit'])->name('logs.edit');
        Route::put('/logs/{log}', [StudentActivityLogController::class, 'update'])->name('logs.update');
        Route::delete('/logs/{log}', [StudentActivityLogController::class, 'destroy'])->name('logs.destroy');

        Route::get('/documents', [StudentDocumentController::class, 'index'])->name('documents.index');
        Route::post('/documents', [StudentDocumentController::class, 'store'])->name('documents.store');
        Route::delete('/documents/{document}', [StudentDocumentController::class, 'destroy'])->name('documents.destroy');

        Route::get('/report', [StudentReportController::class, 'index'])->name('report.index');
    });

    // ---------------- Supervisor module ----------------
    Route::middleware('role:supervisor')->prefix('supervisor')->name('supervisor.')->group(function () {
        Route::get('/students', [SupervisorStudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [SupervisorStudentController::class, 'show'])->name('students.show');

        Route::get('/logs', [SupervisorActivityLogController::class, 'index'])->name('logs.index');
        Route::get('/logs/{log}', [SupervisorActivityLogController::class, 'show'])->name('logs.show');
        Route::post('/logs/{log}/feedback', [SupervisorActivityLogController::class, 'storeFeedback'])->name('logs.feedback');

        Route::get('/evaluations', [SupervisorEvaluationController::class, 'index'])->name('evaluations.index');
        Route::get('/internships/{internship}/evaluate', [SupervisorEvaluationController::class, 'create'])->name('evaluations.create');
        Route::post('/internships/{internship}/evaluate', [SupervisorEvaluationController::class, 'store'])->name('evaluations.store');
    });

    // ---------------- Coordinator module ----------------
    Route::middleware('role:coordinator')->prefix('coordinator')->name('coordinator.')->group(function () {
        Route::get('/students', [CoordinatorStudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [CoordinatorStudentController::class, 'create'])->name('students.create');
        Route::post('/students', [CoordinatorStudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}/edit', [CoordinatorStudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [CoordinatorStudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [CoordinatorStudentController::class, 'destroy'])->name('students.destroy');

        Route::get('/supervisors', [CoordinatorSupervisorController::class, 'index'])->name('supervisors.index');
        Route::get('/supervisors/create', [CoordinatorSupervisorController::class, 'create'])->name('supervisors.create');
        Route::post('/supervisors', [CoordinatorSupervisorController::class, 'store'])->name('supervisors.store');
        Route::get('/supervisors/{supervisor}/edit', [CoordinatorSupervisorController::class, 'edit'])->name('supervisors.edit');
        Route::put('/supervisors/{supervisor}', [CoordinatorSupervisorController::class, 'update'])->name('supervisors.update');
        Route::delete('/supervisors/{supervisor}', [CoordinatorSupervisorController::class, 'destroy'])->name('supervisors.destroy');

        Route::get('/internships', [CoordinatorInternshipController::class, 'index'])->name('internships.index');
        Route::get('/internships/{internship}', [CoordinatorInternshipController::class, 'show'])->name('internships.show');
        Route::put('/internships/{internship}', [CoordinatorInternshipController::class, 'update'])->name('internships.update');

        Route::get('/reports', [CoordinatorReportController::class, 'index'])->name('reports.index');

        Route::get('/admins', [CoordinatorAdminController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [CoordinatorAdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [CoordinatorAdminController::class, 'store'])->name('admins.store');
        Route::get('/admins/{admin}/edit', [CoordinatorAdminController::class, 'edit'])->name('admins.edit');
        Route::put('/admins/{admin}', [CoordinatorAdminController::class, 'update'])->name('admins.update');
        Route::delete('/admins/{admin}', [CoordinatorAdminController::class, 'destroy'])->name('admins.destroy');
    });
});
