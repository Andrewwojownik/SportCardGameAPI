<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cardData = include(config_path() . '/game/cards.php');
        foreach ($cardData as $card) {
            Card::insert(array_merge($card, ['created_at' => Carbon::now()->format('Y-m-d H:i:s')]));
        }
    }
}
