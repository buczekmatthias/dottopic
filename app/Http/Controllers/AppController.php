<?php

namespace App\Http\Controllers;

use Inertia\Response;

class AppController extends Controller
{
	public function homepage(): Response
	{
		return inertia('Homepage');
	}

	public function adminDashboard()
	{
	}
}
