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
    loadAirlines().then(() => loadFlightData());

    // Check if elements exist before adding event listeners
    const airlineSelect = document.getElementById('airline');
    const originSelect = document.getElementById('origin_city');
    const updateBtn = document.getElementById('update_flight_btn');

    if (airlineSelect) {
        airlineSelect.addEventListener('change', loadCitiesByAirline, (event => {
            const airlineId = event.target.value;
            loadCitiesByAirline(airlineId);
        }));
    }
    if (originSelect) {
        originSelect.addEventListener('change', updateDestinations);
    }
    if (updateBtn) {
        updateBtn.addEventListener('click', updateFlight);
    }
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

function loadCitiesByAirline(airlineId = null, originId = null, destinationId = null) {
    const id = airlineId || document.getElementById('airline').value;
    const originSelect = document.getElementById('origin_select');
    const destinationSelect = document.getElementById('destination_select');

    if (!id) {
        originSelect.classList.add('hidden');
        destinationSelect.classList.add('hidden');
        return Promise.resolve(); // Return a resolved promise for consistency
    }

    return axios.get(`/api/airlines/${id}/cities`).then(res => {
        cities = res.data.data;
        const origin = document.getElementById('origin_city');
        origin.innerHTML = '<option value="">Select Origin</option>';
        cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.id;
            option.textContent = city.name;
            origin.appendChild(option);
        });
        if (originId) origin.value = originId;

        updateDestinations(destinationId);
        originSelect.classList.remove('hidden');
        destinationSelect.classList.remove('hidden');
    });
}

function updateDestinations(preselectId = null) {
    const originId = document.getElementById('origin_city').value;
    const dest = document.getElementById('destination_city');
    dest.innerHTML = '<option value="">Select Destination</option>';
    cities.filter(c => c.id != originId).forEach(city => {
        const option = document.createElement('option');
        option.value = city.id;
        option.textContent = city.name;
        dest.appendChild(option);
    });
    if (preselectId) dest.value = preselectId;
}

function loadFlightData() {
    axios.get(`/api/flights/${flightId}`).then(res => {
        const flight = res.data.data;
        document.getElementById('airline').value = flight.airline_id;
        document.getElementById('departure_date').value = flight.departure_time;
        document.getElementById('arrival_date').value = flight.arrival_time;

        // Load cities and then set the selected values
        loadCitiesByAirline(flight.airline_id, flight.departure_city_id, flight.arrival_city_id);
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
