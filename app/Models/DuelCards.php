<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $duel_id
 * @property int $player_id
 * @property int $card_id
 * @property Duel $duel
 * @property Player $player
 * @property Card $card
 * @property ?int $used_in_round
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class DuelCards extends Model
{
    public function card(): HasOne
    {
        return $this->hasOne(Card::class, 'id', 'card_id');
    }

    public function player(): HasOne
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    public function duel(): HasOne
    {
        return $this->hasOne(Duel::class, 'id', 'duel_id');
    }
}
