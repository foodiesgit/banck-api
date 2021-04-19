<?php


namespace App\Http\Controllers;

use App\Http\Services\CalculatorService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CalculatorController extends Controller
{

    /**
     * Return a count of business days
     * @access public
     * @see CalculatorService::getDays()
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDays(Request $request)
    {
        /** @var CalculatorService $calculatorService */
        $calculatorService = app(CalculatorService::class);
        return response()->json([
            'days' => $calculatorService->getDays($request->input('months'))
        ]);
    }
}
