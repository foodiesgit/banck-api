<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class AuthDetailsController extends Controller
{

    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }

    public function authGet(Request $request)
    {
        return response()->json([
            'auth' => $this->plaid->authGet($request),
        ]);

    }


}
