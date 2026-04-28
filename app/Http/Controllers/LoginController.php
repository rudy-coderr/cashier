<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Show the login page.
     */
    public function index()
    {
        return view('login.login');
    }
}
