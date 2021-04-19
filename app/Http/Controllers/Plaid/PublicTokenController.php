<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class PublicTokenController extends Controller
{
    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }

    public function store(Request $request)
    {

        $token =  $this->plaid->createPublicToken($request->all());
        if(!empty($token)){
            $session_token = json_decode($token);
            $session_token = (isset($session_token->access_token)) ? $session_token->access_token : null;
            setSession('publicToken' , $session_token);
        }
        return response()->json([
            'publicToken' => $this->plaid->createPublicToken($request->all()),
        ]);
    }

    public function exchange(Request $request)
    {

        $token =  $this->plaid->publicTokenExchange($request->all());
        if(!empty($token)){
            $session_token = json_decode($token);
            $session_token = (isset($session_token->access_token)) ? $session_token->access_token : null;
            setSession('accessToken' , $session_token);
        }
        return response()->json([
            'accessToken' => $token,
        ]);

    }

}
