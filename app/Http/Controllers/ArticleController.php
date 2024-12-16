<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\CompactArticleResource;
use App\Models\Article;
use App\Services\Reactions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;

class ArticleController extends Controller implements HasMiddleware
{
	public static function middleware(): array
	{
		return [
			new Middleware('writer', except: ['index', 'show'])
		];
	}

	public function index(): Response
	{
		return inertia('Articles/Index', [
			'articles' => CompactArticleResource::collection(Article::with(['author', 'category'])->withCount('reactions')->latest()->paginate(20))
		]);
	}

	public function create(): Response
	{
		return inertia('Articles/Create');
	}

	public function store(Request $request)
	{
		//
	}

	public function show(Article $article): Response
	{
		$article->load(['author', 'reactions', 'category']);
		$article->comments = $article->comments()->with('author')->paginate(50, pageName:'comments');

		$availableReactions = Reactions::getAvailableReactions();

		$rc = [];

		foreach ($availableReactions as $r => $c) {
			$count = $article->reactions->where('content', $r)->count();

			if ($count > 0) {
				$rc[$r] = $count;
			}
		}

		$article->reactions_count = [
			'display' => array_keys(collect($rc)->sort(fn ($a, $b) => $b <=> $a)->slice(0, 3)->toArray()),
			'count' => array_sum($rc)
		];

		return inertia('Articles/Show', [
			'article' => ArticleResource::make($article),
			'availableReactions' => $availableReactions
		]);
	}

	public function edit(Article $article): Response
	{
		$article->load(['author', 'comments', 'reactions', 'category']);

		return inertia('Articles/Edit', [
			'article' => ArticleResource::make($article)
		]);
	}

	public function update(Request $request, Article $article)
	{
		//
	}

	public function destroy(Article $article)
	{
		collect($article->content)->where('type', 'image')->pluck('content')->each(function ($img) use ($article) {
			Storage::delete("articles/{$article->slug}/{$img}");
		});
		Storage::deleteDirectory("articles/{$article->slug}");

		$article->reactions()->delete();
		$article->delete();

		return to_route('articles.index', status:303);
	}
}
