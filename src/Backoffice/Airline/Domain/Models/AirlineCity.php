<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int                          $id
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereUpdatedAt($value)
 *
 *
 * @mixin \Eloquent
 */
class AirlineCity extends Model
{
    protected $table = 'airline_city';

    protected $guarded = ['id'];
}
