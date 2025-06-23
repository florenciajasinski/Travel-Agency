<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;
use Lightit\Backoffice\Flight\Domain\DataTransferObject\FlightDto;

abstract class BaseFlightRequest extends FormRequest
{
    public const AIRLINE_ID = 'airline_id';

    public const DEPARTURE_CITY_ID = 'departure_city_id';

    public const ARRIVAL_CITY_ID = 'arrival_city_id';

    public const DEPARTURE_TIME = 'departure_time';

    public const ARRIVAL_TIME = 'arrival_time';

    public function rules(): array
    {
        return [
            self::AIRLINE_ID => ['required', Rule::exists(Airline::class, 'id')],
            self::DEPARTURE_CITY_ID => ['required', Rule::exists(City::class, 'id')],
            self::ARRIVAL_CITY_ID => ['required', Rule::exists(City::class, 'id')],
            self::DEPARTURE_TIME => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after:now',
            ],
            self::ARRIVAL_TIME => [
                'required',
                'date_format:Y-m-d H:i:s',
                'after:' . self::DEPARTURE_TIME,
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($this->isOriginCitySameAsDestinationCity()) {
                $validator->errors()->add(
                    self::ARRIVAL_CITY_ID,
                    'The arrival city cannot be the same as the departure city.'
                );
            }
        });
    }

    protected function isOriginCitySameAsDestinationCity(): bool
    {
        $arrivalCityId = $this->integer(self::ARRIVAL_CITY_ID);
        $departureCityId = $this->integer(self::DEPARTURE_CITY_ID);

        return $arrivalCityId == $departureCityId;
    }

    public function toDto(): FlightDto
    {
        return new FlightDto(
            airlineId: $this->integer(self::AIRLINE_ID),
            departureCityId: $this->integer(self::DEPARTURE_CITY_ID),
            arrivalCityId: $this->integer(self::ARRIVAL_CITY_ID),
            departureTime: CarbonImmutable::parse($this->string(self::DEPARTURE_TIME)->toString()),
            arrivalTime: CarbonImmutable::parse($this->string(self::ARRIVAL_TIME)->toString()),
        );
    }
}
