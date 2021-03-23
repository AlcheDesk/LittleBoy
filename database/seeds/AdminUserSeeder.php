<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->command->info('==========> adding basic meowlomo and administrator user <==========');

		// create the meowlomo user
		factory(User::class)->create([
			'name' => 'meowlomo',
			'email' => 'it@meowlomo.com',
			'activation_token' => '',
			'active' => true,
			'password' => bcrypt('mladmin666'),
			'uuid' => (string) Str::uuid(),
		]);

		// create the admin user
		factory(User::class)->create([
			'name' => 'admin',
			'email' => 'admin@example.com',
			'activation_token' => '',
			'active' => true,
			'password' => bcrypt('password'),
			'uuid' => (string) Str::uuid(),
		]);

		$this->command->info('==========> Done adding basic meowlomo and administrator user <==========');

	}
}
