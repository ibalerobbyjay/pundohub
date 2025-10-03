<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\BereavementCaseController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

// Redirect root to dashboard
Route::get('/', fn() => redirect()->route('dashboard'));


// Authentication

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Protected Routes (auth required)

Route::middleware('auth')->group(function () {

    // Dashboard (different views handled inside controller by role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/member/dashboard', [DashboardController::class, 'memberDashboard'])->name('member.dashboard');

  
    // Profile
  
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

 
    // Donations
   
    Route::resource('donations', DonationController::class)->except(['show']);


// Notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])
    ->name('notifications.markAllRead'); 




  
    // Members (admin only check inside controller/middleware)
  
    Route::resource('members', MemberController::class);

   
    // Bereavement Cases (admin only check inside controller/middleware)
   
   Route::resource('bereavement-cases', BereavementCaseController::class);
   Route::middleware('auth')->group(function () {
    Route::put('bereavement-cases/{id}/remarks', [BereavementCaseController::class, 'updateRemarks'])
         ->name('bereavement-cases.updateRemarks');
});


});
