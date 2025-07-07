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

    <x-form-label-date id="departure_date" label="Departure Date" />
    <x-form-label-date id="arrival_date" label="Arrival Date" />

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
    </button>
</div>
