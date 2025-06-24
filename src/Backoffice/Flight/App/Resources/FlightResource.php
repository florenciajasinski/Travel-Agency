<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \Lightit\Backoffice\Flight\Domain\Models\Flight $resource
 */
class FlightResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'airline_id' => $this->resource->airline_id,
            'departure_city_id' => $this->resource->departure_city_id,
            'arrival_city_id' => $this->resource->arrival_city_id,
            'departure_time' => $this->resource->departure_time,
            'arrival_time' => $this->resource->arrival_time,
        ];
    }
}
