<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Tag;
use App\Services\SlugGenerator;
use Illuminate\Support\Facades\DB;

final class TagActions
{
	public static function storeNewTag(array $data): void
	{
		DB::transaction(function () use ($data) {
			$tag = Tag::create([
				'name' => $data['name'],
				'slug' => SlugGenerator::generate($data['name'])
			]);

			if ($tag->id) {
				$categories = Category::select('id')->whereIn('name', $data['categories'])->get();
				$tag->categories()->sync($categories);

				$tag->save();
			}
		});
	}

	public static function updateTag(array $data, Tag $tag): void
	{
		$tag->update([
			'name' => $data['name'],
			'slug' => SlugGenerator::generate($data['name'])
		]);

		$categories = Category::select('id')->whereIn('name', $data['categories'])->get();

		$tag->categories()->sync($categories);

		$tag->save();
	}
}
