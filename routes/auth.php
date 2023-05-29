<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyTimeController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\TargetTimeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    //ダッシュボード表示
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 研究開始・終了時間の打刻処理
    Route::post('researches/start', [ResearchController::class, 'storeStartTime'])->name('research.storeStartTime');
    Route::post('researches/end', [ResearchController::class, 'storeEndTime'])->name('research.storeEndTime');

    // 休憩開始・終了時間の打刻処理
    Route::post('rests/start', [RestController::class, 'storeStartTime'])->name('rest.storeStartTime');
    Route::post('rests/end', [RestController::class, 'storeEndTime'])->name('rest.storeEndTime');

    // 今週の目標時間
    Route::post('target-time', [TargetTimeController::class, 'store'])->name('targetTime.store');
    Route::get('target-time/{targetTimeId}', [TargetTimeController::class, 'edit'])->name('targetTime.edit');
    Route::put('target-time/{targetTimeId}', [TargetTimeController::class, 'update'])->name('targetTime.update');

    // 月間の研究時間
    Route::get('monthly-time', [MonthlyTimeController::class, 'index'])->name('monthlyTime.index');
});
