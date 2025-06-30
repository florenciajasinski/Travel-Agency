

<div class="grid grid-cols-1 gap-3 md:grid-cols-2">
    <select id="{{ $originId }}" class="border px-3 py-2 rounded text-sm">
        <option value="">Select Origin</option>
    </select>
    <select id="{{ $destinationId }}" class="border px-3 py-2 rounded text-sm">
        <option value="">Select Destination</option>
    </select>
    <select id="{{ $airlineId }}" class="border px-3 py-2 rounded text-sm">
        <option value="">Select Airline</option>
    </select>
    <input type="date" id="departure_date" class="border px-3 py-2 rounded text-sm" />
    <input type="date" id="arrival_date" class="border px-3 py-2 rounded text-sm" />
</div>

<div class="mt-4 flex justify-end gap-3">
    <button id="{{ $buttonId }}" class="px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700">
        {{ $buttonText }}
    </button>
</div>
