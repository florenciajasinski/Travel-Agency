<x-flight-layout title="Flights" heading="Flight Management">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <button id="add_flight_btn" class="px-4 py-2 rounded text-sm font-medium bg-green-600 text-white hover:bg-green-700">
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

        <table class="table-auto w-full bg-white shadow-md rounded text-sm">
            <thead class="bg-gray-100 text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Origin</th>
                    <th class="px-4 py-2">Destination</th>
                    <th class="px-4 py-2">Airline</th>
                    <th class="px-4 py-2">Departure</th>
                    <th class="px-4 py-2">Arrival</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="flight_table_body"></tbody>
        </table>
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
        document.getElementById('departure_date').addEventListener('change', validateDates);
        document.getElementById('arrival_date').addEventListener('change', validateDates);
        document.getElementById('save_flight_btn').addEventListener('click', createFlight);
    });

    function loadAirlines() {
        axios.get('/api/airlines').then(res => {
            airlines = res.data.data;
            const select = document.getElementById('airline');
            select.innerHTML = '<option value="">Select Airline</option>';
            airlines.forEach(a => {
                const opt = new Option(a.name, a.id);
                select.appendChild(opt);
            });
        });
    }

    function loadCitiesByAirline() {
    const airlineId = document.getElementById('airline').value;
    const originWrapper = document.getElementById('origin_wrapper');
    const destinationWrapper = document.getElementById('destination_wrapper');

    if (!airlineId) {
        originWrapper.classList.add('hidden');
        destinationWrapper.classList.add('hidden');
        return;
    }

    axios.get(`/api/airlines/${airlineId}/cities`).then(res => {
        cities = res.data.data;

        const origin = document.getElementById('origin_city');
        origin.innerHTML = '<option value="">Select Origin</option>';
        cities.forEach(c => origin.appendChild(new Option(c.name, c.id)));

        updateDestinations();
        originWrapper.classList.remove('hidden');
        destinationWrapper.classList.remove('hidden');
    });
}



    function updateDestinations() {
        const originId = document.getElementById('origin_city').value;
        const dest = document.getElementById('destination_city');
        dest.innerHTML = '<option value="">Select Destination</option>';

        cities.filter(c => c.id != originId).forEach(c => {
            dest.appendChild(new Option(c.name, c.id));
        });
    }

    function validateDates() {
        const dep = document.getElementById('departure_date');
        const arr = document.getElementById('arrival_date');
        arr.min = dep.value;
        dep.max = arr.value;
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
    .catch(error => {
    console.error('Error creating flight:', error);
    console.log('Response data:', error.response.data);

    const errorMessage = document.getElementById('flight_form_error');
    if (error.response?.data?.message) {
        errorMessage.textContent = error.response.data.message;
    } else if (error.response?.data?.errors) {
        const firstError = Object.values(error.response.data.errors)[0];
        errorMessage.textContent = firstError;
    } else {
        errorMessage.textContent = 'Unexpected error';
    }
});

}


    function loadFlights() {
        axios.get('/api/flights').then(res => {
            const tbody = document.getElementById('flight_table_body');
            tbody.innerHTML = '';
            res.data.data.forEach(flight => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-2">${flight.id}</td>
                    <td class="px-4 py-2">${flight.departure_city_name}</td>
                    <td class="px-4 py-2">${flight.arrival_city_name}</td>
                    <td class="px-4 py-2">${flight.airline_name}</td>
                    <td class="px-4 py-2">${flight.departure_time}</td>
                    <td class="px-4 py-2">${flight.arrival_time}</td>
                    <td class="px-4 py-2">
                        <button onclick="deleteFlight(${flight.id})" class="text-red-600 hover:underline">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
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
</script>
</x-flight-layout>
