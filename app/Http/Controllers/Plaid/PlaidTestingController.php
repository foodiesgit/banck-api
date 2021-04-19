<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class PlaidTestingController extends Controller
{

    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }
    public function index()
    {
        return response()->json([
            'plaidAccounts' => $this->plaid->orderBy('created_at', 'desc')->get(),
        ]);
    }
    public function store(Request $request)
    {

        return $this->plaid->createLinkToken($request->all());
    }

}
