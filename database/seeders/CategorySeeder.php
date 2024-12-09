<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Category::factory(20)->afterCreating(function (Category $category) {
			$category->tags()->sync(Tag::select('id')->inRandomOrder()->limit(rand(3, 7))->get());
		})->create();
	}
}
