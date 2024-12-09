<?php

namespace Database\Factories;

use App\Enum\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	public function definition(): array
	{
		$roles = UserRole::values();

		array_pop($roles);

		return [
			'name' => fake()->name(),
			'username' => fake()->userName(),
			'email' => fake()->unique()->safeEmail(),
			'password' => Hash::make('password'),
			'image' => null,
			'bio' => fake()->text(50),
			'role' => Arr::random($roles),
			'remember_token' => Str::random(10),
		];
	}
}
