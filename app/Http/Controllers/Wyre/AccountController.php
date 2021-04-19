<?php


namespace App\Http\Controllers\Wyre;


use App\Http\Controllers\Controller;
use App\Repo\Wyre\WyreInterface;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $wyre;
    public function __construct(WyreInterface $wyre)
    {
        $this->wyre = $wyre;
    }

    public function index(Request $request)
    {
        $response = $this->wyre->accountGet($request->all());
        return $this->successResponse('', $response->getStatusCode(), $response->json());
    }
}
