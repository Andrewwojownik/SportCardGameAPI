<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
                         'id' => 1,
                         'email' => 'test@example.com',
                         'password' => Hash::make('test123'),
                         'name' => 'Test',
                         'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                     ]);
        User::factory()->create();
        User::factory()->create();
        User::factory()->create();
        User::factory()->create();
        User::factory()->create();
        User::factory()->create();
        User::insert([
                         'id' => 10,
                         'email' => 'testempty@example.com',
                         'password' => Hash::make('test123'),
                         'name' => 'Test Empty',
                         'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                     ]);
    }
}
