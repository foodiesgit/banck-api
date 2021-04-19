<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    // TEST ONLY
    Route::get('/test-api-auth', function () {
        return "Authorized";
    });

});

Route::post('/register', 'App\Http\Controllers\API\AuthController@register');
Route::post('/login', 'App\Http\Controllers\API\AuthController@login');

Route::resource('plaid-testing', 'App\Http\Controllers\Plaid\PlaidTestingController');
Route::post('plaid-transactions-get', 'App\Http\Controllers\Plaid\TransactionController@index');
Route::resource('public-token', 'App\Http\Controllers\Plaid\PublicTokenController');
Route::post('public-token-exchange', 'App\Http\Controllers\Plaid\PublicTokenController@exchange');
Route::resource('item', 'App\Http\Controllers\Plaid\ItemController');
Route::post('account-balance-get', 'App\Http\Controllers\Plaid\AccountController@accountBalanceGet');
Route::resource('account', 'App\Http\Controllers\Plaid\AccountController');
Route::resource('customers', 'App\Http\Controllers\Plaid\CustomerController');

Route::post('/plaid/identity-get', 'App\Http\Controllers\Plaid\IdentityController@getIdentity');
Route::post('/plaid/asset_report/create', 'App\Http\Controllers\Plaid\AssetReportController@create');
Route::post('/plaid/asset_report/get', 'App\Http\Controllers\Plaid\AssetReportController@assetReportGet');
Route::post('/plaid/asset_report/pdf/get', 'App\Http\Controllers\Plaid\AssetReportController@pdfGet');
Route::post('/plaid/asset_report/remove', 'App\Http\Controllers\Plaid\AssetReportController@assetRemove');
Route::post('/plaid/asset_report/audit_copy/create', 'App\Http\Controllers\Plaid\AssetReportController@auditCreate');

Route::post('/plaid/investments/holdings/get', 'App\Http\Controllers\Plaid\InvestmentController@holdingsGet');
Route::post('/plaid/investments/transactions/get', 'App\Http\Controllers\Plaid\InvestmentController@transactionsGet');
Route::post('/plaid/auth/get', 'App\Http\Controllers\Plaid\AuthDetailsController@authGet');
Route::post('/plaid/liabilities/get', 'App\Http\Controllers\Plaid\LiabilityController@liabilitiesGet');
Route::post('/plaid/institutions/get', 'App\Http\Controllers\Plaid\InstitutionController@institutionsGet');
Route::post('/plaid/institutions/get_by_id', 'App\Http\Controllers\Plaid\InstitutionController@institutionsGetById');
Route::post('/plaid/institutions/search', 'App\Http\Controllers\Plaid\InstitutionController@institutionsSearch');
Route::post('/plaid/item/remove', 'App\Http\Controllers\Plaid\ItemController@removeItem');
Route::post('/plaid/account/balance', 'App\Http\Controllers\Plaid\AccountController@getBalance');
Route::post('/plaid/processor/token/create', 'App\Http\Controllers\Plaid\AccountController@createProcess');
Route::post('/plaid/bank/account/create', 'App\Http\Controllers\Plaid\AccountController@bankAccountCreate');
Route::post('/plaid/dwolla/create', 'App\Http\Controllers\Plaid\DwollaController@store');

Route::post('payliance/customers', 'App\Http\Controllers\Payliance\CustomerController@store');
Route::post('payliance/pay-auth', 'App\Http\Controllers\Payliance\CustomerController@payAuth');

Route::resource('wyre-account', 'App\Http\Controllers\Wyre\AccountController');
Route::resource('submit-auth-token', 'App\Http\Controllers\Wyre\AuthTokenController');
