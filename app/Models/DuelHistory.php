<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $player_one_id
 * @property int $player_one_points
 * @property Player $player_one
 * @property int $player_two_id
 * @property int $player_two_points
 * @property Player $player_two
 * @property int $winner_id
 * @property Player $winner
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class DuelHistory extends Model
{
    public function playerOne(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_one_id');
    }

    public function playerTwo(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_two_id');
    }

    public function winner(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'winner_id');
    }
}
