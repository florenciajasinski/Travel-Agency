<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\Flight\Domain\Models\Flight;

/**
 * @property int                          $id
 * @property string                       $name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereUpdatedAt($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Airline> $airlines
 * @property-read int|null $airlines_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $flightsAsDeparture
 * @property-read int|null $flights_as_departure_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $flights
 * @property-read int|null $flights_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $flightsArrival
 * @property-read int|null $flights_arrival_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $flightsDeparture
 * @property-read int|null $flights_departure_count
 *
 * @mixin \Eloquent
 */
class City extends Model
{
    protected $table = 'cities';

    protected $guarded = ['id'];

    /**
     * @return HasMany<Flight, $this>
     */
    public function flightsDeparture(): HasMany
    {
        return $this->hasMany(Flight::class, 'departure_city_id');
    }

    /**
     * @return HasMany<Flight, $this>
     */
    public function flightsArrival(): HasMany
    {
        return $this->hasMany(Flight::class, 'arrival_city_id');
    }

    /**
     * @return BelongsToMany<Airline, $this>
     */
    public function airlines(): BelongsToMany
    {
        return $this->belongsToMany(Airline::class);
    }
}
