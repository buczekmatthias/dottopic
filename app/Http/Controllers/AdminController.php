<?php

namespace App\Http\Controllers;

use App\Enum\Table as EnumTable;
use App\Enum\UserRole;
use App\Http\Resources\Admin\ArticleResource;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\TagResource;
use App\Http\Resources\Admin\UserResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Services\Table;
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
			),
			'table' => Table::getTableContext(EnumTable::ARTICLES)
		]);
	}

	public function categories(Request $request): Response
	{
		$sortColumn = $request->get('column', 'id');
		$sortOrder = $request->get('order', 'ASC');

		match ($sortColumn) {
			'articles' => $sortColumn = 'articles_count',
			'tags' => $sortColumn = 'tags_count',
			default => $sortColumn
		};

		return inertia('Admin/Category', [
			'categories' => Inertia::defer(
				function () use ($sortColumn, $sortOrder) {
					return CategoryResource::collection(
						Category::select(['id', 'name', 'slug'])
						->withCount(['articles', 'tags'])
						->orderBy($sortColumn, $sortOrder)
						->paginate(25)
					);
				}
			),
			'table' => Table::getTableContext(EnumTable::CATEGORIES)
		]);
	}

	public function tags(Request $request): Response
	{
		$sortColumn = $request->get('column', 'id');
		$sortOrder = $request->get('order', 'ASC');

		match ($sortColumn) {
			'articles' => $sortColumn = 'articles_count',
			'categories' => $sortColumn = 'categories_count',
			default => $sortColumn
		};

		return inertia('Admin/Tag', [
			'tags' => Inertia::defer(
				function () use ($sortColumn, $sortOrder) {
					return TagResource::collection(
						Tag::select(['id', 'name', 'slug'])
						->withCount(['articles', 'categories'])
						->orderBy($sortColumn, $sortOrder)
						->paginate(25)
					);
				}
			),
			'table' => Table::getTableContext(EnumTable::TAGS)
		]);
	}

	public function users(Request $request): Response
	{
		$sortColumn = $request->get('column', 'id');
		$sortOrder = $request->get('order', 'ASC');
		$type = $request->get('type', '');

		match ($sortColumn) {
			'articles' => $sortColumn = 'articles_count',
			'categories' => $sortColumn = 'categories_count',
			default => $sortColumn
		};

		$query = User::select(['id', 'name', 'username', 'email', 'role', 'created_at'])
					->withCount(['articles', 'comments'])
					->orderBy($sortColumn, $sortOrder);

		if ($type) {
			$query->type($type);
		}

		return inertia('Admin/User', [
			'users' => Inertia::defer(
				function () use ($query) {
					return UserResource::collection(
						$query->paginate(25)
					);
				}
			),
			'table' => Table::getTableContext(EnumTable::USERS),
			'types' => UserRole::values(),
			'tab' => $type
		]);
	}
}
