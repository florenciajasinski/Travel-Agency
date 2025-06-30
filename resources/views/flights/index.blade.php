<x-flight-layout title="Flights" heading="Flight Management">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <button
                id="add_flight_btn"
                class="px-4 py-2 rounded text-sm font-medium bg-green-600 text-white hover:bg-green-700"
            >
                Add Flight
            </button>
        </div>

        <div id="create_flight_form" class="hidden mb-6">
            <x-flight-create-form
                originId="origin_city"
                destinationId="destination_city"
                airlineId="airline"
                buttonId="save_flight_btn"
                buttonText="Save Flight"
            />
            <div id="flight_form_error" class="text-red-600 text-sm mt-2"></div>
        </div>

        <x-flight-table/>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let cities = [];
        let airlines = [];

        document.addEventListener('DOMContentLoaded', () => {
            loadAirlines();
            loadFlights();

            document.getElementById('add_flight_btn').addEventListener('click', () => {
                document.getElementById('create_flight_form').classList.toggle('hidden');
            });

            document.getElementById('airline').addEventListener('change', loadCitiesByAirline);
            document.getElementById('origin_city').addEventListener('change', updateDestinations);
            document.getElementById('save_flight_btn').addEventListener('click', createFlight);
        });

        function loadAirlines() {
            axios.get('/api/airlines').then(res => {
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
            const originSelect = document.getElementById('origin_select');
            const destinationSelect = document.getElementById('destination_select');

            if (!airlineId) {
                originSelect.classList.add('hidden');
                destinationSelect.classList.add('hidden');
                return;
            }

            axios.get(`/api/airlines/${airlineId}/cities`).then(res => {
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
            const dest = document.getElementById('destination_city');
            dest.innerHTML = '<option value="">Select Destination</option>';

            cities.filter(c => c.id != originId).forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.name;
                dest.appendChild(option);
            });
        }

        function createFlight() {
            const errorMessage = document.getElementById('flight_form_error');
            const departureCity = document.getElementById('origin_city').value;
            const arrivalCity = document.getElementById('destination_city').value;
            const airline = document.getElementById('airline').value;
            const departureTime = document.getElementById('departure_date').value;
            const arrivalTime = document.getElementById('arrival_date').value;

            errorMessage.textContent = '';

            axios.post('/api/flights', {
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
                document.getElementById('origin_city').value = '';
                document.getElementById('destination_city').value = '';
                document.getElementById('airline').value = '';
                document.getElementById('departure_date').value = '';
                document.getElementById('arrival_date').value = '';
                document.getElementById('create_flight_form').classList.add('hidden');
                document.getElementById('flight_form_error').textContent = '';
                loadFlights();
            })
            .catch(function (err) {
                const errorMessage = document.getElementById('flight_form_error');
                if (err.response?.status === 422) {
                    if (err.response?.data?.error?.fields) {
                        errorMessage.textContent = Object.values(err.response.data.error.fields);
                    }
                }
            });
        }

        function loadFlights() {
            axios.get('/api/flights').then(res => {
                const tbody = document.getElementById('flight_table_body');
                const template = document.getElementById('flight_row_template');

                const rows = tbody.querySelectorAll('tr');
                for (const row of rows) {
                    if (row.id !== 'flight_row_template') {
                        row.remove();
                    }
                }
                res.data.data.forEach(flight => {
                    const row = template.cloneNode(true);
                    row.id = '';
                    row.classList.remove('hidden');

                    row.querySelector('.id-cell').textContent = flight.id;
                    row.querySelector('.origin-cell').textContent = flight.departure_city_name;
                    row.querySelector('.destination-cell').textContent = flight.arrival_city_name;
                    row.querySelector('.airline-cell').textContent = flight.airline_name;
                    row.querySelector('.departure-cell').textContent = formatDate(flight.departure_time);
                    row.querySelector('.arrival-cell').textContent = formatDate(flight.arrival_time);

                    const deleteBtn = row.querySelector('.delete-btn');
                    deleteBtn.addEventListener('click', () => deleteFlight(flight.id));

                    const editBtn = row.querySelector('.edit-btn');
                    editBtn.addEventListener('click', () => {
                        window.location.href = `/flights/${flight.id}/edit`;
                    });

                    tbody.appendChild(row);
                });
            });
        }

        function deleteFlight(id) {
            if (!confirm('Are you sure you want to delete this flight?')) return;
            axios.delete(`/api/flights/${id}`).then(() => {
                loadFlights();
            }).catch(error => {
                document.getElementById('flight_form_error').textContent = error.message;
            });
        }

        function formatDate(datetime) {
            if (!datetime) return '';

            const date = new Date(datetime);

            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            const day = date.getDate();

            return (year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day));
        }
    </script>
</x-flight-layout>
