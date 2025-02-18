<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Tag;
use App\Services\SlugGenerator;
use Illuminate\Support\Facades\DB;

final class CategoryActions
{
	public static function storeNewCategory(array $data): void
	{
		DB::transaction(function () use ($data) {
			$category = Category::create([
				'name' => $data['name'],
				'slug' => SlugGenerator::generate($data['name'])
			]);

			if ($category->id) {
				$tags = Tag::select('id')->whereIn('name', $data['tags'])->get();
				$category->tags()->sync($tags);

				$category->save();
			}
		});
	}

	public static function updateCategory(array $data, Category $category): void
	{
		DB::transaction(function () use ($data, $category) {
			$category->update([
				'name' => $data['name'],
				'slug' => SlugGenerator::generate($data['name'])
			]);

			$tags = Tag::select('id')->whereIn('name', $data['tags'])->get();

			$category->tags()->sync($tags);

			$category->save();
		});
	}

	public static function destroyCategory(Category $category): void
	{
		DB::transaction(function () use ($category) {
			$category->tags()->detach();

			collect($category->articles)->each(function ($article) {
				$article->category_id = null;

				$article->save();
			});

			$category->delete();
		});
	}
}
