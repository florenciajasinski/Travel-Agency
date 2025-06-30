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
        <input type="date" id="departure_date" class="border px-3 py-2 rounded text-sm" />
    </div>

    <div class="flex flex-col">
        <label for="arrival_date" class="text-gray-700 font-semibold mb-1">Arrival Date</label>
        <input type="date" id="arrival_date" class="border px-3 py-2 rounded text-sm" />
    </div>
</div>

<div class="mt-4 flex justify-end gap-3">
    <button id="save_flight_btn" class="px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700">
        Save
    </button>
</div>
