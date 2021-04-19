<?php

namespace App\Http\Controllers\Plaid;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json([
            'customers' => Customer::with(['plaidProducts'])->orderBy('created_at', 'desc')->get(),
        ]);
    }

    
}
