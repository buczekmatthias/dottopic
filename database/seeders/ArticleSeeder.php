<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$categories = Category::all();
		$permittedUsers = User::select('id')->typeNot(UserRole::USER)->get();
		$tags = Tag::select('id')->get();

		for ($i = 0; $i < 250; $i++) {
			Article::factory()->for($categories->random())->afterCreating(function (Article $article) use ($permittedUsers, $tags) {
				$article->author()->associate($permittedUsers->random());
				$t = [];

				for ($i = 0; $i < rand(3, 8); $i++) {
					$t[] = $tags->random();
				}

				$article->tags()->sync($t);

				$article->save();
			})->create();
		}
	}
}
