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


Route::middleware(['auth'])->group(function () {
    //Records
    Route::get('/faculty-records', [FacultyController::class, 'showRecordsPage'])->name('faculty.faculty-records');

    //Edit and Delete Records
    Route::post('/faculty-records/edit/{semestral_end:semestral_id}', [FacultyController::class, 'editRecordFolder'])->name('edit.folder');
    Route::post('/faculty-records/delete/{semestral_end:semestral_id}', [FacultyController::class, 'deleteRecordFolder'])->name('delete.folder');

    //Create a new folder in faculty-records page
    Route::post('/faculty/create-semestral-folder', [FacultyController::class, 'createYearSemestral'])->name('faculty.create-semestral-folder');
    
    //Semestral Add Folders 
    Route::post('/records/create-folder-semestral-ends', [AdminController::class, 'createFolderSemestralEnds'])->name('admin.records.create-folder-semestral-ends');

    //Trash
    Route::get('/faculty-records', [FacultyController::class, 'showRecordsPage'])->name('faculty.faculty-records');
    Route::get('/faculty-trash', [FacultyController::class, 'showTrashPage'])->name('faculty.faculty-trash');
    Route::get('/faculty-trash/restore/{id}', [FacultyController::class, 'restoreTrash'])->name('restore-trash');
    Route::get('/faculty-trash/delete/{id}', [FacultyController::class, 'deleteTrash'])->name('delete-trash');
    Route::get('/sort-trash/{sort}', [FacultyController::class, 'sortTrash'])->name('sort-trash');



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

Route::middleware(['auth:admin'])->group(function () {

    //Logout
    Route::post('/admin-logout', [AdminController::class, 'adminLogout'])->name('admin-logout');

    //Home 
    Route::get('/admin-home', [AdminController::class, 'showHomePage'])->name('admin.admin-home');

    //Records
    Route::get('/admin-records', [AdminController::class, 'showRecordPage'])->name('admin.admin-records');
    Route::get('/admin-records/records_1', [AdminController::class, 'showRecordOnePage'])->name('admin.records.records_1');
    Route::get('/records/folder-semestral-ends/{semestral_id}', [AdminController::class, 'openYearEndsFolder'])->name('folder-semestral-ends');

    //Edit and Delete Records
    Route::post('/admin-records/edit/{semestral_end:semestral_id}', [AdminController::class, 'editRecordFolder'])->name('edit.folder');
    Route::post('/admin-records/delete/{semestral_end:semestral_id}', [AdminController::class, 'deleteRecordFolder'])->name('delete.folder');

    //Semestral Folders Edit and Delete Records
    Route::post('/records/folder-semestral-ends/edit/{year_semestral_folders:year_semestral_folders_id}', [AdminController::class, 'editYearEndFolder'])->name('edit.folder');
    Route::post('/records/folder-semestral-ends/delete/{year_semestral_folders:year_semestral_folders_id}', [AdminController::class, 'deleteYearEndFolder'])->name('delete.folder');

    //Semestral Add Folders 
    Route::post('/records/create-folder-semestral-ends', [AdminController::class, 'createFolderSemestralEnds'])->name('admin.records.create-folder-semestral-ends');

    //Open folder with files
    Route::get('/records/records/{year_semestral_folders_id}', [AdminController::class, 'openFolders'])->name('admin.records.records');

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

    //Announcement
    Route::get('/announcement/admin-announcement', [AdminController::class, 'showAnnouncementPage'])->name('admin.announcement.admin-announcement');
    Route::get('/announcement/add-announcement', [AdminController::class, 'showAddAnnouncementPage'])->name('admin.announcement.add-announcement');
    Route::post('/announcement/add-announcement', [AdminController::class, 'saveAnnouncement'])->name('admin.announcement.save-announcement');
    // Display the edit form
    Route::get('admin/announcement/edit/{id_announcement}', [AdminController::class, 'editAnnouncement'])->name('admin.announcement.edit-announcement');
    // Update the announcement
    Route::post('admin/announcement/update/{id_announcement}', [AdminController::class, 'updateAnnouncement'])->name('admin.announcement.update-announcement');
    // Delete the announcement
    Route::delete('admin/announcement/delete/{id_announcement}', [AdminController::class, 'deleteAnnouncement'])->name('admin.announcement.delete-announcement');

    Route::get('admin/announcement/publish/{id_announcement}', [AdminController::class, 'publishAnnouncement'])->name('admin.announcement.publish-announcement');
    Route::get('admin/announcement/unpublish/{id_announcement}', [AdminController::class, 'unpublishAnnouncement'])->name('admin.announcement.unpublish-announcement');

    //Storage
    Route::get('/admin-storage', [AdminController::class, 'showStoragePage'])->name('admin.admin-storage');

    //Admin Profile
    Route::get('/admin-profile', [AdminController::class, 'showProfilePage'])->name('admin.admin-profile');

    Route::post('/create-semestral-folder', [AdminController::class, 'createYearSemestral'])->name('create-semestral-folder');
});



