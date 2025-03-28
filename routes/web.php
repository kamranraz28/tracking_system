<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SrController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;


Route::get('', function () {
    return view('login');
})->name('login');

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/performance-test', function () {
    // Simulate some processing
    sleep(2); // Sleep for 2 seconds
    return 'Performance test completed!';
});



Route::post('/user-login', [LoginController::class, 'userLogin'])->name('userLogin');
Route::get('/reset-password', [LoginController::class, 'resetPassord'])->name('resetPassord');
Route::post('/send-otp', [LoginController::class, 'sendOTP'])->name('sendOTP');


Route::middleware(['auth', 'preventBackAfterLogout'])->group(function () {
    // Protected routes
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');

    //Bulk Upload
    Route::get('/bulk-upload', [AdminController::class, 'bulkUpload'])->name('admin.bulkUpload');
    Route::post('/csv-upload', [AdminController::class, 'csvUpload'])->name('admin.csvUpload');

    //Report
    Route::get('/srs', [AdminController::class, 'srView'])->name('admin.srs');
    Route::get('/local-dealers', [AdminController::class, 'dealerView'])->name('admin.lds');
    Route::get('/retails', [AdminController::class, 'retailView'])->name('admin.retails');
    Route::get('/tsm', [AdminController::class, 'tsmView'])->name('admin.tsm');
    Route::get('/asm', [AdminController::class, 'asmView'])->name('admin.asm');
    Route::get('/rsm', [AdminController::class, 'rsmView'])->name('admin.rsm');

    //Schedule Start
    Route::get('/schedules', [ScheduleController::class, 'schedules'])->name('schedules');
    Route::post('/schedule-search', [ScheduleController::class, 'scheduleSearch'])->name('scheduleSearch');
    Route::get('/schedule-create', [ScheduleController::class, 'scheduleCreate'])->name('scheduleCreate');
    Route::post('/schedule-store', [ScheduleController::class, 'scheduleStore'])->name('scheduleStore');
    Route::get('/schedule-edit/{id?}', [ScheduleController::class, 'scheduleEdit'])->name('scheduleEdit');
    Route::post('/schedule-update/{id?}', [ScheduleController::class, 'scheduleUpdate'])->name('scheduleUpdate');
    Route::post('/schedule-destroy/{id?}', [ScheduleController::class, 'scheduleDelete'])->name('scheduleDelete');
    Route::get('/map-view/retail/{id?}', [ScheduleController::class, 'mapView'])->name('retail.mapView');

    //Schedule End

    //Sr Track Start
    Route::get('/track-field-force', [SrController::class, 'trackSr'])->name('admin.trackSr');
    Route::post('/track-sr-store', [SrController::class, 'trackSrStore'])->name('admin.trackSrStore');
    Route::post('/track-sr-map-view', [SrController::class, 'trackSrMap'])->name('admin.trackSrMap');
    Route::get('/field-force-attendance', [SrController::class, 'fieldForceAttendance'])->name('admin.fieldForceAttendance');
    Route::post('/field-force-attendance-store', [SrController::class, 'fieldForceAttendanceStore'])->name('fieldForceAttendanceStore');
    Route::get('/attendance-location/{id?}', [SrController::class, 'attendanceLocation'])->name('attendance.mapView');

    Route::get('/attendance-monitoring', [SrController::class, 'attendanceMonitoring'])->name('attendanceMonitoring');
    Route::post('/attendance-monitoring-filter', [SrController::class, 'monitoringSearch'])->name('monitoringSearch');



// For assigning roles to users
Route::post('/assign-role', [RoleController::class, 'assignRole'])->name('assign.role');
Route::post('/store-user', [UserController::class, 'store'])->name('store.user');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/user-create', [UserController::class, 'create'])->name('users.create');
Route::get('/user-edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/user-destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('/user-update/{id}', [UserController::class, 'update'])->name('users.update');

Route::get('/user-logout', [LoginController::class, 'userLogout'])->name('userLogout');
Route::get('/user-profile', [UserController::class, 'viewProfile'])->name('viewProfie');
Route::post('updateProfile', [UserController::class, 'updateProfile'])->name('updateProfile');

Route::get('/clear-all', [UserController::class, 'clearAll'])->name('clearAll');

Route::resource('permissions', PermissionController::class);

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles-create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles-store', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles-edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
Route::get('/roles-destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::put('/roles-update/{id}', [RoleController::class, 'update'])->name('roles.update');

Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('/permissions-create', [PermissionController::class, 'create'])->name('permissions.create');
Route::post('/permissions-store', [PermissionController::class, 'store'])->name('permissions.store');
Route::get('/permissions-edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::post('/permissions-destroy/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
Route::put('/permissions-update/{id}', [PermissionController::class, 'update'])->name('permissions.update');

Route::get('/logo-view', [UserController::class, 'logoChangeView'])->name('logoChangeView');
Route::post('/logo-update', [UserController::class, 'logoUpdate'])->name('updateLogo');
Route::get('/color-view', [UserController::class, 'colorChangeView'])->name('colorChangeView');
Route::post('/color-update', [UserController::class, 'updateColors'])->name('updateColors');



});
