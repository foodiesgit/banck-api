<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class APITesterController extends Controller
{

    public function plaid()
    {
        return View::make('api-tester.plaid.show');
    }
    public function payliance()
    {
        return View::make('api-tester.payliance.show');
    }
}
