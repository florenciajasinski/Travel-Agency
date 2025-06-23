<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Backoffice\City\Domain\Models\City;
use Spatie\QueryBuilder\QueryBuilder;

class ListCitiesAction
{
    /**
     *
     * @return LengthAwarePaginator<int, Model>
     */
    public function execute(int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return QueryBuilder::for(City::class)
            ->allowedFilters(['name'])
            ->allowedSorts('name')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
