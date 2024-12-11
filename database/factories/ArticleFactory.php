<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title' => fake()->sentence(),
			'slug' => fake()->unique()->uuid(),
			'description' => fake()->sentences(3, true),
			'content' => json_encode([
				[
					'type' => 'header',
					'content' => fake()->sentence(4)
				],
				[
					'type' => 'text',
					'content' => fake()->sentences(4, true)
				],
				[
					'type' => 'text',
					'content' => fake()->sentences(8, true)
				],
				[
					'type' => 'text',
					'content' => fake()->sentences(2, true)
				],
			])
		];
	}
}
