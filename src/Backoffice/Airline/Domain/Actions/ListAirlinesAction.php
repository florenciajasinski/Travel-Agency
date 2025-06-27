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
    public function execute(PaginationDto $paginationDto): LengthAwarePaginator
    {
        $perPage = $paginationDto->perPage;
        $page = $paginationDto->page;

        $query = QueryBuilder::for(Airline::class)
            ->allowedFilters(['name', 'description', 'id'])
            ->allowedSorts('name', 'description', 'id')
            ->defaultSort('id');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
