<?php

namespace App\Http\Controllers;

use App\Actions\ArticleActions;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CompactArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller implements HasMiddleware
{
	public static function middleware(): array
	{
		return [
			new Middleware('writer', except: ['index', 'show'])
		];
	}

	public function index(Request $request): Response
	{
		$articles = Cache::flexible(
			"articles-{$request->get('page', 1)}",
			[5, 10],
			fn () => Article::with(['author', 'category'])->withCount(['reactions', 'comments'])->latest()->paginate(20)
		);

		return inertia('Articles/Index', [
			'articles' => Inertia::defer(fn () => CompactArticleResource::collection($articles))
		]);
	}

	public function create(): Response
	{
		return inertia('Articles/Create', [
			'categories' => Category::select(['name', 'slug'])->alphabetically()->get(),
			'tags' => Tag::select(['name', 'slug'])->alphabetically()->get(),
			'mimes' => ['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'video/webm']
		]);
	}

	public function store(CreateArticleRequest $request): RedirectResponse
	{
		$slug = ArticleActions::storeNewArticle($request->validated());

		return to_route('articles.show', ['article' => $slug]);
	}

	public function show(Article $article): Response
	{
		$data = ArticleActions::getArticleShowData($article);

		return inertia('Articles/Show', [
			'article' => Inertia::defer(fn () => ArticleResource::make($data['article'])),
			'availableReactions' => $data['availableReactions']
		]);
	}

	public function edit(Article $article): Response
	{
		$article->load(['author', 'comments', 'reactions', 'category', 'tags']);

		return inertia('Articles/Edit', [
			'article' => ArticleResource::make($article),
			'categories' => Category::select(['name', 'slug'])->alphabetically()->get(),
			'tags' => Tag::select(['name', 'slug'])->alphabetically()->get(),
			'mimes' => ['image/jpeg', 'image/png', 'image/webp', 'video/mp4', 'video/webm']
		]);
	}

	public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
	{
		ArticleActions::updateArticle($request->validated(), $article);

		return to_route('articles.show', ['article' => $article->slug]);
	}

	public function destroy(Article $article): RedirectResponse
	{
		ArticleActions::destroyArticle($article);

		return to_route('articles.index', status: 303);
	}
}
