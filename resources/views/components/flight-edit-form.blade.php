@props(['flight'])

<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col">
        <x-form-label-select id="airline" label="Airline" />
        </div>

        <div class="flex flex-col hidden" id="origin_select">
            <x-form-label-select id="origin_city" label="Origin" />
        </div>

        <div class="flex flex-col hidden" id="destination_select">
            <x-form-label-select id="destination_city" label="Destination" />
        </div>

        <div class="flex flex-col">
            <label for="departure_date" class="text-gray-700 font-semibold mb-1">Departure Date</label>
            <input type="date" id="departure_date" class="border px-3 py-2 rounded text-sm"
                   value="{{ $flight->departure_time->format('Y-m-d') }}" />
        </div>

        <div class="flex flex-col">
            <label for="arrival_date" class="text-gray-700 font-semibold mb-1">Arrival Date</label>
            <input type="date" id="arrival_date" class="border px-3 py-2 rounded text-sm"
                   value="{{ $flight->arrival_time->format('Y-m-d') }}" />
        </div>
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

