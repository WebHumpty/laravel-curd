<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
	/**
	 * вернуть станицу
	 *
	 * @return View
	 */
	public function index(): View
	{
		return view('layouts.default');
	}
}
