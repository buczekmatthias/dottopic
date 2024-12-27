<?php

namespace App\Http\Controllers;

use App\Actions\CategoryActions;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompactArticleResource;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
	public function index(): Response
	{
		return inertia('Categories/Index', [
			'categories' => Inertia::defer(fn () => CategoryResource::collection(Category::withCount('articles')->alphabetically()->paginate(20)))
		]);
	}

	public function create(): Response
	{
		return inertia('Categories/Create', [
			'tags' => Tag::select(['name', 'slug'])->alphabetically()->get()
		]);
	}

	public function store(CreateCategoryRequest $request): RedirectResponse
	{
		CategoryActions::storeNewCategory($request->validated());

		return to_route('categories.index');
	}

	public function show(Category $category): Response
	{
		return inertia('Categories/Show', [
			'category' => Inertia::defer(fn () => CategoryResource::make($category)),
			'articles' => Inertia::defer(
				fn () => CompactArticleResource::collection($category->articles()->with(['author'])->paginate(20)),
				'articles'
			)
		]);
	}

	public function edit(Category $category): Response
	{
		$category->tags = $category->tags()->pluck('name');

		return inertia('Categories/Edit', [
			'category' => ['name' => $category->name, 'slug' => $category->slug, 'tags' => $category->tags],
			'tags' => Tag::select(['name', 'slug'])->alphabetically()->get()
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
