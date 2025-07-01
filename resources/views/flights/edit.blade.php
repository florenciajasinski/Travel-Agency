<x-flight-layout title="Edit Flight" heading="Edit Flight">
    <div class="max-w-4xl mx-auto">
        <x-flight-create-form
            originId="origin_city"
            destinationId="destination_city"
            airlineId="airline"
            buttonId="update_flight_btn"
            buttonText="Update Flight"
        />
        <div id="flight_form_error" class="text-red-600 text-sm mt-2"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const flightId = {{ $flightId }};
        let cities = [];
        let airlines = [];

        document.addEventListener('DOMContentLoaded', () => {
            loadAirlines();
            loadFlightData();

            const airlineSelect = document.getElementById('airline');
            const originSelect = document.getElementById('origin_city');
            const updateBtn = document.getElementById('save_flight_btn');

            airlineSelect.addEventListener('change', loadCitiesByAirline);
            originSelect.addEventListener('change', updateDestinations);
            updateBtn.addEventListener('click', updateFlight);
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
                    select.appendChild(option);
                });
            });
        }

        function loadCitiesByAirline() {
            const airlineId = document.getElementById('airline').value;
            const originId = document.getElementById('origin_city').value;
            const destinationId = document.getElementById('destination_city').value;
            const originSelect = document.getElementById('origin_select');
            const destinationSelect = document.getElementById('destination_select');

            if (!airlineId) {
                originSelect.classList.add('hidden');
                destinationSelect.classList.add('hidden');
            }

            return axios.get(`/api/airlines/${airlineId}/cities`).then(res => {
                cities = res.data.data;
                const origin = document.getElementById('origin_city');
                origin.innerHTML = '<option value="">Select Origin</option>';
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
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
            .catch(err => {
                if (err.response?.status === 422 && err.response?.data?.error?.fields) {
                    const firstErrorList = Object.values(err.response.data.error.fields)[0];
                    if (Array.isArray(firstErrorList)) {
                        errorMessage.textContent = firstErrorList[0];
                        return;
                    }
                }
                errorMessage.textContent = err.message;
            });
        }
    </script>
</x-flight-layout>
