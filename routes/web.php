<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FacultyController::class, 'showRolePage'])->name('role');

/***************************************FACULTY*******************************************/

//Sign Up
Route::get('/faculty-sign-up', [FacultyController::class, 'showSignUpPage'])
    ->name('faculty-sign-up')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::post('/faculty-sign-up', [FacultyController::class, 'signUpPost'])->name('faculty-sign-up.post');

//Login
Route::get('/faculty-login', [FacultyController::class, 'showLoginPage'])
    ->name('faculty-login')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::post('/faculty-login', [FacultyController::class, 'loginPost'])->name('login.post');

//Verification OTP
Route::get('/otp-verification', [FacultyController::class, 'showOtpVerificationForm'])
    ->name('otp-verification')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::post('/verify-otp', [FacultyController::class, 'verifyOtp'])->name('verify-otp');


Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
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
    Route::post('/faculty-profile', [FacultyController::class, 'updateProfile'])->name('faculty.profile-update');

    //Verification Email
    Route::post('/resend-otp', [FacultyController::class, 'resendOtp'])->name('resend-otp');
    Route::get('/verified', [FacultyController::class, 'showVerifiedCheck'])->name('verified');

    //Logout
    Route::post('/logout', [FacultyController::class, 'facultyLogout'])->name('logout');
});


/*****************************************ADMIN****************************************/
//Login
Route::get('/admin-login', [AdminController::class, 'showLoginPage'])
    ->name('admin-login')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);

Route::post('/admin-login', [AdminController::class, 'loginPost'])
    ->name('admin-login.post')
    ->middleware(\App\Http\Middleware\PreventBackHistory::class);

    Route::middleware(['admin', \App\Http\Middleware\PreventBackHistory::class])->group(function () {

    //Logout
    Route::post('/admin-logout', [AdminController::class, 'adminLogout'])->name('admin-logout');

    //Home 
    Route::get('/admin-home', [AdminController::class, 'showHomePage'])->name('admin.admin-home');

    //Records
    Route::get('/admin-records', [AdminController::class, 'showRecordPage'])->name('admin.admin-records');
    Route::get('/admin-records/records_1', [AdminController::class, 'showRecordOnePage'])->name('admin.records.records_1');

    //Edit and Delete Records
    Route::post('/admin-records/edit/{semestral_end:semestral_id}', [AdminController::class, 'editRecordFolder'])->name('edit.folder');
    Route::post('/admin-records/delete/{semestral_end:semestral_id}', [AdminController::class, 'deleteRecordFolder'])->name('delete.folder');

    //Test Admistration
    Route::get('/test-administration/test-administration', [AdminController::class, 'showTestAdministrationPage'])->name('admin.test-administration.test-administration');
    Route::get('/test-administration/bsit', [AdminController::class, 'showBsitPage'])->name('admin.test-administration.bsit');

    //Users
    Route::get('/users', [AdminController::class, 'showUsersPage'])->name('admin.users');

    //Access Control
    Route::get('/access-control', [AdminController::class, 'showAccessControlPage'])->name('admin.access-control');

    //Trash
    Route::get('/trash', [AdminController::class, 'showTrashPage'])->name('admin.trash');

    //History
    Route::get('/history', [AdminController::class, 'showHistoryPage'])->name('admin.history');

     //History
     Route::get('/maintenance-module', [AdminController::class, 'showMaintenanceModulePage'])->name('admin.maintenance-module');

    //Storage
    Route::get('/storage', [AdminController::class, 'showStoragePage'])->name('admin.storage');

    //Admin Profile
    Route::get('/admin-profile', [AdminController::class, 'showProfilePage'])->name('admin.admin-profile');

    Route::post('/create-semestral-folder', [AdminController::class, 'createYearSemestral'])->name('create-semestral-folder');
});



