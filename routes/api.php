<?php

use App\Http\Controllers\API\AirportController;
use App\Http\Controllers\API\CompanyManagementController;
use App\Http\Controllers\API\CompanySearchController;
use App\Http\Controllers\API\QuoteBidsController;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\QuoteRequestController;
use App\Http\Controllers\API\RFPBidsController;
use App\Http\Controllers\API\RFPController;
use App\Http\Controllers\API\UserManagementController;
use App\Http\Controllers\API\WarehouseController;
use App\Http\Controllers\API\FilingsController;
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
], function ($router) {
    Route::group(['prefix' => 'quote-request'], function ($router) {
        Route::get('/allByUser', [QuoteRequestController::class, 'allByUser'])->name('all_requests_by_user');
        Route::get('/allByCompany/{company_id}', [QuoteRequestController::class, 'getByCompany'])->name('all_requests_by_company');
        Route::post('/updateRequest', [QuoteRequestController::class, 'updateRequest'])->name('updateRequest');
        Route::post('/updateAddress', [QuoteRequestController::class, 'updateAddress'])->name('updateAddress');
        Route::post('/submit', [QuoteRequestController::class, 'store'])->name('store_request');
        Route::post('/search', [QuoteRequestController::class, 'searchQuoteRequest'])->name('searchQuoteRequest');
    });
    Route::group(['prefix' => 'quote-bids'], function ($router) {
        Route::get('/allOnRequest/{request_id}', [QuoteBidsController::class, 'show'])->name('all_on_request');
        Route::get('/allByUser', [QuoteBidsController::class, 'showByUser'])->name('show_user_bids');
        Route::get('/allByCompany/{company_id}', [QuoteBidsController::class, 'showByCompany'])->name('show_company_bids');
        Route::post('/submit', [QuoteBidsController::class, 'store'])->name('store');

    });
    Route::group(['prefix' => 'rfps'], function ($router) {
        Route::get('/allByUser', [RFPController::class, 'allByUser'])->name('all_rfp_by_user');
        Route::get('/allByCompany/{company_id}', [RFPController::class, 'allByCompany'])->name('all_rfp_by_company');
        Route::get('/show/{id}', [RFPController::class, 'show'])->name('show_rfp');
        Route::post('/submit', [RFPController::class, 'store'])->name('store_rfp');
        Route::post('/search', [RFPController::class, 'searchRFP'])->name('searchRFP');
        Route::post('/update', [RFPController::class, 'update'])->name('update_rfp');
    });
    Route::group(['prefix' => 'rfp-bids'], function ($router) {
        Route::get('/allOnRFP/{rfp_id}', [RFPBidsController::class, 'show'])->name('all_on_request');
        Route::get('/allByUser', [RFPBidsController::class, 'showByUser'])->name('show_user_bids');
        Route::get('/allByCompany/{company_id}', [RFPBidsController::class, 'showByCompany'])->name('show_company_bids');
        Route::post('/submit', [RFPBidsController::class, 'store'])->name('store');
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
        Route::post('/UpdateChecklist', [CompanyManagementController::class, 'UpdateChecklist'])->name('UpdateChecklist');
        Route::get('/getCompanyFeaturesCheckList', [CompanyManagementController::class, 'showFeaturesChecklist'])->name('getCompanyFeaturesCheckList');
    });
    Route::group(['prefix' => 'airports'], function ($router) {
        Route::get('/getAll', [AirportController::class, 'index'])->name('getAllAirports');
        Route::get('/getOne/{id}', [AirportController::class, 'show'])->name('getOneAirports');
        Route::get('/getCompanyAirports', [AirportController::class, 'getCompanyAirports'])->name('getCompanyAirports');
        Route::get('/getCompanyAirportDetails/{id}', [AirportController::class, 'getCompanyAirportDetails'])->name('getCompanyAirportDetails');
        Route::post('/addAirportToCompany', [AirportController::class, 'store'])->name('addAirportToCompany');
        Route::post('/updateAirportOperationStatus', [AirportController::class, 'update'])->name('updateAirportOperationStatus');
    });
    Route::group(['prefix' => 'warehouses'], function ($router) {
        Route::get('/getCompanyWarehouses', [WarehouseController::class, 'index'])->name('getCompanyWarehouses');
        Route::get('/getWarehouseDetails/{id}', [WarehouseController::class, 'show'])->name('getWarehouseDetails');
        Route::post('/addWarehouse', [WarehouseController::class, 'store'])->name('addWarehouse');
        Route::post('/updateWarehouse', [WarehouseController::class, 'update'])->name('updateWarehouse');
    });
    Route::group(['prefix' => 'company-search'], function ($router) {
        Route::post('/searchByLocation', [CompanySearchController::class, 'searchByLocation'])->name('searchByLocation');
        Route::post('/searchByStates', [CompanySearchController::class, 'searchByStates'])->name('searchByStates');
        Route::post('/searchByAirport', [CompanySearchController::class, 'searchByAirport'])->name('searchByAirport');
        Route::post('/searchByName', [CompanySearchController::class, 'searchByName'])->name('searchByName');
        Route::post('/searchByWarehouse', [CompanySearchController::class, 'searchByWarehouse'])->name('searchByWarehouse');
    });
    Route::group(['prefix' => 'filing-cabinet'], function ($router) {
        Route::post('/addPostToCabinet', [FilingsController::class, 'store'])->name('addPostToCabinet');
        Route::post('/addNoteToFilings', [FilingsController::class, 'addNote'])->name('addNoteToFilings');
        Route::post('/deleteFilings', [FilingsController::class, 'delete'])->name('deleteFilings');
        Route::get('/getCompanyFilings', [FilingsController::class, 'delete'])->name('getCompanyFilings');
        Route::get('/getCompanyFilings', [FilingsController::class, 'delete'])->name('getCompanyFilings');
        Route::get('/getCompanyFilings', [FilingsController::class, 'getCompanyFilings'])->name('getCompanyFilings');
        Route::get('/getQuoteFilings', [FilingsController::class, 'getQuoteFilings'])->name('getQuoteFilings');
        Route::get('/getRFPFilings', [FilingsController::class, 'getRFPFilings'])->name('getRFPFilings');
    });
});
