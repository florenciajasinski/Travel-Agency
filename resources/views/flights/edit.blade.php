<x-flight-layout title="Edit Flight" heading="Edit Flight">
    <div class="max-w-4xl mx-auto">
        <x-flight-create-form
            originId="origin_city"
            destinationId="destination_city"
            airlineId="airline"
            buttonId="save_flight_btn"
            buttonText="Update Flight"
            :flight="$flight"
        />
        <div id="flight_form_error" class="text-red-600 text-sm mt-2"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const flightId = {{ $flight->id }};
        let cities = [];
        let airlines = [];

        document.addEventListener('DOMContentLoaded', () => {
            loadAirlines();
            loadFlightData();

            const airlineSelect = document.getElementById('airline');
            const originSelect = document.getElementById('origin_city');
            const updateBtn = document.getElementById('save_flight_btn');
            const cancelBtn = document.getElementById('cancel_flight_btn');

            airlineSelect.addEventListener('change', loadCitiesByAirline);
            originSelect.addEventListener('change', updateDestinations);
            updateBtn.addEventListener('click', updateFlight);
            cancelBtn.addEventListener('click', () => {
                document.getElementById('flight_form_error').textContent = '';
                window.location.href = '/flights';
            });
        });

        function loadAirlines() {
            return axios.get('/api/airlines').then(res => {
            airlines = res.data.data;
            const select = document.getElementById('airline');
            select.innerHTML = '<option value="">Select Airline</option>';
            airlines.forEach(airline => {
                const option = document.createElement('option');
                option.value = airline.id;
                option.textContent = airline.name;
                if (airline.id == {{ $flight->airline_id }}) {
                option.selected = true;
                }
                select.appendChild(option);
            });
            });
        }

        function loadCitiesByAirline() {
            const airlineId = document.getElementById('airline').value || {{ $flight->airline_id }};
            const originSelect = document.getElementById('origin_select');
            const destinationSelect = document.getElementById('destination_select');

            if (!airlineId) {
            originSelect.classList.add('hidden');
            destinationSelect.classList.add('hidden');
            return;
            }

            return axios.get(`/api/airlines/${airlineId}/cities`).then(res => {
            cities = res.data.data;
            const origin = document.getElementById('origin_city');
            origin.innerHTML = '<option value="">Select Origin</option>';
            cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.name;
                if (city.id == {{ $flight->departure_city_id }}) {
                option.selected = true;
                }
                origin.appendChild(option);
            });
            updateDestinations();
            originSelect.classList.remove('hidden');
            destinationSelect.classList.remove('hidden');
            });
        }

        function updateDestinations() {
            const originId = document.getElementById('origin_city').value;
            const destination = document.getElementById('destination_city');
            destination.innerHTML = '<option value="">Select Destination</option>';
            cities.filter(city => city.id != originId).forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.name;
                if (city.id == {{ $flight->arrival_city_id }}) {
                    option.selected = true;
                }
                destination.appendChild(option);
            });
        }

        function loadFlightData() {
            axios.get(`/api/flights/${flightId}`).then(res => {
                const flight = res.data.data;
                loadCitiesByAirline();
            });
        }

        function updateFlight() {
            const errorMessage = document.getElementById('flight_form_error');
            const departureCity = document.getElementById('origin_city').value;
            const arrivalCity = document.getElementById('destination_city').value;
            const airline = document.getElementById('airline').value;
            const departureTime = document.getElementById('departure_date').value;
            const arrivalTime = document.getElementById('arrival_date').value;

            errorMessage.textContent = '';
            errorMessage.innerHTML = '';

            axios.put(`/api/flights/${flightId}`, {
            departure_city_id: departureCity,
            arrival_city_id: arrivalCity,
            airline_id: airline,
            departure_time: departureTime,
            arrival_time: arrivalTime
            })
            .then(res => {
            if (res.data.status === 'error') {
                errorMessage.textContent = res.data.message;
                return;
            }
            window.location.href = '/flights';
            })
            .catch(({ response }) => {
            if (response?.status === 422 && response?.data?.error?.fields) {
                const fields = response.data.error.fields;
                let errorList = '<ul class="pl-5">';
                Object.values(fields).forEach(errors => {
                    if (Array.isArray(errors)) {
                        errors.forEach(message => {
                            errorList += `<li style="list-style-type:none;">${message}</li>`;
                        });
                    }
                });
                errorList += '</ul>';
                errorMessage.innerHTML = errorList;
                return;
            }
            errorMessage.textContent = response?.data?.message;
            });
        }
    </script>
</x-flight-layout>
