<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class APIWyreController
{

    public function show()
    {

        return View::make('api-wyre.show');
    }
}
