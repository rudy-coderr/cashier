<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountantController extends Controller
{
    /**
     * Show the accountant approval view.
     */
    public function approval()
    {
        return view('accountant.approval');
    }
}
