<?php

namespace App\Game;

use App\Models\DuelCards;
use Illuminate\Support\Collection;

class GamePointCalculator
{
    public function calculateGamePoints(Collection $cards): int
    {
        $points = 0;
        /**
         * @var DuelCards $card
         */
        foreach ($cards as $card) {
            $points += $card->card->power;
        }

        return $points;
    }
}
