<x-flight-layout title="Edit City" heading="Edit City">
    <div class="max-w-lg mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col col-span-2">
            <label for="name" class="text-gray-700 font-semibold mb-1">Name</label>
            <input type="text" id="name" name="name" class="border px-3 py-2 rounded text-sm mb-4" value="{{ $city->name }}">
        </div>

        <div class="flex flex-col col-span-2">
            <label class="text-gray-700 font-semibold mb-2">Airlines</label>
            <div id="airline-checkboxes" class="grid grid-cols-2 gap-2">
            </div>
        </div>

        <div class="col-span-2 flex justify-end gap-2">
            <button type="button" class="bg-green-500 text-white px-4 py-2 rounded save-edit-btn">Save</button>
            <button type="button" class="bg-gray-300 px-4 py-2 rounded cancel-edit-btn">Cancel</button>
        </div>

        <div id="edit_city_error" class="text-red-600 text-sm col-span-2 hidden"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const cityId = {{ $city->id }};
        const HTTP_METHODS = {
            POST: 'POST',
            GET: 'GET',
            PUT: 'PUT',
        };

        $(document).ready(function () {
            loadAirlinesWithChecked(cityId);

            $('.save-edit-btn').on('click', function () {
                updateCity(cityId);
            });

            $('.cancel-edit-btn').on('click', function () {
                window.location.href = '/cities';
            });
        });

        function loadAirlinesWithChecked(cityId) {
            let selectedAirlines = [];

            $.ajax({
                url: `/api/cities/${cityId}/airlines`,
                method: HTTP_METHODS.GET,
                success: function(response) {
                    selectedAirlines = response.data.map(airline => Number(airline.id));
                    $.ajax({
                        url: '/api/airlines',
                        method: HTTP_METHODS.GET,
                        success: function(response) {
                            const airlines = response.data;
                            const container = $('#airline-checkboxes');
                            container.empty();

                            airlines.forEach(function (airline) {
                                const isChecked = selectedAirlines.includes(Number(airline.id)) ? 'checked' : '';

                                const checkbox = $(`
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="airline_id[]" value="${airline.id}" class="form-checkbox" ${isChecked}>
                                        <span>${airline.name}</span>
                                    </label>
                                `);
                                container.append(checkbox);
                            });
                        },
                    });
                },
            });
        }


        function updateCity(cityId) {
            const name = $('#name').val();
            const airlineIds = [];
            $('input[name="airline_id[]"]:checked').each(function () {
                const airlineId = parseInt($(this).val());
                airlineIds.push(airlineId);
            });
            $.ajax({
                url: `/api/cities/${cityId}`,
                method: HTTP_METHODS.PUT,
                contentType: 'application/json',
                data: JSON.stringify({ name }),
                success: function () {
                    $.ajax({
                        url: `/api/cities/${cityId}/airlines`,
                        method: HTTP_METHODS.POST,
                        contentType: 'application/json',
                        data: JSON.stringify({ airline_id: airlineIds }),
                        success: function () {
                            $('#edit_city_error').addClass('hidden');
                            window.location.href = '/cities';
                        },
                        error: function (xhr) {
                            const message = xhr.responseJSON?.error?.message;
                            $('#edit_city_error').text(message).removeClass('hidden');
                        }
                    });
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.error?.message;
                    $('#edit_city_error').text(message).removeClass('hidden');
                }
            });
        }
    </script>
</x-flight-layout>
