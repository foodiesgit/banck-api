<?php
use App\Http\Controllers\APIWyreController;
use App\Http\Controllers\APITesterController;
use App\Http\Controllers\BBVAController;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'checkauth'], function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'show']);
    Route::get('/api-tester/plaid', [APITesterController::class, 'plaid']);
    Route::get('/api-tester/payliance', [APITesterController::class, 'payliance']);

    // BBVA API Tester Routes
    Route::get('/api-tester/bbva', [BBVAController::class, 'show']);
    Route::get('/api-tester/bbva/obtain-token', [BBVAController::class, 'obtainAccessToken']);
    Route::post('/api-tester/bbva/invalidate-token', [BBVAController::class, 'invalidateAccessToken']);
    Route::post('/api-tester/bbva/create-consumer', [BBVAController::class, 'createConsumer']);
    Route::get('/api-tester/bbva/reload-consumers', [BBVAController::class, 'reloadConsumers']);
    Route::get('/api-tester/bbva/view-consumer/{id}', [BBVAController::class, 'viewConsumerDetails']);
    Route::get('/api-tester/bbva/review-kyc/{id}', [BBVAController::class, 'reviewKYC']);
    Route::get('/api-tester/bbva/update-consumer/{id}', [BBVAController::class, 'updateConsumer']);
    Route::post('/api-tester/bbva/update-consumer', [BBVAController::class, 'submitUpdateConsumer']);
    Route::get('/api-tester/bbva/upload-consumer-docs/{id}', [BBVAController::class, 'uploadConsumerDocs']);
    Route::post('/api-tester/bbva/upload-consumer-docs', [BBVAController::class, 'submitUploadConsumerDocs']);

    //WYRE API Tester Routes
    Route::get('/api-wyre',[APIWyreController::class,'show']);

    // Visa API Tester Routes
    Route::get('/api-tester/visa', [VisaController::class, 'show']);
    Route::post('/api-tester/update-travel-notification', [VisaController::class, 'updateTravelNotification']);
    Route::post('/api-tester/register-call-back', [VisaController::class, 'registerCallBack']);
    Route::post('/api-tester/multi-push-funds-transactions', [VisaController::class, 'multiPushFundsTransactions']);
    Route::post('/api-tester/total-inquiry', [VisaController::class, 'totalsInquiry']);
    Route::post('/api-tester/route-inquiry', [VisaController::class, 'routeInquiry']);
    Route::post('/api-tester/atm-inquiry', [VisaController::class, 'atmInquiry']);
    Route::post('/api-tester/geo-codes-inquiry', [VisaController::class, 'geoCodesInquiry']);
    Route::post('/api-tester/create-alias', [VisaController::class, 'createAlias']);
    Route::post('/api-tester/generate-visa-ccvv', [VisaController::class, 'cvv2generation']);

});

Route::group(array('middleware' => 'checknoauth'), function () {
    Route::get('/login', [LoginController::class, 'show']);
    Route::post('/login', [LoginController::class, 'login']);
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::post('/get_access_token', function () {
//     $request = app()->make('request');
//     return response()->json([
//         'data' => $request->all(),
//     ]);
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('table-list', function () {
        return view('pages.table_list');
    })->name('table');

    Route::get('typography', function () {
        return view('pages.typography');
    })->name('typography');

    Route::get('icons', function () {
        return view('pages.icons');
    })->name('icons');

    Route::get('map', function () {
        return view('pages.map');
    })->name('map');

    Route::get('notifications', function () {
        return view('pages.notifications');
    })->name('notifications');

    Route::get('rtl-support', function () {
        return view('pages.language');
    })->name('language');

    Route::get('upgrade', function () {
        return view('pages.upgrade');
    })->name('upgrade');

    Route::get('calculator',function () {
        return view('pages.calculator.calculator');
    })->name('calculator');

});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('plaid-testing', 'App\Http\Controllers\Plaid\PlaidTestingController');
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    Route::get('term-days','\App\Http\Controllers\CalculatorController@getDays');
});
