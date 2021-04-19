<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }

    public function store(Request $request)
    {

        return response()->json([
            'item' => $this->plaid->getItem($request->all()),
        ]);
    }
    public function removeItem(Request $request)
    {
        return response()->json([
            'item' => $this->plaid->removeItem($request)
        ]);
    }
}
