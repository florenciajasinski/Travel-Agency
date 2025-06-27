<x-flight-layout title="Airlines" heading="Airline Management">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-2">
                <select id="city_filter" class="border px-3 py-2 rounded text-sm">
                    <option value="">All Cities</option>
                </select>

                <button id="filter" class="px-4 py-2 rounded text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">Filter</button>
                <button id="add_airline_btn" class="px-4 py-2 rounded text-sm font-medium bg-green-600 text-white hover:bg-green-700">Add airline</button>
            </div>
        </div>

        <div id="create_airline_form" class="hidden mb-6">
            <input type="text" id="new_airline_name" class="border px-3 py-2 rounded text-sm w-full mb-2" />
            <button id="save_airline_btn" class="px-4 py-2 bg-green-600 text-white rounded text-sm">Save</button>
        </div>

        <table class="table-auto w-full bg-white shadow-md rounded text-sm">
            <thead class="bg-gray-100 text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Number of Flights</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="airline_table_body">
                <tr id="airline_row_template" class="hidden">
                    <td class="px-4 py-2 id-cell"></td>
                    <td class="px-4 py-2 name-cell"></td>
                    <td class="px-4 py-2 description-cell"></td>
                    <td class="px-4 py-2 flights-cell"></td>
                    <td class="px-4 py-2">
                        <div class="flex gap-2">
                            <button class="edit-btn text-blue-600 hover:underline">Edit</button>
                            <button class="delete-btn text-red-600 hover:underline">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="pagination" class="mt-4 flex justify-center"></div>



        <script>
            let airlines = [];
            let currentPage = 1;
            let currentFilter = '';
            let currentCityId = '';

            document.addEventListener('DOMContentLoaded', () => {
                loadAirlines();

                document.getElementById('add_airline_btn').addEventListener('click', () => {
                    document.getElementById('create_airline_form').classList.toggle('hidden');
                });

                document.getElementById('save_airline_btn').addEventListener('click', () => {
                    const name = document.getElementById('new_airline_name').value;
                    fetch('/api/airlines', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ name })
                    })
                    .then(res => res.json())
                    .then(() => {
                        document.getElementById('new_airline_name').value = '';
                        document.getElementById('create_airline_form').classList.add('hidden');
                        loadAirlines();
                    });
                });

                document.getElementById('filter').addEventListener('click', () => {
                    currentCityId = document.getElementById('city_filter').value;
                    currentPage = 1;
                    loadAirlines();
                });
            });

            function loadAirlines(page = 1) {
                if (currentCityId) {
                    fetch(`api/cities/${currentCityId}/airlines`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(response => {
                        airlines = response.data;
                        renderTable();
                    })
                    .catch(error => console.error('Error loading airlines:', error));
                } else {

                fetch('api/airlines', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(response => {
                    airlines = response.data;
                    renderTable();
                    renderPagination(response.meta);
                })
                .catch(error => console.error('Error loading airlines:', error));
                }
            }
            function renderTable() {
    const tbody = document.getElementById('airline_table_body');
    const template = document.getElementById('airline_row_template');
    tbody.innerHTML = '';

    airlines.forEach(airline => {
        const row = template.cloneNode(true);
        row.id = '';
        row.classList.remove('hidden');

        row.querySelector('.id-cell').textContent = airline.id;
        row.querySelector('.name-cell').textContent = airline.name;
        row.querySelector('.description-cell').textContent = airline.description;
        row.querySelector('.flights-cell').textContent = airline.flights_count;

        row.querySelector('.delete-btn').addEventListener('click', () => {
            fetch(`/api/airlines/${airline.id}`, {
                method: 'DELETE',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(() => loadAirlines(currentPage));
        });

        row.querySelector('.edit-btn').addEventListener('click', () => {
            const newName = prompt('New name:', airline.name);
            if (!newName) return;

            fetch(`/api/airlines/${airline.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ name: newName })
            })
            .then(() => loadAirlines(currentPage));
        });

        tbody.appendChild(row);
    });
}


            function renderPagination(meta) {
                const container = document.getElementById('pagination');
                container.innerHTML = '';

                for (let i = 1; i <= meta.last_page; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    btn.className = `px-2 py-1 mx-1 border rounded ${i === meta.current_page ? 'bg-blue-500 text-white' : ''}`;
                    btn.addEventListener('click', () => {
                        currentPage = i;
                        loadAirlines(i);
                    });
                    container.appendChild(btn);
                }
            }
        </script>
    </x-flight-layout>
