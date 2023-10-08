<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $image
 * @property int $power
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Card extends Model
{

}
