<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;

/**
 * @property int                          $id
 * @property int                          $airline_id
 * @property int                          $departure_city_id
 * @property int                          $arrival_city_id
 * @property CarbonImmutable              $departure_time
 * @property CarbonImmutable              $arrival_time
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereAirlineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereArrivalCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereArrivalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereDepartureCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereDepartureTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereUpdatedAt($value)
 *
 * @property-read Airline $airline
 * @property-read \Illuminate\Database\Eloquent\Collection<int, City> $arrivalCities
 * @property-read int|null $arrival_cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, City> $departureCities
 * @property-read int|null $departure_cities_count
 * @property-read City $arrivalCity
 * @property-read City $departureCity
 *
 * @mixin \Eloquent
 */
class Flight extends Model
{
    protected $table = 'flights';

    protected $guarded = ['id'];

    protected $casts = [
        'departure_time' => 'immutable_datetime',
        'arrival_time' => 'immutable_datetime',
    ];

    /**
     * @return BelongsTo<Airline, $this>
     */
    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function departureCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'departure_city_id');
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function arrivalCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'arrival_city_id');
    }
}
