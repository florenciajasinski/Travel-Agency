@props(['flight'])

<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col">
            <label for="airline" class="text-gray-700 font-semibold mb-1">Airline</label>
            <select id="airline" class="border px-3 py-2 rounded text-sm">
                <option value="">Select Airline</option>
            </select>
        </div>

        <div class="flex flex-col hidden" id="origin_select">
            <label for="origin_city" class="text-gray-700 font-semibold mb-1">Origin</label>
            <select id="origin_city" class="border px-3 py-2 rounded text-sm">
                <option value="">Select Origin</option>
            </select>
        </div>

        <div class="flex flex-col hidden" id="destination_select">
            <label for="destination_city" class="text-gray-700 font-semibold mb-1">Destination</label>
            <select id="destination_city" class="border px-3 py-2 rounded text-sm">
                <option value="">Select Destination</option>
            </select>
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

