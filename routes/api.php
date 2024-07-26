<?php

use App\Http\Controllers\API\CompanyManagementController;
use App\Http\Controllers\API\QuoteBidsController;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\QuoteRequestController;
use App\Http\Controllers\API\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth/user'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/homepage-register', [AuthController::class, 'homepage_register'])->name('homepage_register');
    Route::post('/premium-register', [AuthController::class, 'premium_register'])->name('premium_register');
    Route::post('/premium-billing-info', [AuthController::class, 'premium_billing_info'])->middleware('auth:api')->name('premium_billing_info');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::get('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
    Route::post('/updateProfile', [AuthController::class, 'updateProfile'])->middleware('auth:api')->name('updateProfile');
    Route::post('/updatePassword', [AuthController::class, 'updatePassword'])->middleware('auth:api')->name('updatePassword');
});

Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'api'
], function ($router) {
    Route::group(['prefix' => 'quote-request'], function ($router) {
        Route::get('/all', [QuoteRequestController::class, 'index'])->name('all_requests');
        Route::get('/allByUser', [QuoteRequestController::class, 'getByUser'])->name('all_requests_by_user');
        Route::get('/allByCompany/{company_id}', [QuoteRequestController::class, 'getByCompany'])->name('all_requests_by_company');
        Route::post('/updateRequest', [QuoteRequestController::class, 'updateRequest'])->name('updateRequest');
        Route::post('/updateAddress', [QuoteRequestController::class, 'updateAddress'])->name('updateAddress');
        Route::post('/submit', [QuoteRequestController::class, 'store'])->name('store_request');
    });
    Route::group(['prefix' => 'quote-bids'], function ($router) {
        Route::get('/allOnRequest/{request_id}', [QuoteBidsController::class, 'show'])->name('all_on_request');
        Route::get('/allByUser', [QuoteBidsController::class, 'showByUser'])->name('show_user_bids');
        Route::get('/allByCompany/{company_id}', [QuoteBidsController::class, 'showByCompany'])->name('show_company_bids');
        Route::post('/submit', [QuoteBidsController::class, 'store'])->name('store');
    });
    Route::group(['prefix' => 'user-management'], function ($router) {
        Route::post('/create', [UserManagementController::class, 'createUser'])->name('createUser');
        Route::post('/update', [UserManagementController::class, 'updateUser'])->name('updateUser');
        Route::post('/updatePhone', [UserManagementController::class, 'addPhoneToUser'])->name('addPhoneToUser');
        Route::get('/resetPassword/{userId}', [UserManagementController::class, 'ResetUserPassword'])->name('ResetUserPassword');
        Route::post('/delete', [UserManagementController::class, 'deleteUser'])->name('deleteUser');
        Route::get('/all', [UserManagementController::class, 'allUsers'])->name('allUsers');
        Route::get('/show/{userid}', [UserManagementController::class, 'showUser'])->name('showUser');
    });
    Route::group(['prefix' => 'company-management'], function ($router) {
        Route::post('/updateAlerts', [CompanyManagementController::class, 'updateCompanyAlertMails'])->name('updateCompanyAlertMails');
        Route::post('/updateAlertPref', [CompanyManagementController::class, 'updateAlertPref'])->name('updateAlertPref');
        Route::get('/getCompanyInfo', [CompanyManagementController::class, 'getCompanyInfo'])->name('getCompanyInfo');
        Route::post('/updateCompanyInfo', [CompanyManagementController::class, 'updateCompanyInfo'])->name('updateCompanyInfo');
        Route::post('/updateCreditCard', [CompanyManagementController::class, 'updateCreditCard'])->name('updateCreditCard');
    });
});
