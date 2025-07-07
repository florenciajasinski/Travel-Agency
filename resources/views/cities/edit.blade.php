<x-flight-layout title="Edit City" heading="Edit City">
    <x-city-edit-form :city="$city" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const cityId = {{ $city->id }};
        const HTTP_METHODS = {
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
            $.ajax({
            url: '/api/airlines',
            method: HTTP_METHODS.GET,
            success: function(response) {
                const airlines = response.data;
                $.ajax({
                url: `/api/cities/${cityId}/airlines`,
                method: HTTP_METHODS.GET,
                success: function(cityResponse) {
                    const selectedAirlines = cityResponse.data.map(airline => Number(airline.id));
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
                airlineIds.push(parseInt($(this).val()));
            });

            $.ajax({
                url: `/api/cities/${cityId}`,
                method: HTTP_METHODS.PUT,
                contentType: 'application/json',
                data: JSON.stringify({
                    name: name,
                    airline_id: airlineIds
                }),
                success: function () {
                    $('#edit_city_error').addClass('hidden').html('');
                    window.location.href = '/cities';
                },
                error: function (xhr) {
                    const fields = xhr.responseJSON?.error?.fields;
                    const message = xhr.responseJSON?.error?.message;

                    if (fields) {
                        let errorList = '<ul>';
                        Object.values(fields).forEach(errors => {
                            if (Array.isArray(errors)) {
                                errors.forEach(msg => {
                                    errorList += `<li>${msg}</li>`;
                                });
                            }
                        });
                        errorList += '</ul>';
                        $('#edit_city_error').removeClass('hidden').html(errorList);
                    } else {
                        $('#edit_city_error').removeClass('hidden').text(message);
                    }
                }
            });
        }

    </script>
</x-flight-layout>
