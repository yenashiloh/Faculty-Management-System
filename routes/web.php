<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FacultyController::class, 'showRolePage'])->name('role');

/********FACULTY********/
//Sign Up
Route::get('/faculty-sign-up', [FacultyController::class, 'showSignUpPage'])->name('faculty-sign-up');
Route::post('/faculty-sign-up', [FacultyController::class, 'signUpPost'])->name('faculty-sign-up.post');
Route::get('/faculty-login', [FacultyController::class, 'showLoginPage'])->name('faculty-login');
Route::post('/faculty-login', [FacultyController::class, 'loginPost'])->name('login.post');

Route::get('/otp-verification', [FacultyController::class, 'showOtpVerificationForm'])->name('otp-verification');
Route::post('/verify-otp', [FacultyController::class, 'verifyOtp'])->name('verify-otp');

//Records
Route::get('/faculty-records', [FacultyController::class, 'showRecordsPage'])->name('faculty.faculty-records');

//Trash
Route::get('/faculty-records', [FacultyController::class, 'showRecordsPage'])->name('faculty.faculty-records');
Route::get('/faculty-trash', [FacultyController::class, 'showTrashPage'])->name('faculty.faculty-trash');

//History
Route::get('/faculty-history', [FacultyController::class, 'showHistoryPage'])->name('faculty.faculty-history');

//Storage
Route::get('/faculty-storage', [FacultyController::class, 'showStoragePage'])->name('faculty.faculty-storage');

//Profile Details
Route::get('/faculty-profile', [FacultyController::class, 'showProfilePage'])->name('faculty.faculty-profile');

//Verification Email
Route::post('/resend-otp', [FacultyController::class, 'resendOtp'])->name('resend-otp');
Route::get('/verified', [FacultyController::class, 'showVerifiedCheck'])->name('verified');

/********ADMIN********/
//Login
Route::get('/admin-login', [AdminController::class, 'showLoginPage'])->name('admin-login');
Route::post('/admin-login', [AdminController::class, 'loginPost'])->name('admin-login.post');

//Home 
Route::get('/admin-home', [AdminController::class, 'showHomePage'])->name('admin.admin-home');

//Records
Route::get('/admin-records', [AdminController::class, 'showRecordPage'])->name('admin.admin-records');
Route::get('/admin-records/records_1', [AdminController::class, 'showRecordOnePage'])->name('admin.records.records_1');
Route::get('/test-administration/test-administration', [AdminController::class, 'showTestAdministrationPage'])->name('admin.test-administration.test-administration');
Route::get('/test-administration/bsit', [AdminController::class, 'showBsitPage'])->name('admin.test-administration.bsit');
Route::get('/users', [AdminController::class, 'showUsersPage'])->name('admin.users');
Route::get('/access-control', [AdminController::class, 'showAccessControlPage'])->name('admin.access-control');
Route::get('/trash', [AdminController::class, 'showTrashPage'])->name('admin.trash');
Route::get('/history', [AdminController::class, 'showHistoryPage'])->name('admin.history');
Route::get('/storage', [AdminController::class, 'showStoragePage'])->name('admin.storage');
Route::get('/admin-profile', [AdminController::class, 'showProfilePage'])->name('admin.admin-profile');


