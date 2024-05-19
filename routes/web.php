<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\AffliateController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Livewire\Admin\StudentsTable;
use App\Http\Livewire\Admin\PreceptorsTable;
use App\Http\Livewire\Admin\ApplicationsTable;
use App\Http\Livewire\Admin\RotationsTable;
use App\Http\Livewire\Admin\PaymentsTable;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RotationsController;
use App\Http\Controllers\MessagesController;

use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\AdminUsersController;

use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\CareersController;
use App\Http\Controllers\StudentTypePerCareersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OAuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/redirect/{provider?}', [OAuthController::class, 'auth'])->name('auth');
Route::get('/auth/callback/{provider?}', [OAuthController::class, 'callback']);


Route::get('/',[HomeController::class, 'home'])->name('home');
Route::get('/search',[HomeController::class, 'search'])->name('search');
Route::post('/search',[HomeController::class, 'search'])->name('searchpost');
Route::get('/view/{rotation}/{finished?}',[HomeController::class, 'viewRotation'])->name('view-rotation');

Route::get('/autocomplete/cities', [AutocompleteController::class, 'cities'])->name('cities-autocomplete');
Route::get('/autocomplete/schools', [AutocompleteController::class, 'schools'])->name('schools-autocomplete');
Route::get('/student-type-career/{id}', [ProfileController::class,'getStudentsTypes'])->name('student-type-career');

require __DIR__ . '/auth.php';

Route::middleware(['verified', 'middleware' => 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect(match(Auth::user()->role) {
            default => '/student/applications',
            'unknown' => '/complete-registration',
            'admin' => '/admin/students',
            'preceptor' => '/preceptor/rotations',
            'affiliate' => '/profile',
        });

        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/complete-registration', [OAuthController::class, 'completeRegistration']);
    Route::post('/finish-registration', [OAuthController::class, 'finishRegistration'])->name('finish-registration');

    Route::middleware(['role:affiliate'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/students', StudentsTable::class)->name('admin-students');
        Route::get('/admin/preceptors', PreceptorsTable::class)->name('admin-preceptors');
        Route::get('/admin/applications', ApplicationsTable::class)->name('admin-applications');
        Route::get('/admin/rotations', RotationsTable::class)->name('admin-rotations');
        Route::get('/admin/payments', PaymentsTable::class)->name('admin-payments');

        Route::get('/admin/user/edit/{user}', [AdminUsersController::class, 'edit'])->name('admin-user-edit');
        Route::post('/admin/user/update/bio', [AdminUsersController::class, 'updateBio'])->name('admin-user-update-bio');
        Route::post('/admin/user/update/professional', [AdminUsersController::class, 'updateProfessional'])->name('admin-user-update-professional');
        Route::post('/admin/user/update/photo', [AdminUsersController::class, 'updatePhoto'])->name('admin-user-update-photo');
        Route::post('/admin/user/update/password', [AdminUsersController::class, 'updatePassword'])->name('admin-user-update-password');

        Route::get('/admin/autocomplete/students', [AutocompleteController::class, 'students'])->name('admin-students-autocomplete');
        Route::get('/admin/autocomplete/preceptors', [AutocompleteController::class, 'preceptors'])->name('admin-preceptors-autocomplete');
        Route::get('/admin/autocomplete/rotations', [AutocompleteController::class, 'rotations'])->name('admin-rotations-autocomplete');

        Route::get('/admin/rotation/view/{rotation?}',[RotationsController::class, 'view'])->name('admin-rotation-view');
        Route::get('/admin/application/view/{application?}',[ApplicationsController::class, 'adminViewApplication'])->name('admin-application-view');
        Route::get('/admin/careers/', [CareersController::class, 'adminViewCareer'])->name('admin-careers');
        Route::get('/admin/students/', [StudentTypePerCareersController::class, 'adminViewStudents'])->name('admin-students');
        Route::post('/admin/update-career/', [CareersController::class, 'adminUpdateCareer'])->name('admin-update-career');
        Route::post('/admin/add-career/', [CareersController::class, 'adminAddCareer'])->name('admin-add-career');
        Route::get('/admin/remove-career/{id}', [CareersController::class, 'adminRemoveCareer'])->name('admin-remove-career');
        Route::post('/admin/update-student/', [StudentTypePerCareersController::class, 'adminUpdateStudent'])->name('admin-update-student');
        Route::post('/admin/add-student/', [StudentTypePerCareersController::class, 'adminAddStudent'])->name('admin-add-student');
        Route::get('/admin/remove-student/{id}', [StudentTypePerCareersController::class, 'adminRemoveStudent'])->name('admin-remove-student');
    });

    Route::middleware(['role:preceptor'])->group(function () {
        Route::get('/preceptor/rotations', [RotationsController::class,'rotations'])->name('preceptor-rotations');
        Route::get('/preceptor/rotation/{rotation?}',[RotationsController::class, 'edit'])->name('preceptor-rotation-edit');
        Route::post('/preceptor/rotation/update',[RotationsController::class, 'update'])->name('preceptor-rotation-update');
        Route::get('/preceptor/rotation/status/{rotation}/{status}', [RotationsController::class,'changeStatus'])->name('preceptor-rotation-change-status');
        Route::post('/preceptor/rotation/add-document',[RotationsController::class, 'addRotationDocument'])->name('preceptor-rotation-add-document');

        Route::get('/preceptor/rotation/calendar/{rotation}', [RotationsController::class,'calendar'])->name('preceptor-rotation-calendar');
        Route::post('/preceptor/rotation/calendar/update',[RotationsController::class, 'updateCalendar'])->name('preceptor-rotation-calendar-update');

        Route::get('/preceptor/rotation/view/{rotation?}',[RotationsController::class, 'view'])->name('preceptor-rotation-view');
        Route::get('/preceptor/application/view/{application?}',[ApplicationsController::class, 'preceptorViewApplication'])->name('preceptor-application-view');
        Route::get('/preceptor/application/accept/{application?}',[ApplicationsController::class, 'preceptorAcceptApplication'])->name('preceptor-application-accept');
        Route::get('/preceptor/application/reject/{application?}',[ApplicationsController::class, 'preceptorRejectApplication'])->name('preceptor-application-reject');

        Route::get('/preceptor/download/{file?}',[ApplicationsController::class, 'downloadFile'])->name('preceptor-file-download');
    });

    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/applications', [ApplicationsController::class, 'viewApplications'])->name('student-applications');
        Route::post('/rotation/apply',[HomeController::class, 'applyForRotation'])->name('student-rotation-apply');
        Route::get('/student/application/{application}', [ApplicationsController::class, 'viewApplication'])->name('student-application-view');
        Route::post('/student/application/withdraw', [ApplicationsController::class, 'withdraw'])->name('student-application-withdraw');
        Route::get('/student/application/pay/{application}', [ApplicationsController::class, 'pay'])->name('student-application-pay');
        Route::get('/student/application/payment/{payment}', [ApplicationsController::class, 'paymentSuccess'])->name('student-application-payment-success');
        Route::get('/student/application/payment/failed/{payment}', [ApplicationsController::class, 'paymentFailed'])->name('student-application-payment-failed');
    });

    Route::get('/messages', [MessagesController::class,'messages'])->name('messages');
    Route::post('/message/send', [MessagesController::class, 'sendMessage'])->name('message-send');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update/bio', [ProfileController::class, 'updateBio'])->name('profile-update-bio');
    Route::post('/profile/update/photo', [ProfileController::class, 'updatePhoto'])->name('profile-update-photo');
    Route::post('/profile/update/professional', [ProfileController::class, 'updateProfessional'])->name('profile-update-professional');
    Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('profile-update-password');
    Route::get('/profile/ref/{id}', [ProfileController::class,'prefinary']);
    Route::get('public-profile/{id}', [ProfileController::class, 'publicProfile']);
    Route::get('delete-file/{file?}', [ProfileController::class, 'removeFile'])->name('delete-file');
    Route::get('/documents', [FileController::class,'documents'])->name('documents');
    Route::post('/documents/save', [FileController::class,'store'])->name('documents-save');

/// AFFLIATE ROUTES
    Route::get('/connect/account', [AffliateController::class,'connect'])->name('connect-account');
    Route::post('/connect/account/create', [AffliateController::class,'store'])->name('connect-account-create');
});
