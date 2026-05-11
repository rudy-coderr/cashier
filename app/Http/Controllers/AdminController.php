<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
	/**
	 * Show the admin view.
	 */
	public function index()
	{
		return view('admin.admin');
	}
}

