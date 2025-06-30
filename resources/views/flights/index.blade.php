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
    initFlightForm();
    loadAirlines();
    loadFlights();
});

function initFlightForm() {
    document.getElementById('add_flight_btn').addEventListener('click', FlightForm);
    document.getElementById('airline').addEventListener('change', loadCitiesByAirline);
    document.getElementById('origin_city').addEventListener('change', updateDestinations);
    document.getElementById('save_flight_btn').addEventListener('click', createFlight);
}

function FlightForm() {
    document.getElementById('create_flight_form').classList.toggle('hidden');
}

function showError(message) {
    const errorMessage = document.getElementById('flight_form_error');
    errorMessage.textContent = message;
}

function clearFlightForm() {
    document.getElementById('origin_city').value = '';
    document.getElementById('destination_city').value = '';
    document.getElementById('airline').value = '';
    document.getElementById('departure_date').value = '';
    document.getElementById('arrival_date').value = '';
    document.getElementById('flight_form_error').textContent = '';
    document.getElementById('create_flight_form').classList.add('hidden');
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
    const originSelect = document.getElementById('origin_city');
    const destinationSelect = document.getElementById('destination_city');

    if (!airlineId) {
        originSelect.classList.add('hidden');
        destinationSelect.classList.add('hidden');
        return;
    }

    axios.get(`/api/airlines/${airlineId}/cities`).then(res => {
        cities = res.data.data;
        citySelect('origin_city', cities);
        updateDestinations();
        originSelect.classList.remove('hidden');
        destinationSelect.classList.remove('hidden');
    });
}

function citySelect(selectId, citiesList) {
    const selectElement = document.getElementById(selectId);
    let defaultText = 'Select City';
    if (selectId === 'origin_city') {
        defaultText = 'Select Origin';
    } else if (selectId === 'destination_city') {
        defaultText = 'Select Destination';
    }

    selectElement.innerHTML = '<option value="">' + defaultText + '</option>';

    for (let i = 0; i < citiesList.length; i++) {
        const city = citiesList[i];
        const option = document.createElement('option');
        option.value = city.id;
        option.textContent = city.name;
        selectElement.appendChild(option);
    }
}

function updateDestinations() {
    const originSelect = document.getElementById('origin_city');
    const selectedOriginId = originSelect.value;

    const destinationCities = [];
    for (let i = 0; i < cities.length; i++) {
        if (cities[i].id !== selectedOriginId) {
            destinationCities.push(cities[i]);
        }
    }
    citySelect('destination_city', destinationCities);
}


function createFlight() {
    const departureCity = document.getElementById('origin_city').value;
    const arrivalCity = document.getElementById('destination_city').value;
    const airline = document.getElementById('airline').value;
    const departureTime = document.getElementById('departure_date').value;
    const arrivalTime = document.getElementById('arrival_date').value;

    showError('');

    axios.post('/api/flights', {
        departure_city_id: departureCity,
        arrival_city_id: arrivalCity,
        airline_id: airline,
        departure_time: departureTime,
        arrival_time: arrivalTime
    })
    .then(res => {
        if (res.data.error && res.data.error.fields) {
            const fields = res.data.error.fields;
            const message = Object.values(fields).join(', ');
            showError(message);
            return;
        }
        clearFlightForm();
        loadFlights();
    })
    .catch(error => {
        showError(error.response.data.error.message);
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
        showError(error.message);
    });
}
</script>

</x-flight-layout>
