<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Route for displaying the login form
Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');

// Route for handling login POST request
Route::post('/auth/login-basic', [LoginBasic::class, 'login'])->name('auth-login-basic.post');

// Route for logout
Route::post('/logout', [LoginBasic::class, 'logout'])->name('logout');

// Dashboard routes based on user type
Route::middleware('auth')->group(function () {
  Route::get('/admin/home', [AdminController::class, 'adminHome'])->name('admin.home');
  Route::get('/user/home', [UserController::class, 'userHome'])->name('user.home');
});

// Route for displaying the registration form
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

// Route for handling registration POST request
Route::post('/auth/register-basic', [RegisterBasic::class, 'register'])->name('auth-register-basic.post');

// Profile routes for admins and users
Route::middleware(['auth'])->group(function () {
  Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
  Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
  Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
  Route::put('/user/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

// Edit and update routes for users
Route::middleware(['auth'])->group(function () {
  Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
  Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
});

// Delete user route
Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Additional routes for editing and updating profiles
Route::middleware('auth')->group(function () {
  Route::get('/user/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
});

// Admin edit and update routes
Route::get('/admin/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');

// Named route for store method, if you need it separately
Route::get('users', [UserController::class, 'store'])->name('users.store');
Route::post('users', [UserController::class, 'store'])->name('users.store');

// Forgot Password routes
Route::get('auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('password.request');
Route::post('auth/forgot-password-basic', [ForgotPasswordBasic::class, 'sendResetLinkEmail'])->name('password.email');

// Check email route
Route::post('/check-email', [AuthController::class, 'checkEmail'])->name('check-email');

// Change Password routes
Route::middleware(['auth'])->group(function () {
  Route::get('/admin/change-password', [AdminController::class, 'showChangePasswordForm'])->name(
    'admin.ChangePassword'
  );
  Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.ChangePassword.post');

  Route::get('/user/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.ChangePassword');
  Route::post('/user/change-password', [UserController::class, 'changePassword'])->name('user.ChangePassword.post');
  Route::post('/user/verify-password', [UserController::class, 'verifyPassword'])->name('user.verifyPassword');
  Route::post('/verify-password', [UserController::class, 'verifyPassword'])->name('admin.verifyPassword');
});
