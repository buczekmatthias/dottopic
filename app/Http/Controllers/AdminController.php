<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
	public function articles(Request $request): Response
	{
		$sortColumn = $request->get('column', 'id');
		$sortOrder = $request->get('order', 'ASC');

		$query = Article::select(['id', 'title', 'slug', 'description', 'author_id', 'category_id', 'created_at'])
					->with(['author:id,name,username', 'category:id,name,slug'])
					->withCount(['comments', 'reactions', 'tags']);

		match ($sortColumn) {
			'author' => $query->orderBy(User::select('name')->whereColumn('users.id', 'articles.author_id'), $sortOrder),
			'category' => $query->orderBy(Category::select('name')->whereColumn('categories.id', 'articles.category_id'), $sortOrder),
			default => $query->orderBy($sortColumn, $sortOrder)
		};

		return inertia('Admin/Article', [
			'articles' => Inertia::defer(
				function () use ($query) {
					return  ArticleResource::collection(
						$query->paginate(25)
					);
				}
			)
		]);
	}

	public function categories(): Response
	{
		return inertia('Admin/Category');
	}

	public function tags(): Response
	{
		return inertia('Admin/Tag');
	}

	public function users(): Response
	{
		return inertia('Admin/User');
	}
}
