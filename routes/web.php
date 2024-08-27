<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AirportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClassifiedController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\DriverAdsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QuoteRequestController;
use App\Http\Controllers\Admin\RFPController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\WarehouseController;
use Illuminate\Support\Facades\DB;

Route::get('/migrate', function () {
	Artisan::call('migrate');
	return 'DONE'; // Return anything
});
Route::get('/migrate-refresh', function () {
	Artisan::call('migrate:refresh');
	return 'DONE'; // Return anything
});
Route::get('/migrate-rollback', function () {
	Artisan::call('migrate:rollback');
	return 'DONE'; // Return anything
});
Route::get(
	'/',
	function () {
		return redirect()->route('admin.dashboard');
	}
);

Route::get('/clearcache', function () {
	$exitCode = Artisan::call('config:clear');
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('config:cache');
	$exitCode = Artisan::call('view:clear');
	$exitCode = Artisan::call('route:clear');
	return 'DONE'; //Return anything
});
Route::get('/clearTables', function () {
	DB::table('companies')->truncate();
	DB::table('company_airports')->truncate();
	DB::table('company_profiles')->truncate();
	DB::table('quote_bids')->truncate();
	DB::table('quote_requests')->truncate();
	DB::table('rfps')->truncate();
	DB::table('rfp_bids')->truncate();
	DB::table('users')->truncate();
	DB::table('warehouses')->truncate();
	return 'DONE';
});



Route::group(['prefix'  =>  'admin'], function () {
	Route::get('login', [AuthController::class, 'index'])->name('login');
	Route::post('verify_login', [AuthController::class, 'verify_login']);
	Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:admin');

	Route::group(['middleware' => ['auth:admin']], function () {

		Route::get('/', [AdminController::class, 'index'])->middleware('auth:admin')->name('admin.dashboard');
		Route::get('admin', [AdminController::class, 'index'])->middleware('auth:admin');
		Route::get('change_password', [AdminController::class, 'change_password'])->middleware('auth:admin');
		Route::post('update_password', [AdminController::class, 'update_password'])->middleware('auth:admin');


		Route::group(['prefix'  =>  'companies'], function () {
			Route::get('/', [CompaniesController::class, 'index']);
			Route::get('detail/{id}', [CompaniesController::class, 'details']);
		});
		Route::group(['prefix'  =>  'users'], function () {
			Route::get('/', [UserController::class, 'index']);
			Route::get('detail/{id}', [UserController::class, 'details']);
		});

		Route::group(['prefix'  =>  'quote-requests'], function () {
			Route::get('/', [QuoteRequestController::class, 'index']);
			Route::get('detail/{id}', [QuoteRequestController::class, 'details']);
			Route::post('bidDetails', [QuoteRequestController::class, 'bidDetails']);
		});
		Route::group(['prefix'  =>  'rfps'], function () {
			Route::get('/', [RFPController::class, 'index']);
			Route::get('detail/{id}', [RFPController::class, 'details']);
			Route::post('bidDetails', [RFPController::class, 'bidDetails']);
		});
		Route::group(['prefix'  =>  'airports'], function () {
			Route::get('/', [AirportController::class, 'index']);
			Route::post('/show', [AirportController::class, 'show']);
			Route::post('/store', [AirportController::class, 'store']);
			Route::post('/update', [AirportController::class, 'update']);
			Route::post('/delete', [AirportController::class, 'delete']);
		});
		Route::group(['prefix'  =>  'warehouses'], function () {
			Route::get('/', [WarehouseController::class, 'index']);
			Route::post('/show', [WarehouseController::class, 'show']);
		});
		Route::group(['prefix'  =>  'vehicle-posts'], function () {
			Route::get('/', [VehicleController::class, 'index']);
			Route::post('/show', [VehicleController::class, 'show']);
		});
		Route::group(['prefix'  =>  'driver-ads'], function () {
			Route::get('/', [DriverAdsController::class, 'index']);
			Route::get('detail/{id}', [DriverAdsController::class, 'show']);
			Route::post('responseDetails', [DriverAdsController::class, 'responseDetails']);
		});
		Route::group(['prefix'  =>  'classifieds'], function () {
			Route::get('/', [ClassifiedController::class, 'index']);
			Route::post('show', [ClassifiedController::class, 'show']);
		});
	});
});
