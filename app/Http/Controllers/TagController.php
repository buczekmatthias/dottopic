<?php

namespace App\Http\Controllers;

use App\Actions\TagActions;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
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

	public function store(CreateTagRequest $request): RedirectResponse
	{
		TagActions::storeNewTag($request->validated());

		return to_route('tags.index');
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

	public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
	{
		TagActions::updateTag($request->validated(), $tag);

		return to_route('tags.index', status: 303);
	}

	public function destroy(Tag $tag): RedirectResponse
	{
		$tag->delete();

		return to_route('tags.index', status: 303);
	}
}
