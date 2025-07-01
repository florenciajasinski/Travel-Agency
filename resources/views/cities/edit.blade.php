<x-flight-layout title="Edit City" heading="Edit City">
    <div class="max-w-lg mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col">
            <label for="name" class="text-gray-700 font-semibold mb-1">Name</label>
            <input type="text" id="name" name="name" class="border px-3 py-2 rounded text-sm mb-4" placeholder="Enter city name">
        </div>
        <div class="flex flex-col">
            <label for="airline" class="text-gray-700 font-semibold mb-1">Airline</label>
            <select id="airline" class="border px-3 py-2 rounded text-sm">
                <option value="">Select Airline</option>
            </select>
        </div>
        <button type="button" class="bg-green-500 text-white px-4 py-2 rounded save-edit-btn">Save</button>
        <button type="button" class="bg-gray-300 px-4 py-2 rounded cancel-edit-btn">Cancel</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            loadAirlines();
        });
        function loadAirlines() {
            $.ajax({
                url: '/api/airlines',
                method: 'GET',
                success: function(data) {
                    const select = $('#airline');
                    select.empty();
                    select.append('<option value="">Select Airline</option>');
                    (data.data || data).forEach(airline => {
                        const option = $('<option></option>').val(airline.id).text(airline.name);
                        select.append(option);
                    });
                }
            });
        }
    </script>
</x-flight-layout>
