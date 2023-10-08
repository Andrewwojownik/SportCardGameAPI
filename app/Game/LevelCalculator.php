<?php
declare(strict_types=1);

namespace App\Game;

class LevelCalculator
{
    public function getPointsForNextLevel(int $currentLevel): int
    {
        return match (($currentLevel + 1)) {
            2 => 100,
            3 => 160,
            default => 0,
        };
    }
}
