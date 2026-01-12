<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SchoolController;
use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login'); 
Route::post('/' , [AuthController::class , 'post_login'])->name('post.login');
Route::get('/logout' , [AuthController::class , 'logout'])->name('logout');

// forgot password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');

Route::group(['middleware' => 'common'], function(){
    Route::get('cpanel/dashboard' , [DashboardController::class , 'dashboard'])->name('cpanel.dashboard');

    // School
    Route::get('cpanel/school' , [SchoolController::class , 'school_list'])->name('cpanel.school');
    Route::get('cpanel/school/add' , [SchoolController::class , 'create_school'])->name('cpanel.school.add');
    Route::post('cpanel/school/store' , [SchoolController::class , 'store'])->name('cpanel.school.store');
    Route::get('/cpanel/school/{user:slug}/edit', [SchoolController::class, 'edit'])->name('cpanel.school.edit');
    Route::put('/school/{slug}', [SchoolController::class, 'update'])->name('cpanel.school.update');
    Route::get('/school/{id}/toggle-status',[SchoolController::class, 'toggleStatus'])->name('cpanel.school.toggleStatus');
    Route::delete('/school/{school:slug}', [SchoolController::class, 'destroy'])->name('cpanel.school.delete');

    // Admin
    Route::get('cpanel/admin' , [AdminController::class , 'admin_list'])->name('cpanel.admin');

    // 404 cho admin
    Route::fallback(function () {
        return response()
            ->view('errors.404', [], 404);
    });
});
