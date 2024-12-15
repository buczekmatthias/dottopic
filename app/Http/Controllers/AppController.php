<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompactArticleResource;
use App\Models\Article;
use Inertia\Response;

class AppController extends Controller
{
	public function homepage(): Response
	{

		return inertia('Homepage', [
			'latest_articles' => CompactArticleResource::collection(Article::with('author', 'category')->latest()->limit(5)->get())
		]);
	}

	public function adminDashboard()
	{
	}
}
