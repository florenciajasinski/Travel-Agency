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
    <div id="toast" class="hidden fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow"></div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    let cities = [];
    let airlines = [];

    document.addEventListener('DOMContentLoaded', () => {
        loadCities();
        loadAirlines();
        loadFlights();

        document.getElementById('add_flight_btn').addEventListener('click', () => {
            document.getElementById('create_flight_form').classList.toggle('hidden');
        });

        document.getElementById('origin_city').addEventListener('change', updateDestinations);
        document.getElementById('departure_date').addEventListener('change', validateDates);
        document.getElementById('arrival_date').addEventListener('change', validateDates);
        document.getElementById('save_flight_btn').addEventListener('click', createFlight);
    });

    function loadCities() {
        axios.get('/api/cities').then(res => {
            cities = res.data.data;
            const origin = document.getElementById('origin_city');
            origin.innerHTML = '<option value="">Select Origin</option>';
            cities.forEach(c => {
                const opt = new Option(c.name, c.id);
                origin.appendChild(opt);
            });
            updateDestinations();
        });
    }

    function updateDestinations() {
        const originId = document.getElementById('origin_city').value;
        const dest = document.getElementById('destination_city');
        dest.innerHTML = '<option value="">Select Destination</option>';
        cities.filter(c => c.id != originId).forEach(c => {
            const opt = new Option(c.name, c.id);
            dest.appendChild(opt);
        });
    }

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

    function validateDates() {
        const dep = document.getElementById('departure_date');
        const arr = document.getElementById('arrival_date');
        arr.min = dep.value;
        dep.max = arr.value;
    }

    function createFlight() {
        const data = {
            departure_city_id: document.getElementById('origin_city').value,
            arrival_city_id: document.getElementById('destination_city').value,
            airline_id: document.getElementById('airline').value,
            departure_time: document.getElementById('departure_date').value,
            arrival_time: document.getElementById('arrival_date').value
        };

        axios.post('/api/flights', data)
            .then(() => {
                showToast('Flight created!', 'success');
                clearForm();
                loadFlights();
            })
            .catch(err => {
                const msg = err.response?.data?.error?.message || 'Failed to create flight.';
                document.getElementById('flight_form_error').textContent = msg;
            });
    }

    function clearForm() {
        ['origin_city', 'destination_city', 'airline', 'departure_date', 'arrival_date']
            .forEach(id => document.getElementById(id).value = '');
        document.getElementById('create_flight_form').classList.add('hidden');
        document.getElementById('flight_form_error').textContent = '';
    }

    function loadFlights() {
        axios.get('/api/flights').then(res => {
            const tbody = document.getElementById('flight_table_body');
            tbody.innerHTML = '';
            res.data.data.forEach(flight => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-2">${flight.id}</td>
                    <td class="px-4 py-2">${flight.departure_city}</td>
                    <td class="px-4 py-2">${flight.arrival_city}</td>
                    <td class="px-4 py-2">${flight.airline?.name}</td>
                    <td class="px-4 py-2">${flight.departure_time}</td>
                    <td class="px-4 py-2">${flight.arrival_time}</td>
                    <td class="px-4 py-2">
                        <button onclick="confirmDelete(${flight.id})" class="text-red-600 hover:underline">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        });
    }

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this flight?')) {
            axios.delete(`/api/flights/${id}`).then(() => {
                showToast('Flight deleted.', 'success');
                loadFlights();
            });
        }
    }

    function showToast(msg, type) {
        const toast = document.getElementById('toast');
        toast.textContent = msg;
        toast.className = `fixed top-4 right-4 px-4 py-2 rounded shadow text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }
</script>

</x-flight-layout>
