<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Repo\Plaid\PlaidInterface;
use Illuminate\Http\Request;

class AssetReportController extends Controller
{
    protected $plaid;
    public function __construct(PlaidInterface $plaid)
    {

        $this->plaid = $plaid;
    }

    public function create(Request $request)
    {

        return response()->json([
            'asset' => $this->plaid->assetReportCreate($request->all()),
        ]);
    }

    public function assetReportGet(Request $request)
    {

        return response()->json([
            'asset' => $this->plaid->assetReportGet($request->all()),
        ]);

    }

    public function pdfGet(Request $request)
    {
        return response()->json([
            'asset' => $this->plaid->pdfGet($request->all()),
        ]);

    }

    public function assetRemove(Request $request)
    {
        return response()->json([
            'asset' => $this->plaid->assetRemove($request->all()),
        ]);

    }

    public function auditCreate(Request $request)
    {
        return response()->json([
            'asset' => $this->plaid->auditCreate($request->all()),
        ]);

    }
}
