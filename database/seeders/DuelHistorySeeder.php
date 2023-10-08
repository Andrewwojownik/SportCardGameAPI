<?php

namespace Database\Seeders;

use App\Models\DuelHistory;
use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DuelHistorySeeder extends Seeder
{
    public function run(): void
    {
        DuelHistory::insert([
                                'player_one_id' => 1,
                                'player_one_points' => 150,
                                'player_two_id' => 2,
                                'player_two_points' => 100,
                                'winner_id' => 1,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

        DuelHistory::insert([
                                'player_one_id' => 1,
                                'player_one_points' => 150,
                                'player_two_id' => 2,
                                'player_two_points' => 100,
                                'winner_id' => 1,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

        DuelHistory::insert([
                                'player_one_id' => 1,
                                'player_one_points' => 200,
                                'player_two_id' => 3,
                                'player_two_points' => 30,
                                'winner_id' => 1,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

        DuelHistory::insert([
                                'player_one_id' => 1,
                                'player_one_points' => 120,
                                'player_two_id' => 5,
                                'player_two_points' => 80,
                                'winner_id' => 1,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

        DuelHistory::insert([
                                'player_one_id' => 1,
                                'player_one_points' => 100,
                                'player_two_id' => 4,
                                'player_two_points' => 120,
                                'winner_id' => 1,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);

        DuelHistory::insert([
                                'player_one_id' => 1,
                                'player_one_points' => 10,
                                'player_two_id' => 3,
                                'player_two_points' => 250,
                                'winner_id' => 3,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
        DuelHistory::insert([
                                'player_one_id' => 5,
                                'player_one_points' => 50,
                                'player_two_id' => 1,
                                'player_two_points' => 100,
                                'winner_id' => 5,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
    }
}
