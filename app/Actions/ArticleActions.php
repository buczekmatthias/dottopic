<?php

namespace App\Actions;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\Reactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class ArticleActions
{
	public static function storeNewArticle(array $data): string
	{
		return DB::transaction(function () use ($data) {
			$article = Category::where('slug', $data['category_slug'])->first()->articles()->create([
				'title' => $data['title'],
				'slug' => Str::uuid(),
				'content' => json_encode([]),
				'description' => $data['description'],
				'author_id' => Auth::user()->id
			]);

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

			return $article->slug;
		});
	}

	public static function destroyArticle(Article $article): void
	{
		DB::transaction(function () use ($article) {
			collect($article->content)->where('type', 'file')->pluck('content')->each(function ($file) use ($article) {
				Storage::delete("articles/{$article->slug}/{$file}");
			});
			Storage::deleteDirectory("articles/{$article->slug}");

			$article->reactions()->delete();
			$article->tags()->detach();
			$article->delete();
		});
	}

	public static function getArticleShowData(Article $article): array
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

		return [
			'article' => $article,
			'availableReactions' => $availableReactions
		];
	}

	public static function updateArticle(array $data, Article $article): void
	{
		DB::transaction(function () use ($data, $article) {
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
		});
	}
}
