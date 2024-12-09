<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$articles = Article::all();
		$authors = User::select('id')->get();

		for ($i = 0; $i < 500; $i++) {
			Comment::factory()->for($articles->random())->afterCreating(function (Comment $comment) use ($authors) {
				$comment->author()->associate($authors->random());

				$comment->save();
			})->create();
		}
	}
}
