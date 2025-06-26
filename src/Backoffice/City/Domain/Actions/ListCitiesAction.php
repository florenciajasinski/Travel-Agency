<?php

declare(strict_types=1);

namespace Lightit\Backoffice\City\Domain\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Backoffice\City\Domain\Models\City;
use Lightit\Backoffice\Pagination\PaginationDto;
use Spatie\QueryBuilder\QueryBuilder;

class ListCitiesAction
{
    /**
     * @return LengthAwarePaginator<int, Model>
     */
    public function execute(PaginationDto $paginationDto): LengthAwarePaginator
    {
        $query = QueryBuilder::for(City::class)
            ->allowedFilters(['name', 'id'])
            ->allowedSorts('name', 'id')
            ->defaultSort('id');
        return $query->paginate($paginationDto->perPage, ['*'], 'page', $paginationDto->page);
    }


}
