<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property-read \Lightit\Backoffice\City\Domain\Models\City $resource
 */
class CityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
