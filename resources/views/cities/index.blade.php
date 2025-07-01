<x-flight-layout title="Cities" heading="City Management">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-2">
                <select id="airline_filter" class="border px-3 py-2 rounded text-sm">
                    <option value="">All Airlines</option>
                </select>

                <button id="filter" class="px-4 py-2 rounded text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">Filter</button>
                <button id="add_city_btn" class="px-4 py-2 rounded text-sm font-medium bg-green-600 text-white hover:bg-green-700">Add City</button>
            </div>
        </div>

        <div id="create_city_form" class="hidden mb-6">
            <input type="text" id="new_city_name" class="border px-3 py-2 rounded text-sm w-full mb-2" />
            <button id="save_city_btn" class="px-4 py-2 bg-green-600 text-white rounded text-sm">Save</button>
            <div id="error_message" class="text-red-600 mt-2 hidden"></div>
        </div>

        <table class="table-auto w-full bg-white shadow-md rounded text-sm">
            <thead class="bg-gray-100 text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Incoming Flights</th>
                    <th class="px-4 py-2">Outgoing Flights</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="city_table_body"></tbody>
        </table>
    </div>

    <div id="pagination" class="mt-4 flex justify-center"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</x-flight-layout>
