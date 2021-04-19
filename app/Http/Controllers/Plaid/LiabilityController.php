<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class LiabilityController extends Controller
{

    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }

    public function liabilitiesGet(Request $request)
    {
        return response()->json([
            'liabilities' => $this->plaid->liabilitiesGet($request)
        ]);
    }

}
