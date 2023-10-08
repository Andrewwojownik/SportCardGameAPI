<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $username
 * @property int $level
 * @property int $level_points
 * @property ?int $user_id
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Player extends Model
{
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function cards(): belongsToMany
    {
        return $this->belongsToMany(Card::class);
    }
}
