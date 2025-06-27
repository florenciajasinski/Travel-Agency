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
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
        ];
    }
}
