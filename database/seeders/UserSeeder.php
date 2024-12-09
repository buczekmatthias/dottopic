<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		User::factory()->create([
			'name' => 'Hazy',
			'username' => '_hazy',
			'email' => 'hazy@test.com',
			'role' => UserRole::DEV
		]);

		User::factory(50)->create();
	}
}
