@props(['flight'])

<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col">
        <x-form-label-select id="airline" label="Airline" />
        </div>

        <div class="flex flex-col hidden" id="origin_select">
            <x-form-label-select id="origin_city" label="Origin" class="hidden" />
        </div>

        <div class="flex flex-col hidden" id="destination_select">
            <x-form-label-select id="destination_city" label="Destination" class="hidden" />
        </div>

        <x-form-label-date
            id="departure_date"
            label="Departure Date"
            :value="$flight->departure_time->format('Y-m-d')"
        />

        <x-form-label-date
            id="arrival_date"
            label="Arrival Date"
            :value="$flight->arrival_time->format('Y-m-d')"
        />
    </div>

    <div class="mt-4 flex justify-end gap-3">
        <x-button
                id="save_flight_btn"
                button="Save"
            />
        <x-button
                id="cancel_flight_btn"
                button="Cancel"
                class="px-4 py-2 rounded text-sm font-medium bg-gray-300 text-gray-800 hover:bg-gray-400"
            />
    </div>

    <x-error
        id="flight_form_error">
    </x-error>
</div>

