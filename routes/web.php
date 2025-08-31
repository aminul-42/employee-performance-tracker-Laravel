<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\WorkLogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Public Routes
Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Protected Admin routes
Route::prefix('admin')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Employee Details
Route::resource('employees', EmployeeController::class)->names([
    'index' => 'admin.employees.index',
    'create' => 'admin.employees.create',
    'store' => 'admin.employees.store',
    'show' => 'admin.employees.show',
    'edit' => 'admin.employees.edit',
    'update' => 'admin.employees.update',
    'destroy' => 'admin.employees.destroy',]);


    // Attendance Routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('admin.attendance.store');
    Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('admin.attendance.export');

    // Work Log Routes
    Route::get('/work-logs', [WorkLogController::class, 'index'])->name('admin.work_logs.index');
    Route::post('/work-logs', [WorkLogController::class, 'store'])->name('admin.work_logs.store');

});






