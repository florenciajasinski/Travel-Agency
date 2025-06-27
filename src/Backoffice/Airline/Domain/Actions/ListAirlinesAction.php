<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\Pagination\PaginationDto;
use Spatie\QueryBuilder\QueryBuilder;

class ListAirlinesAction
{
    /**
     * @return LengthAwarePaginator<int, Model>
     */
    public function execute(int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return QueryBuilder::for(Airline::class)
            ->allowedFilters(['name', 'description'])
            ->allowedSorts('name', 'description')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
