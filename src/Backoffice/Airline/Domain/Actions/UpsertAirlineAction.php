<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Airline\Domain\Actions;


use Lightit\Backoffice\Airline\Domain\Models\Airline;
use  Lightit\Backoffice\Airline\Domain\DataTransferObject\AirlineDto;

class UpsertAirlineAction
{
    public function execute(AirlineDto $airlineDto, Airline|null $airline = null): Airline
    {
        if ($airline instanceof Airline) {
            $airline->name = $airlineDto->name ?: $airline->name;
            $airline->description = $airlineDto->description ?: $airline->description;
            if ($airline->isDirty()) {
                $airline->save();
            }

            return $airline;
        }
        $newAirline = new Airline();
        $newAirline->name = $airlineDto->name;
        $newAirline->description = $airlineDto->description;
        $newAirline->save();

        return $newAirline;
    }
}
