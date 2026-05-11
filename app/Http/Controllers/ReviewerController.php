<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewerController extends Controller
{
	/**
	 * Show the reviewer view.
	 */
	public function index()
	{
		return view('reviewer.reviewer');
	}
}

