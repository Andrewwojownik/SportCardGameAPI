<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        Player::insert([
                           'level' => 1,
                           'level_points' => 1,
                           'user_id' => 1,
                           'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                       ]);

        Player::insert([
                           'level' => 2,
                           'level_points' => 90,
                           'user_id' => 2,
                           'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                       ]);
        Player::insert([
                           'level' => 2,
                           'level_points' => 90,
                           'user_id' => null,
                           'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                       ]);
        Player::insert([
                           'level' => 2,
                           'level_points' => 90,
                           'user_id' => null,
                           'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                       ]);
        Player::insert([
                           'level' => 2,
                           'level_points' => 90,
                           'user_id' => null,
                           'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                       ]);
    }
}
