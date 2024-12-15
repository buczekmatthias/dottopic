<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Tag;
use App\Services\SlugGenerator;
use Illuminate\Support\Arr;
use Inertia\Response;

class CategoryController extends Controller
{
	public function index(): Response
	{
		$categories = Category::alphabetically()->paginate(3);

		Arr::map($categories->items(), fn ($c) => $c->articles = $c->articles()->with(['author'])->paginate(10, pageName: "{$c->slug}-page"));

		return inertia('Categories/Index', [
			'categories' => CategoryResource::collection($categories)
		]);
	}

	public function create(): Response
	{
		return inertia('Categories/Create', [
			'tags' => Tag::select(['name'])->alphabetically()->get()
		]);
	}

	public function store(CreateCategoryRequest $request)
	{
		$category = Category::create([
			'name' => $request->post('name'),
			'slug' => SlugGenerator::generate($request->post('name'))
		]);

		if ($category->id) {
			$tags = Tag::select('id')->whereIn('name', $request->post('tags'))->get();
			$category->tags()->sync($tags);

			$category->save();

			return to_route('categories.index');
		}

		return back();
	}

	public function show(Category $category): Response
	{
		$category->articles = $category->articles()->with(['author', 'category'])->paginate(20);

		return inertia('Categories/Show', [
			'category' => CategoryResource::make($category)
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

	public function update(UpdateCategoryRequest $request, Category $category)
	{
		$category->update([
			'name' => $request->post('name'),
			'slug' => SlugGenerator::generate($request->post('name'))
		]);

		$tags = Tag::select('id')->whereIn('name', $request->post('tags'))->get();

		$category->tags()->sync($tags);

		$category->save();

		if (Category::select('id')->where('name', $request->post('name'))->first()) {
			return to_route('categories.index', status: 303);
		}

		return back(status: 303);
	}

	public function destroy(Category $category)
	{
		$category->tags()->detach();

		collect($category->articles)->each(function ($article) {
			$article->category_id = null;

			$article->save();
		});

		$category->delete();

		return to_route('categories.index', status: 303);
	}
}
