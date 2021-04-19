<?php

namespace App\Http\Controllers\Wyre;

use App\Http\Controllers\Controller;
use App\Repo\Wyre\WyreInterface;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{

    protected $wyre;
    public function __construct(WyreInterface $wyre)
    {

        $this->wyre = $wyre;
    }
    public function store(Request $request)
    {
        $response =  $this->wyre->submitAuthToken($request->all());
        return $this->successResponse('', $response->getStatusCode(), $response->json());
    }
}
