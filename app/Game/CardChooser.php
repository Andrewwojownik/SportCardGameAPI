<?php

namespace App\Game;

use App\Models\Card;
use Illuminate\Support\Collection;

class CardChooser
{
    public function isAllowedToDrawNewCard(int $currentLevel, int $cardCount): bool
    {
        if ($this->cardCountAllowedOnLevel($currentLevel) > $cardCount) {
            return true;
        }

        return false;
    }

    public function cardCountAllowedOnLevel(int $currentLevel): int
    {
        return match (($currentLevel)) {
            1 => 5,
            2 => 10,
            3 => 15,
            default => 0,
        };
    }

    public function chooseNextCard(Collection $cards): Card
    {
        //TODO more logic if needed
        return $cards->random();
    }
}
