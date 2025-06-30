<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lightit\Backoffice\Airline\App\Resources\AirlineResource;
use Lightit\Backoffice\City\App\Resources\CityResource;

/**
 * @property-read \Lightit\Backoffice\Flight\Domain\Models\Flight $resource
 */
class FlightResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'airline_name' => $this->resource->airline->name,
            'departure_city_name' => $this->resource->departureCity->name,
            'arrival_city_name' => $this->resource->arrivalCity->name,
            'departure_time' => $this->resource->departure_time,
            'arrival_time' => $this->resource->arrival_time,
        ];
    }
}
