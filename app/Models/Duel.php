<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $player_one_id
 * @property Player $playerOne
 * @property int $player_two_id
 * @property Player $playerTwo
 * @property int $last_finished_round
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Duel extends Model
{
    public function playerOne(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_one_id');
    }

    public function playerTwo(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_two_id');
    }
}
