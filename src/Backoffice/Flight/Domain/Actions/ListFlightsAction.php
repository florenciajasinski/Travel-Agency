<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\Domain\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Backoffice\Flight\Domain\Models\Flight;
use Spatie\QueryBuilder\QueryBuilder;

class ListFlightsAction
{
    /**
     * @return LengthAwarePaginator<int, Model>
     */
    public function execute(): LengthAwarePaginator
    {
        return QueryBuilder::for(Flight::class)
            ->allowedFilters(['departure_city_id', 'arrival_city_id', 'departure_time', 'arrival_time'])
            ->allowedSorts('departure_time', 'arrival_time')
            ->with(['departureCity', 'arrivalCity', 'airline'])
            ->paginate();
    }
}
