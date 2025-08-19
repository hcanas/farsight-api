<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', \App\Http\Controllers\Auth\LoginController::class)->name('login');
    Route::post('register', \App\Http\Controllers\Auth\RegisterController::class)->name('register');
    Route::patch('reset-password', \App\Http\Controllers\Auth\ResetPasswordController::class)->name('reset-password');
});
