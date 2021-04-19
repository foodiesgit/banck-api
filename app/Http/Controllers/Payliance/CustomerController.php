<?php

namespace App\Http\Controllers\Payliance;

use App\Http\Controllers\Controller;
use App\Http\Helper\Payliance;
use App\Http\Requests\Api\Payliance\CustomerRequest;

class CustomerController extends Controller
{
    protected $payliance;
    public function __construct()
    {
        $this->payliance = new Payliance();
    }
    public function store(CustomerRequest $request)
    {

        $customer = $this->payliance->CreateCustomers($request->first_name, $request->last_name, $request->company, $request->street_address1, $request->city, $request->state_code, $request->zip_code);

        return response()->json([
            'success' => $customer,
        ]);
    }

    public function payAuth()
    {
        $request = app()->make('request');
        return response()->json([
            'data' => $this->payliance->payAuth($request->all()),
        ]);

    }

}
