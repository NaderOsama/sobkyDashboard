<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\formsController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\packageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\subscriptionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\ClientFormController;
use App\Http\Controllers\Client\ClientHomeController;
use App\Http\Controllers\Client\Auth\ClientAuthController;

// Routes accessible to everyone
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Routes accessible only to authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/notifications/mark-as-viewed', [HomeController::class, 'markAsViewed'])->name('notifications.markAsViewed');
});

//Reports
Route::middleware('auth')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('report');

});


Route::middleware('auth')->group(function () {
    Route::get('/no-access', function () {
        return view('access.index');
    })->name('no-access');
});

//Packages
Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('/all-packages', [PackageController::class, 'allPackages'])->name('packages.allPackages');
        Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
        Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
        Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
        Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
    });

});

//Groups
Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
        Route::get('/all-groups', [GroupController::class, 'allGroups'])->name('groups.allGroups');
        Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
        Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
        Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');

        Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
    });
});


//Notes
Route::middleware('auth')->group(function () {
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
});


//Clients
Route::middleware('auth')->group(function () {
    Route::get('/clients', [clientController::class, 'index'])->name('clients.index');
    Route::get('/all-clients', [clientController::class, 'allClients'])->name('clients.allClients');
    Route::get('/clients/{client}/profile', [clientController::class, 'profile'])->name('clients.profile');
    Route::post('/clients', [clientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{client}/edit', [clientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{client}', [clientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [clientController::class, 'destroy'])->name('clients.destroy');
    Route::put('/clients/{client}/update-image',[clientController::class, 'updateProfileImage'])->name('clients.updateImage');
    Route::post('/clients/{client}/send-check-in', [clientController::class, 'sendCheckIn'])->name('clients.sendCheckIn');
    Route::post('/clients/{client}/send-check-in-answer', [clientController::class, 'sendCheckInAnswer'])->name('clients.sendCheckInAnswer');
});

//Accounts
Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/users/create-account', [RegisterController::class, 'createAccounts'])->name('accounts.index');
        Route::get('/users/all-users', [RegisterController::class, 'allUsers'])->name('accounts.users');
        Route::post('/users/create-account', [RegisterController::class, 'register'])->name('accounts.register');

        Route::get('/users/{user}/edit', [RegisterController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [RegisterController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [RegisterController::class, 'destroy'])->name('users.destroy');

    });
});


//Subscriptions
Route::middleware('auth')->group(function () {
    Route::get('/subscriptions', [subscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions', [subscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/{subscription}/edit', [subscriptionController::class, 'edit'])->name('subscriptions.edit');
    Route::put('/subscriptions/{subscription}', [subscriptionController::class, 'update'])->name('subscriptions.update');
    Route::delete('/subscriptions/{subscription}', [subscriptionController::class, 'destroy'])->name('subscriptions.destroy');
});


//Forms
Route::middleware('auth')->group(function () {
    Route::get('/forms/check-in', [formsController::class, 'checkIn'])->name('forms.checkIn');
    Route::post('/forms/check-in', [formsController::class, 'storeCheckIn'])->name('forms.storeCheckIn');

    Route::get('/forms/check-in-types', [formsController::class, 'checkInType'])->name('forms.checkInType');
    Route::post('/forms/check-in-types', [formsController::class, 'storeCheckInType'])->name('forms.storeCheckInType');

    Route::get('/forms/check-in-forms', [formsController::class, 'formQuestion'])->name('forms.formQuestion');
    Route::post('/forms/check-in-forms', [formsController::class, 'storeFormQuestion'])->name('forms.storeFormQuestion');
    Route::post('/forms/check-in-questions2', [formsController::class, 'storeQuestion2'])->name('forms.storeQuestion2');


    Route::get('/forms/check-in-questions', [formsController::class, 'question'])->name('forms.question');
    Route::post('/forms/check-in-questions', [formsController::class, 'storeQuestion'])->name('forms.storeQuestion');

    Route::get('/forms/{forms}/edit', [formsController::class, 'edit'])->name('forms.edit');
    Route::put('/forms/{forms}', [formsController::class, 'update'])->name('forms.update');
    Route::delete('/forms/{forms}', [formsController::class, 'destroy'])->name('forms.destroy');
});


//Alerts
Route::middleware('auth')->group(function () {
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');


});


// Client
// ---------------------------------------------------------------


Route::get('client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
Route::post('client/login', [ClientAuthController::class, 'login'])->name('client.login.submit');

Route::middleware(['auth:client'])->group(function () {
    Route::get('client/home', [ClientHomeController::class, 'index'])->name('client.index');
    Route::post('client/logout', [ClientAuthController::class, 'logout'])->name('client.logout');

});

Route::middleware(['auth:client'])->group(function () {
    Route::get('client/checkin', [ClientFormController::class, 'checkIns'])->name('client.checkIns');
    Route::get('client/check-in-forms/{check_in_id}/{client_check_in_id}', [ClientFormController::class, 'viewClientCheckinForm'])->name('client.viewClientCheckinForm');
    Route::post('/client/check-in/{client_check_in_id}/submit', [ClientFormController::class, 'submitClientAnswers'])
    ->name('client.submitClientAnswers');


    // old
    Route::get('client/old-checkin', [ClientFormController::class, 'oldCheckIns'])->name('client.oldCheckIns');
    Route::get('client/old-check-in-forms/{check_in_id}/{client_check_in_id}', [ClientFormController::class, 'viewOldClientCheckinForm'])->name('client.viewOldClientCheckinForm');

    Route::get('check-in/view/{check_in_id}/{client_check_in_id}', [ClientFormController::class, 'viewClientCheckinForm'])->name('checkIn.view');



});

