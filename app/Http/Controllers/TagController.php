<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\Tag;
use App\Services\SlugGenerator;
use Inertia\Response;

class TagController extends Controller
{
	public function index(): Response
	{
		return inertia('Tags/Index', [
			'tags' => Tag::select(['name', 'slug'])->withCount(['articles', 'categories'])->alphabetically()->paginate(100)
		]);
	}

	public function create(): Response
	{
		return inertia('Tags/Create', [
			'categories' => Category::select(['name'])->alphabetically()->get()
		]);
	}

	public function store(CreateTagRequest $request)
	{
		$tag = Tag::create([
			'name' => $request->post('name'),
			'slug' => SlugGenerator::generate($request->post('name'))
		]);

		if ($tag->id) {
			$categories = Category::select('id')->whereIn('name', $request->post('categories'))->get();
			$tag->categories()->sync($categories);

			$tag->save();

			return to_route('tags.index');
		}

		return back();
	}

	public function show(Tag $tag): Response
	{
		$tag->articles = $tag->articles()->with(['author', 'category'])->paginate(20, pageName: 'articlesPage');
		$tag->categories = $tag->categories()->paginate(30, pageName: 'categoriesPage');

		return inertia('Tags/Show', [
			'tag' => TagResource::make($tag)
		]);
	}

	public function edit(Tag $tag): Response
	{
		$tag->categories = $tag->categories()->pluck('name');

		return inertia('Tags/Edit', [
			'tag' => $tag,
			'categories' => Category::select(['name'])->alphabetically()->get()
		]);
	}

	public function update(UpdateTagRequest $request, Tag $tag)
	{
		$tag->update([
			'name' => $request->post('name'),
			'slug' => SlugGenerator::generate($request->post('name'))
		]);

		$categories = Category::select('id')->whereIn('name', $request->post('categories'))->get();

		$tag->categories()->sync($categories);

		$tag->save();

		if (Tag::select('id')->where('name', $request->post('name'))->first()) {
			return to_route('tags.index', status: 303);
		}

		return back(status:303);
	}

	public function destroy(Tag $tag)
	{
		$tag->delete();

		return to_route('tags.index', status: 303);
	}
}
