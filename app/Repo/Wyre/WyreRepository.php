<?php


namespace App\Repo\Wyre;


use App\Repo\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Config;
use App\AppConstant\AppConstant;

class WyreRepository extends BaseRepository implements WyreInterface
{

    private $http;

    public function __construct()
    {
        $this->http = new Http();
    }

    public function config($userData = [])
    {
        unset($userData['_token']);
        if(empty($userData['secretKey'])){
            $userData['secretKey'] = Config::get('wyre.secret');
        }
        if(empty($userData['accountId'])){
            $userData['accountId'] = Config::get('wyre.accountId');
        }
        return $userData;
    }


    public function submitAuthToken($data)
    {
        $sessionPath = '/sessions/auth/key';
        $payload = $this->config($data);
        unset($payload['accountId']);
        $request_url = Config::get('wyre.auth-url').AppConstant::WYRE_AUTH_API_VERSION.$sessionPath;

        return $this->http::post($request_url, $payload);
    }

    public function accountGet($data)
    {
        $sessionPath = '/accounts/';

        $config = $this->config($data);
        $request_url = Config::get('wyre.url').AppConstant::WYRE_API_VERSION.$sessionPath.$config['accountId'];

        return $this->http::withHeaders([
                'Authorization' => 'Bearer '.$config['secretKey']
            ])->get($request_url);
    }
}

