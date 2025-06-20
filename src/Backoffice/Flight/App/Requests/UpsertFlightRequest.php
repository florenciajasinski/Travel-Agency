<?php

declare(strict_types=1);

namespace Lightit\Backoffice\Flight\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;
use Lightit\Backoffice\Flight\Domain\DataTransferObject\FlightDto;
use Carbon\CarbonImmutable;

class UpsertFlightRequest extends FormRequest
{
    public const AIRLINE_ID = 'airline_id';

    public const DEPARTURE_CITY_ID = 'departure_city_id';

    public const ARRIVAL_CITY_ID = 'arrival_city_id';

    public const DEPARTURE_TIME = 'departure_time';

    public const ARRIVAL_TIME = 'arrival_time';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            self::AIRLINE_ID => ['required', Rule::exists(Airline::class, 'id')],
            self::DEPARTURE_CITY_ID => ['required', Rule::exists(City::class, 'id')],
            self::ARRIVAL_CITY_ID => ['required', Rule::exists(City::class, 'id')],
            self::DEPARTURE_TIME => ['required', 'date_format:Y-m-d H:i:s'],
            self::ARRIVAL_TIME => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($this->validateSameOriginAndDestinationCity()) {
                    $validator->errors()->add(
                        self::ARRIVAL_CITY_ID,
                        'The arrival city cannot be the same as the departure city.'
                    );
                }

                if (! $this->validateFlightDateTimes()) {
                    $validator->errors()->add(
                        self::DEPARTURE_TIME,
                        'The departure time must be before the arrival time.'
                    );
                }
            },
        ];
    }

    private function validateSameOriginAndDestinationCity(): bool
    {
        $arrivalCityId = $this->input(self::ARRIVAL_CITY_ID);
        $departureCityId = $this->input(self::DEPARTURE_CITY_ID);

        return $arrivalCityId == $departureCityId;
    }

    private function validateFlightDateTimes(): bool
    {
        $departure = $this->date(self::DEPARTURE_TIME);
        $arrival = $this->date(self::ARRIVAL_TIME);

        if ($departure === null || $arrival === null) {
            return false;
        }

        return $departure < $arrival;
    }

    public function toDto(): FlightDto
    {

        return new FlightDto(
            airlineId: $this->integer(self::AIRLINE_ID),
            departureCityId: $this->integer(self::DEPARTURE_CITY_ID),
            arrivalCityId: $this->integer(self::ARRIVAL_CITY_ID),
            departureTime: CarbonImmutable::parse((string) $this->string(self::DEPARTURE_TIME)),
            arrivalTime: CarbonImmutable::parse((string) $this->string(self::ARRIVAL_TIME)),
            flightId: $this->route('flight') ? (int) $this->route('flight') : null
        );
    }
}
