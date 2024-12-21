<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CompactArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\Reactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;
use Illuminate\Support\Str;

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
			'articles' => CompactArticleResource::collection(Article::with(['author', 'category'])->withCount('reactions')->latest()->paginate(20))
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

	public function store(CreateArticleRequest $request)
	{
		$data = $request->validated();

		$article = Category::where('slug', $data['category_slug'])->first()->articles()->create([
			'title' => $data['title'],
			'slug' => Str::uuid(),
			'content' => json_encode([]),
			'description' => $data['description'],
			'author_id' => Auth::user()->id
		]);

		try {
			foreach ($data['content'] as &$content) {
				if ($content['type'] === 'file') {
					$file = $content['content'];
					$name = Str::random(35).".".$file->extension();

					Storage::putFileAs("articles/{$article->slug}", $file, $name);

					$content['content'] = $name;
				}
			}

			$article->content = json_encode($data['content']);
			$article->tags()->sync(Tag::select('id')->whereIn('slug', $data['tags'])->pluck('id'));

			$article->save();

			return to_route('articles.show', ['article' => $article->slug]);
		} catch (\Exception $e) {
			collect($data['content'])->where('type', 'file')->pluck('content')->each(function ($file) use ($article) {
				Storage::delete("articles/{$article->slug}/{$file}");
			});
			Storage::deleteDirectory("articles/{$article->slug}");

			$article->delete();

			return back()->withErrors(['err' => $e->getMessage()]);
		}
	}

	public function show(Article $article): Response
	{
		$article->load(['author', 'reactions', 'category', 'tags']);
		$article->comments = $article->comments()->with('author')->paginate(50, pageName:'comments');

		$availableReactions = Reactions::getAvailableReactions();

		$rc = [];

		foreach ($availableReactions as $r => $c) {
			$count = $article->reactions->where('content', $r)->count();

			if ($count > 0) {
				$rc[$r] = $count;
			}
		}

		$article->reactions_count = [
			'display' => array_keys(collect($rc)->sort(fn ($a, $b) => $b <=> $a)->slice(0, 3)->toArray()),
			'count' => array_sum($rc)
		];

		return inertia('Articles/Show', [
			'article' => ArticleResource::make($article),
			'availableReactions' => $availableReactions
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

	public function update(UpdateArticleRequest $request, Article $article)
	{
		$data = $request->validated();

		$article->update([
			'title' => $data['title'],
			'description' => $data['description']
		]);

		$article->category_id = Category::select('id')->where('slug', $data['category_slug'])->first()->id;

		foreach ($data['content'] as &$content) {
			if ($content['type'] === 'file') {
				if ($content['content'] instanceof UploadedFile) {
					$file = $content['content'];
					$name = Str::random(35).".".$file->extension();

					Storage::putFileAs("articles/{$article->slug}", $file, $name);

					$content['content'] = $name;
				} else {
					$content['content'] = Arr::last(explode("/", $content['content']));
				}
			}
		}

		if (Arr::exists($data, 'files_to_remove')) {
			$oldContent = json_decode($article->content);

			foreach ($data['files_to_remove'] as $f) {
				if ($oldContent[$f]->type === 'file') {
					Storage::delete("articles/{$article->slug}/{$oldContent[$f]->content}");
					if ($key = array_search($f, array_column($data['content'], 'id'))) {
						Arr::pull($data['content'], $key);
					}
				}
			}
		}

		$article->content = json_encode($data['content']);
		$article->tags()->sync(Tag::select('id')->whereIn('slug', $data['tags'])->pluck('id'));

		$article->save();

		return to_route('articles.show', ['article' => $article->slug]);
	}

	public function destroy(Article $article)
	{
		collect($article->content)->where('type', 'file')->pluck('content')->each(function ($file) use ($article) {
			Storage::delete("articles/{$article->slug}/{$file}");
		});
		Storage::deleteDirectory("articles/{$article->slug}");

		$article->reactions()->delete();
		$article->tags()->detach();
		$article->delete();

		return to_route('articles.index', status:303);
	}
}
