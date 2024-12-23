<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompactArticleResource;
use App\Models\Article;
use Inertia\Inertia;
use Inertia\Response;

class AppController extends Controller
{
	public function homepage(): Response
	{
		return inertia('Homepage', [
			'latest_articles' => Inertia::defer(
				fn () => CompactArticleResource::collection(
					Article::with('author', 'category')->latest()->limit(5)->get()
				),
				'latest_articles'
			)
		]);
	}

	public function adminDashboard(): Response
	{
		return inertia('Admin/Dashboard');
	}
}
