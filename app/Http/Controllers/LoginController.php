<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /** 
     * Show Login View
     * Template: view/login.blade.php
     * 
     * @return View
     */
    public function show()
    {
        return View::make('login');
    }

    /**
     * Attemp to Login
     * 
     * @param Request $request
     * 
     * @return View
     */
    public function login(Request $request)
    {
        if (Auth::attempt(array('email' => $request->input('email'), 'password' => $request->input('password')), ($request->input('remember') == "on"))) {
            return redirect('/');
        } else {
            return View::make('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
