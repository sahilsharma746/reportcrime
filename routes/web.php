<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('complaints/create', [ComplaintController::class, 'create'])->name('home');

Route::get('test', function () {
    $user = \App\Models\User::first();
    $complaint = \App\Models\Complaint::first();
    $user->notify(new \App\Notifications\NewComplaintSubmitted($complaint));
});
// Public routes
Route::get('complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('complaints', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('complaints/{complaint}/thank-you', [ComplaintController::class, 'thankYou'])->name('complaints.thank-you');
Route::get('/complaints/search', [ComplaintController::class, 'searchForm'])->name('complaints.search');
Route::get('/complaints/results', [ComplaintController::class, 'search'])->name('complaints.results');

// Authentication routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::post('complaints/{complaint}/messages', [MessageController::class, 'store'])->name('messages.store');
});

// Admin and Subadmin routes
Route::middleware(['auth', 'role:admin,subadmin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/complaints', [AdminController::class, 'complaintsList'])->name('admin.complaints.index');
    Route::get('admin/complaints/{complaint}', [AdminController::class, 'showComplaint'])->name('admin.complaints.show');
    Route::post('admin/complaints/{complaint}/assign', [AdminController::class, 'assignComplaint'])->name('admin.complaints.assign');
    Route::patch('admin/complaints/{complaint}/status', [AdminController::class, 'updateStatus'])->name('admin.complaints.update-status');
    Route::post('admin/complaints/{complaint}/notes', [AdminController::class, 'addNote'])->name('admin.complaints.add-note');
    Route::post('admin/complaints/{complaint}/notes', [AdminController::class, 'addNote'])->name('complaints.add-note');
});
