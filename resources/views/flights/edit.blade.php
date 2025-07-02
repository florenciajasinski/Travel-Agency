<x-flight-layout title="Edit Flight" heading="Edit Flight">
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
                <input type="date" id="departure_date" class="border px-3 py-2 rounded text-sm" value="{{ $flight->departure_time->format('Y-m-d') }}" />
            </div>

            <div class="flex flex-col">
                <label for="arrival_date" class="text-gray-700 font-semibold mb-1">Arrival Date</label>
                <input type="date" id="arrival_date" class="border px-3 py-2 rounded text-sm" value="{{ $flight->arrival_time->format('Y-m-d') }}" />
            </div>
        </div>

        <div class="mt-4 flex justify-end gap-3">
            <button id="save_flight_btn" class="px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                Save
            </button>
            <button id="cancel_flight_btn" class="px-4 py-2 bg-gray-300 text-gray-800 rounded text-sm hover:bg-gray-400">
                Cancel
            </button>
        </div>

        <div id="flight_form_error" class="text-red-600 text-sm mt-2"></div>
    </div>
</x-flight-layout>

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
