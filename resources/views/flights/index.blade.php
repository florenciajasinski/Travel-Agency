<x-flight-layout title="Flights" heading="Flight Management">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <x-button
                id="add_flight_btn"
                button="Add Flight"
            />
        </div>

        <div id="create_flight_form" class="hidden mb-6">
            <x-flight-create-form
                originId="origin_city"
                destinationId="destination_city"
                airlineId="airline"
                buttonId="save_flight_btn"
                buttonCancelId="cancel_flight_btn"
                buttonText="Save Flight"
            />
            <x-error
                id="flight_form_error"
            />
        </div>

        <x-flight-table/>

    </div>
    <x-pagination/>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        let cities = [];
        let airlines = [];
        let currentPage = 1;

        document.addEventListener('DOMContentLoaded', () => {
            loadAirlines();
            loadFlights(currentPage);

            document.getElementById('add_flight_btn').addEventListener('click', toggleCreateFlightForm);
            document.getElementById('airline').addEventListener('change', loadCitiesByAirline);
            document.getElementById('origin_city').addEventListener('change', updateDestinations);
            document.getElementById('save_flight_btn').addEventListener('click', createFlight);
            document.getElementById('cancel_flight_btn').addEventListener('click', cancelCreateFlightForm);
        });

        function toggleCreateFlightForm() {
            document.getElementById('create_flight_form').classList.toggle('hidden');
        }

        function cancelCreateFlightForm() {
            document.getElementById('create_flight_form').classList.add('hidden');
            document.getElementById('flight_form_error').textContent = '';
        }

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
            const destination = document.getElementById('destination_city');
            destination.innerHTML = '<option value="">Select Destination</option>';

            cities.filter(city => city.id != originId).forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.name;
                destination.appendChild(option);
            });
        }

        function createFlight() {
            const errorMessage = document.getElementById('flight_form_error');
            const departureCityId = document.getElementById('origin_city').value;
            const arrivalCityId = document.getElementById('destination_city').value;
            const airlineId = document.getElementById('airline').value;
            const departureTime = document.getElementById('departure_date').value;
            const arrivalTime = document.getElementById('arrival_date').value;

            errorMessage.textContent = '';

            axios.post('/api/flights', {
            departure_city_id: departureCityId,
            arrival_city_id: arrivalCityId,
            airline_id: airlineId,
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
            loadFlights(currentPage);
            })
            .catch(({ response }) => {
            if (response?.status === 422 && response?.data?.error?.fields) {
                const fields = response.data.error.fields;
                let errorList = '<ul>';
                Object.values(fields).forEach(errors => {
                if (Array.isArray(errors)) {
                    errors.forEach(message => {
                    errorList += `<li>${message}</li>`;
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

        function loadFlights(page = 1) {
            currentPage = page;
            axios.get(`/api/flights?page=${currentPage}`).then(res => {
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
                    row.querySelector('.origin-cell').textContent = flight.departure_city.name;
                    row.querySelector('.destination-cell').textContent = flight.arrival_city.name;
                    row.querySelector('.airline-cell').textContent = flight.airline.name;
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
                renderPagination(res.data.meta);
            });
        }

        function deleteFlight(id) {
            if (!confirm('Are you sure you want to delete this flight?')) return;
            axios.delete(`/api/flights/${id}`).then(() => {
                loadFlights(currentPage);
            }).catch(error => {
                document.getElementById('flight_form_error').textContent = error.message;
            });
        }

        function formatDate(datetime) {
            const date = new Date(datetime);
            return date.toDateString();
        }

        function renderPagination(meta) {
            const container = document.getElementById('pagination');
            container.innerHTML = '';

            for (let i = 1; i <= meta.last_page; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = `px-2 py-1 mx-1 border rounded`;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    loadAirlines(i);
                });
                container.appendChild(btn);
            }
        }
    </script>
</x-flight-layout>
