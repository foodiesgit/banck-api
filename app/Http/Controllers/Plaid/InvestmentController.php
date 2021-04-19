<?php


namespace App\Http\Controllers\Plaid;


use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {
        $this->plaid = $plaid;
    }

    public function holdingsGet(Request $request)
    {
        return response()->json([
            'holdings' => $this->plaid->investmentHoldingsGet($request)
        ]);
    }

    public function transactionsGet(Request $request)
    {
        return response()->json([
            'transactions' => $this->plaid->investmentTransactionsGet($request)
        ]);
    }

}
