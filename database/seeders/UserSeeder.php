<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = UserRole::where('name', 'admin')->first();

        \App\Models\User::factory()->create([
            'first_name'   => 'System',
            'last_name'    => 'Admin',
            'email'        => 'admin123@example.com',
            'password'     => Hash::make('admin123'),
            'user_role_id' => $admin->id,
        ]);
    }
}
