<?php

namespace App\Services;

use App\Http\Resources\CompactArticleResource;
use App\Models\Article;
use App\Models\Category;
use Inertia\Inertia;

class Homepage
{
	public static function getHomepageData(): array
	{
		return [
			'latest_articles' => Inertia::defer(
				fn () => CompactArticleResource::collection(
					Article::with('author', 'category')->latest()->limit(5)->get()
				),
				'latest_articles'
			),
			'popular_categories' => Inertia::defer(
				fn () => Category::select('name', 'slug')->mostPopular()->limit(10)->get(),
				'popular_categories'
			)
		];
	}
}
