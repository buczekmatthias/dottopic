<?php

namespace App\Http\Controllers;

use App\Services\Dashboard;
use App\Services\Homepage;
use Inertia\Response;

class AppController extends Controller
{
	public function homepage(): Response
	{
		return inertia('Homepage', Homepage::getHomepageData());
	}

	public function adminDashboard(): Response
	{
		return inertia('Admin/Dashboard', Dashboard::getAdminDashboardData());
	}
}
