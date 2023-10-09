<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PlayerCardSeeder extends Seeder
{
    public function run(): void
    {
        $cardChooser = app()->make(\App\Game\CardChooser::class);

        for ($i = 2; $i <= 7; ++$i) {
            $player = Player::where('id', $i)->first();
            for ($j = 0; $j <= 10; ++$j) {
                $newCard = $cardChooser->chooseNextCard(\App\Models\Card::get());
                $player->cards()->attach($newCard);
            }
        }
    }
}
