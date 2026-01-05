<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\SchoolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login'); 
Route::post('/' , [AuthController::class , 'post_login'])->name('post.login');
Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::get('/logout' , [AuthController::class , 'logout'])->name('logout');

Route::group(['middleware' => 'common'], function(){
    Route::get('cpanel/dashboard' , [DashboardController::class , 'dashboard'])->name('cpanel.dashboard');
    Route::get('cpanel/school' , [SchoolController::class , 'school_list'])->name('cpanel.school');
    Route::get('cpanel/school/add' , [SchoolController::class , 'create_school'])->name('cpanel.school.add');
    Route::post('cpanel/school/store' , [SchoolController::class , 'store'])->name('cpanel.school.store');

});
