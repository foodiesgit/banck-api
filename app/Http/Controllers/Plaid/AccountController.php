<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }

    public function store(Request $request)
    {

        return response()->json([
            'accounts' => $this->plaid->accountGet($request->all()),
        ]);

    }
    public function accountBalanceGet(Request $request)
    {

        return response()->json([
            'accounts' => $this->plaid->accountBalanceGet($request->all()),
        ]);
    }
    public function getBalance(Request $request)
    {
        return response()->json([
            'balance' => $this->plaid->getBalance($request)
        ]);
    }

    public function createProcess(Request $request)
    {
        return response()->json([
            'process' => $this->plaid->createProcess($request)
        ]);
    }

    public function bankAccountCreate(Request $request)
    {
        return response()->json([
            'process' => $this->plaid->bankAccountCreate($request)
        ]);
    }
}
