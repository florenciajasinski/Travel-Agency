<x-flight-layout title="Edit City" heading="Edit City">
    <div class="max-w-lg mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col col-span-2">
            <label for="name" class="text-gray-700 font-semibold mb-1">Name</label>
            <input type="text" id="name" name="name" class="border px-3 py-2 rounded text-sm mb-4" value="{{ $city->name }}">
        </div>

        <div class="flex flex-col col-span-2">
            <label class="text-gray-700 font-semibold mb-2">Airlines</label>
            <div id="airline-checkboxes" class="grid grid-cols-2 gap-2">
                <!-- checkboxes dinámicos -->
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

            $.get(`/api/cities/${cityId}/airlines`, function(response) {
                selectedAirlines = response.airline_ids || [];

                $.get('/api/airlines', function(data) {
                    const container = $('#airline-checkboxes');
                    container.empty();

                    (data.data || data).forEach(airline => {
                        const isChecked = selectedAirlines.includes(airline.id) ? 'checked' : '';
                        const checkbox = $(`
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="airline_id[]" value="${airline.id}" class="form-checkbox" ${isChecked}>
                                <span>${airline.name}</span>
                            </label>
                        `);
                        container.append(checkbox);
                    });
                });
            });
        }

        function updateCity(cityId) {
            const name = $('#name').val();
            const airlineIds = $('input[name="airline_id[]"]:checked')
                .map(function () {
                    return parseInt($(this).val());
                })
                .get();
            $.ajax({
                url: `/api/cities/${cityId}`,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify({ name }),
                success: function () {
                    $.ajax({
                        url: `/api/cities/${cityId}/airlines`,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({ airline_id: airlineIds }),
                        success: function () {
                            $('#edit_city_error').addClass('hidden');
                            window.location.href = '/cities';
                        },
                        error: function (xhr) {
                            const message = xhr.responseJSON?.message || 'Error saving airlines';
                            $('#edit_city_error').text(message).removeClass('hidden');
                        }
                    });
                },
                error: function (xhr) {
                    const message = xhr.responseJSON?.message || 'Error saving city';
                    $('#edit_city_error').text(message).removeClass('hidden');
                }
            });
        }
    </script>
</x-flight-layout>
