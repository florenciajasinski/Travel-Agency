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
            'airline' => AirlineResource::make($this->whenLoaded('airline')),
            'departure_city' => CityResource::make($this->whenLoaded('departureCity')),
            'arrival_city' => CityResource::make($this->whenLoaded('arrivalCity')),
            'departure_time' => $this->resource->departure_time,
            'arrival_time' => $this->resource->arrival_time,
        ];
    }
}
