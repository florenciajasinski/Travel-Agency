<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \Lightit\Backoffice\Airline\Domain\Models\Airline $resource
 */
class AirlineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id ?? null,
            'name' => $this->resource->name ?? null,
            'description' => $this->resource->description ?? null,
            'flights_count' => $this->resource->flights_count ?? 0,
        ];
    }
}
