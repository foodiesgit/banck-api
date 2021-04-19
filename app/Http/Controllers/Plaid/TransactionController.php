<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;

class TransactionController extends Controller
{

    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }

    public function index()
    {
        $request = app()->make('request');
        return response()->json([
            'transactions' => $this->plaid->transactionGet($request->all()),
        ]);
    }
}
