<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    /** Show Dashboard Page
     * Template: views/dashboard.blade.php
     * 
     * @return View
     */
    public function show()
    {
        return View::make('dashboard');
    }
}
