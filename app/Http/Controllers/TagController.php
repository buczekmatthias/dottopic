<?php

namespace App\Http\Controllers;

use App\Actions\TagActions;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompactArticleResource;
use App\Http\Resources\TagResource;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
	public function index(): Response
	{
		return inertia('Tags/Index', [
			'tags' => Inertia::defer(fn () => TagResource::collection(Tag::select(['name', 'slug'])->withCount(['articles', 'categories'])->alphabetically()->paginate(50)))
		]);
	}

	public function create(): Response
	{
		return inertia('Tags/Create', [
			'categories' => Category::select(['name', 'slug'])->alphabetically()->get()
		]);
	}

	public function store(CreateTagRequest $request): RedirectResponse
	{
		TagActions::storeNewTag($request->validated());

		return to_route('tags.index');
	}

	public function show(Tag $tag): Response
	{
		return inertia('Tags/Show', [
			'tag' => TagResource::make($tag),
			'articles' => Inertia::defer(
				fn () => CompactArticleResource::collection($tag->articles()->with(['author', 'category'])->paginate(20, pageName: 'articlesPage')),
				'articles'
			),
			'categories' => Inertia::defer(
				fn () => CategoryResource::collection($tag->categories()->withCount('articles')->paginate(30, pageName: 'categoriesPage')),
				'categories'
			)
		]);
	}

	public function edit(Tag $tag): Response
	{
		$tag->categories = $tag->categories()->pluck('name');

		return inertia('Tags/Edit', [
			'tag' => $tag,
			'categories' => Category::select(['name', 'slug'])->alphabetically()->get()
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
