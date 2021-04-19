<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{

    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }


    public function institutionsGet(Request $request)
    {
        return response()->json([
            'institutions' => $this->plaid->institutionsGet($request)
        ]);
    }


    public function institutionsGetById(Request $request)
    {
        return response()->json([
            'institutions' => $this->plaid->institutionsGetById($request)
        ]);
    }

    public function institutionsSearch(Request $request)
    {
        return response()->json([
            'institutions' => $this->plaid->institutionsSearch($request)
        ]);
    }

}
