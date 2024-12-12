<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\CompactArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
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
			'articles' => CompactArticleResource::collection(Article::with(['author', 'category'])->latest()->paginate(20))
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
		$article->load(['author', 'comments', 'reactions', 'category']);

		return inertia('Articles/Show', [
			'article' => ArticleResource::make($article)
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
		//
	}
}
