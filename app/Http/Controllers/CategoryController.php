<?php

namespace App\Http\Controllers;

use App\Actions\CategoryActions;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
	public function index(Request $request): Response
	{
		return inertia('Categories/Index', [
			'categories' => Inertia::defer(fn () => CategoryResource::collection(CategoryActions::getPaginatedCategoriesWithContent($request->get('page', 1))))
		]);
	}

	public function create(): Response
	{
		return inertia('Categories/Create', [
			'tags' => Tag::select(['name'])->alphabetically()->get()
		]);
	}

	public function store(CreateCategoryRequest $request): RedirectResponse
	{
		CategoryActions::storeNewCategory($request->validated());

		return to_route('categories.index');
	}

	public function show(Category $category): Response
	{
		$category = Cache::flexible(
			"category-{$category->slug}",
			[10, 20],
			function () use ($category) {
				$category->articles = $category->articles()->with(['author', 'category'])->paginate(20);

				return $category;
			}
		);

		return inertia('Categories/Show', [
			'category' => Inertia::defer(fn () => CategoryResource::make($category))
		]);
	}

	public function edit(Category $category): Response
	{
		$category->tags = $category->tags()->pluck('name');

		return inertia('Categories/Edit', [
			'category' => ['name' => $category->name, 'slug' => $category->slug, 'tags' => $category->tags],
			'tags' => Tag::select(['name'])->alphabetically()->get()
		]);
	}

	public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
	{
		CategoryActions::updateCategory($request->validated(), $category);

		return to_route('categories.index', status: 303);
	}

	public function destroy(Category $category): RedirectResponse
	{
		CategoryActions::destroyCategory($category);

		return to_route('categories.index', status: 303);
	}
}
