<?php

namespace App\Http\Controllers;

use Inertia\Response;

class AppController extends Controller
{
	public function app(): Response
	{
		return inertia('App');
	}
}
