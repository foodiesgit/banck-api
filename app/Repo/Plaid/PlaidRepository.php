<?php

namespace App\Repo\Plaid;

use App\Models\Customer;
use App\Models\PlaidAccount;
use App\Repo\BaseRepository;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\Http;
use OAuth2\Request;
use Uuid;

class PlaidRepository extends BaseRepository implements PlaidInterface
{

    protected $http;
    protected $plaidAccount;
    public function __construct()
    {

        $this->http = new Http();
        $this->model = new PlaidAccount();
    }

    public function config($usersData = [])
    {
        unset($usersData['_token']);
        $usersData['client_id'] = Config::get('plaid.client_id');
        $usersData['secret'] = Config::get('plaid.secret');
        return $usersData;

    }

    public function createLinkToken($data)
    {
        $uuid = Uuid::generate()->string;
        $newData['country_codes'] = [$data['country_codes']];
        $newData['language'] = $data['language'];
        $newData['client_name'] = $data['client_name'];
        $newData['user'] = [
            "client_user_id" => $uuid,
            "legal_name" => $data['legal_name'],
            "phone_number" => $data['phone_number'],
            "email_address" => $data['email_address'],
        ];

        $newData['products'] = $data['products'];

        $response = $this->http::post(Config::get('plaid.url') . '/link/token/create', $this->config($newData));

        $response = $response->body();
        $response = json_decode($response, true);
        if (isset($response["error_type"])) {
            return response()->json([
                'success' => false,
                'response' => $response,
            ], 400);
        } else {
            $response['expiration'] = Carbon::parse($response['expiration']);
            $response['client_user_id'] = $uuid;
            $this->create($response);
            $request = app()->make('request');
            $newRequest = $request;
            $newRequest['country_code'] = $request['country_codes'];
            Customer::create($request->all());
            return response()->json([
                'success' => true,
                'response' => $response,
            ]);

        }

    }

    public function createPublicToken($data)
    {
        $newData = $this->config($data);
        $newData['initial_products'] = ["transactions", "auth", "assets"];
        $response = $this->http::post(Config::get('plaid.url') . '/sandbox/public_token/create', $newData);

        return $response->body();

    }

    public function getLinkToken($linkToken)
    {
        return $this->http::post(Config::get('plaid.url') . '/link/token/create');
    }

    public function publicTokenExchange($data)
    {

        $response = $this->http::post(Config::get('plaid.url') . '/item/public_token/exchange', $this->config($data));

        return $response->body();

    }

    public function getItem($data)
    {

        $response = $this->http::post(Config::get('plaid.url') . '/item/get', $this->config($data));

        return $response->body();

    }

    public function accountGet($data)
    {

        $response = $this->http::post(Config::get('plaid.url') . '/accounts/get', $this->config($data));

        return json_decode($response->body());

    }

    public function transactionGet($data)
    {

        $response = $this->http::post(Config::get('plaid.url') . '/transactions/get', $this->config($data));

        return json_decode($response->body());

    }

    public function accountBalanceGet($data)
    {

        $newData['options'] = [
            'account_ids' => $data['account_ids'],
        ];
        $newData['access_token'] = $data['access_token'];
        $response = $this->http::post(Config::get('plaid.url') . '/accounts/get', $this->config($newData));

        return json_decode($response->body());

    }

    public function getIdentity($data)
    {
        $response = $this->http::post(Config::get('plaid.url') . '/identity/get', $this->config($data));

        return json_decode($response->body());

    }

    public function assetReportCreate($data)
    {
        $newData = $this->config($data);
        $newData['access_tokens'] = [$data['access_token']];
        $newData['days_requested'] = (int) $newData['days_requested'];
        unset($newData['access_token']);
        $response = $this->http::post(Config::get('plaid.url') . '/asset_report/create', $newData);

        return json_decode($response->body());

    }

    public function assetReportGet($data)
    {

        $newData = $this->config($data);
        unset($newData['access_token']);
        $response = $this->http::post(Config::get('plaid.url') . '/asset_report/get', $newData);

        return json_decode($response->body());

    }

    public function pdfGet($data)
    {

        $newData = $this->config($data);
        unset($newData['access_token']);
        $response = $this->http::post(Config::get('plaid.url') . '/asset_report/pdf/get', $newData);

        return json_decode($response->body());

    }

    public function assetRemove($data)
    {

        $newData = $this->config($data);
        unset($newData['access_token']);
        $response = $this->http::post(Config::get('plaid.url') . '/asset_report/remove', $newData);

        return json_decode($response->body());

    }

    public function auditCreate($data)
    {

        $newData = $this->config($data);
        unset($newData['access_token']);
        $response = $this->http::post(Config::get('plaid.url') . '/asset_report/audit_copy/create', $newData);

        return json_decode($response->body());

    }

    public function investmentHoldingsGet($request) {

        if(isset($request->_token)){
            $newData                   = $this->config($request->all());
            $newData[ 'access_token' ] = $request->_token;// in this post we need to access token
            $response = $this->http::post(Config::get('plaid.url') . '/investments/holdings/get', $newData);
            return json_decode($response->body());
        }
       return 'Please run the create Public request and accounts get token request first';
    }

    public function investmentTransactionsGet($request) {
        if(isset($request->_token)) {
            $newData                   = $this->config($request->all());
            $newData[ 'access_token' ] = $request->_token;;// in this post we need to access token
            $newData[ 'start_date' ] = '2021-01-01';
            $newData[ 'end_date' ]   = '2021-02-28';
            $newData[ 'options' ]    = array('count' => 250, 'offset' => 100);
            $response                = $this->http::post(Config::get('plaid.url') . '/investments/transactions/get', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }
    public function authGet($request) {

        if(isset($request->_token)){
            $newData                   = $this->config($request->all());
            $newData[ 'access_token' ] = $request->_token;// in this post we need to access token
            $response = $this->http::post(Config::get('plaid.url') . '/auth/get', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }
    public function liabilitiesGet($request) {

        if(isset($request->_token)) {

            $newData                   = $this->config($request->all());
            $newData[ 'access_token' ] = $request->_token;// in this post we need to access token

            $response                  = $this->http::post(Config::get('plaid.url') . '/liabilities/get', $newData);
            return json_decode($response);
        }

        return 'Please run the create Public request and accounts get token request first';
    }
    public function institutionsGet($request) {

        if(!empty($request)) {
            $newData                    = $this->config($request->all());
            $newData[ 'count' ]         = 20;
            $newData[ 'offset' ]        = 10;
            $newData[ 'country_codes' ] = ['US'];
            $response                   = $this->http::post(Config::get('plaid.url') . '/institutions/get', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }
    public function institutionsGetById($request) {

        if(!empty($request)) {
            $newData                      = $this->config($request->all());
            $newData[ 'institution_id' ]  = 'ins_21';
            $newData[ 'country_codes' ]   = ['US'];
            $response                     = $this->http::post(Config::get('plaid.url') . '/institutions/get_by_id', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }

    public function institutionsSearch($request) {

        if(!empty($request)) {
            $newData                      = $this->config($request->all());
            $newData[ 'query' ]           = 'Huntington Bank';
            $newData[ 'products' ]        = null;
            $newData[ 'country_codes' ]   = ['US'];
            $response                     = $this->http::post(Config::get('plaid.url') . '/institutions/search', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }

    public function removeItem($request) {

        if(!empty($request->_token)) {
            $newData                   = $this->config($request->all());
            $newData[ 'access_token' ] = $request->_token;// in this post we need to access token
            $response                  = $this->http::post(Config::get('plaid.url') . '/item/remove', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }

    public function getBalance($request) {

        if(!empty($request->_token)) {
            $newData                   = $this->config($request->all());
            $newData[ 'access_token' ] = $request->_token;// in this post we need to access token
            $response                  = $this->http::post(Config::get('plaid.url') . '/accounts/balance/get', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }

    public function createProcess($request) {

        if(!empty($request->_token)) {
            $newData                   = $this->config($request->all());
            $newData[ 'access_token' ] = $request->_token;// in this post we need to access token
            $newData[ 'account_id' ]   = $request->account_id;// set account id

            $response                  = $this->http::post(Config::get('plaid.url') . '/processor/dwolla/processor_token/create', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }

    public function bankAccountCreate($request) {

        if(!empty($request->_token)) {

            $newData                   = $this->config($request->all());
            $newData[ 'access_token' ] = $request->_token;// in this post we need to access token
            $newData[ 'account_id' ]   = $request->account_id;// set account id

            $response                  = $this->http::post(Config::get('plaid.url') . '/processor/stripe/bank_account_token/create', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }
    public function dwollaStore($request) {

        if(!empty($request->public_key)) {

            $newData                       = $this->config($request->all());
            $newData[ 'public_key' ]       = $request->public_key;// set post key
            $newData[ 'institution_id' ]   = $request->institution_id;// set account id
            $newData[ 'initial_products' ] = ["auth"];// set auth
            $newData[ 'options' ]          = ['webhook' => "https://www.randomdomain.com/webhook_url"];// set account id

            $response                  = $this->http::post(Config::get('plaid.url') . '/sandbox/public_token/create', $newData);
            return json_decode($response->body());
        }
        return 'Please run the create Public request and accounts get token request first';
    }

    

}
