<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\BereavementCaseController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeathReportController;
use App\Http\Controllers\Admin\DeathReportController as AdminDeathReportController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

// Redirect root to dashboard
Route::get('/', fn() => redirect()->route('dashboard'));

// =============================
// 🔐 Authentication Routes
// =============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =============================
// 🔒 Protected Routes (Requires Auth)
// =============================
Route::middleware('auth')->group(function () {

    // ==============================
    // 🏠 Dashboard
    // ==============================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/member/dashboard', [DashboardController::class, 'memberDashboard'])->name('member.dashboard');

    // ==============================
    // 👤 Profile
    // ==============================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ==============================
    // 💸 Donations
    // ==============================
    Route::resource('donations', DonationController::class)->except(['show']);

    // ==============================
    // 🔔 Notifications
    // ==============================
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])
        ->name('notifications.markAllRead');

    // ==============================
    // 👥 Members (Admin Only - Check inside Controller)
    // ==============================
    Route::resource('members', MemberController::class);

    // ==============================
    // ⚰️ Bereavement Cases (Admin Only)
    // ==============================
    Route::resource('bereavement-cases', BereavementCaseController::class);
    Route::put('bereavement-cases/{id}/remarks', [BereavementCaseController::class, 'updateRemarks'])
        ->name('bereavement-cases.updateRemarks');

    // ==============================
    // 🕊️ Death Reports (User Submission)
    // ==============================
    Route::get('/report-death', [DeathReportController::class, 'create'])->name('report.death');
    Route::post('/report-death', [DeathReportController::class, 'store'])->name('report.death.store');

    // ==============================
    // 🛡️ Admin - Manage Death Reports
    // ==============================
    Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/death-reports', [AdminDeathReportController::class, 'index'])->name('death-reports.index');
        Route::post('/death-reports/approve/{id}', [AdminDeathReportController::class, 'approve'])->name('death-reports.approve');
        Route::post('/death-reports/unverify/{id}', [AdminDeathReportController::class, 'unverify'])->name('death-reports.unverify');
    });

    // =============================
// 🔑 Password Reset Routes
// =============================

// Show "Forgot Password" form
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

// Send password reset link
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Show "Reset Password" form (from email link)
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// Handle new password submission
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

});
