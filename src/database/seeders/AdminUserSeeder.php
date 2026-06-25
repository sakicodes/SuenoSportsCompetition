<?php

	namespace Database\Seeders;
	use Illuminate\Database\Seeder;
	use Illuminate\Support\Facades\Hash;
	use App\Models\User;

	class AdminUserSeeder extends Seeder
	{
		public function run(): void
		{
			User::create([
				'name' => 'System Admin',
				'username' => 'admin',
				'password' => Hash::make('password123'), // Change this later!
				'role' => 'ADMIN',
				'current_points' => 0,
				'first_login' => false,
				'active' => true,
			]);
		}
	}
