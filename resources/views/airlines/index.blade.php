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
            <input type="text" id="new_airline_name" class="border px-3 py-2 rounded text-sm w-full mb-2" placeholder="Name" />
            <input type="text" id="new_airline_description" class="border px-3 py-2 rounded text-sm w-full mb-2" placeholder="Description" />
            <button id="save_airline_btn" class="px-4 py-2 bg-green-600 text-white rounded text-sm">Save</button>
            <div id="airline_form_error" class="text-red-600 text-sm mt-2"></div>
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

                    <td class="px-4 py-2">
                        <span class="name-cell"></span>
                        <input type="text" class="edit-name hidden border px-2 py-1 rounded w-full text-sm" />
                    </td>

                    <td class="px-4 py-2">
                        <span class="description-cell"></span>
                        <textarea class="edit-desc hidden border px-2 py-1 rounded w-full text-sm" rows="3"></textarea>
                    </td>

                    <td class="px-4 py-2 flights-cell"></td>

                    <td class="px-4 py-2">
                        <div class="action-buttons flex gap-2">
                            <button class="edit-btn text-blue-600 hover:underline">Edit</button>
                            <button class="delete-btn text-red-600 hover:underline">Delete</button>
                        </div>
                        <div class="edit-buttons hidden flex gap-2 items-center">
                            <button class="save-btn text-green-600 hover:underline">Save</button>
                            <button class="cancel-btn text-gray-600 hover:underline">Cancel</button>
                            <span class="error-msg text-red-600 text-xs ml-2"></span>
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
        let currentCityId = '';

        document.addEventListener('DOMContentLoaded', () => {
            loadAirlines(currentPage);
            loadCities();

            document.getElementById('add_airline_btn').addEventListener('click', () => {
                document.getElementById('create_airline_form').classList.toggle('hidden');
            });

            document.getElementById('filter').addEventListener('click', () => {
                currentCityId = document.getElementById('city_filter').value;
                currentPage = 1;
                loadAirlines(currentPage);
            });

            document.getElementById('save_airline_btn').addEventListener('click', () => {
                const errorDiv = document.getElementById('airline_form_error');
                const name = document.getElementById('new_airline_name').value;
                const description = document.getElementById('new_airline_description').value;
                errorDiv.textContent = '';

                fetch('/api/airlines', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ name, description })
                })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(({ error }) => {
                            const fields = error?.fields;
                            const message = Object.values(fields);
                            throw new Error(message);
                        });
                    }
                    return res.json();
                })

                .then(() => {
                    document.getElementById('create_airline_form').classList.add('hidden');
                    loadAirlines(currentPage);
                })
                .catch(error => {
                    errorDiv.textContent = error.message;
                });
            });
        });

        function loadAirlines(page = 1) {
            currentPage = page;
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
                .catch(error => alert('Error loading airlines: ' + error));
            } else {
                fetch(`/api/airlines?page=${page}`, {
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
                .catch(error => {
                    alert('Error loading airlines: ' + error);
                });
            }
        }

        function loadCities() {
            fetch('/api/cities', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(response => {
                const cityFilter = document.getElementById('city_filter');
                response.data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
                    cityFilter.appendChild(option);
                });
            })
            .catch(error => alert('Error loading cities: ' + error));
        }

        function renderPagination(meta) {
            if (currentCityId) return;
            const container = document.getElementById('pagination');
            container.innerHTML = '';

            for (let i = 1; i <= meta.last_page; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = `px-2 py-1 mx-1 border rounded ${i === meta.current_page}`;
                btn.addEventListener('click', () => {
                    currentPage = i;
                    loadAirlines(i);
                });
                container.appendChild(btn);
            }
        }
        function renderTable() {
            const tbody = document.getElementById('airline_table_body');
            const template = document.getElementById('airline_row_template');
            const rows = tbody.querySelectorAll('tr');
            for (const row of rows) {
                if (row.id !== 'airline_row_template') {
                    row.remove();
                }
            }

            airlines.forEach(airline => {
                const row = template.cloneNode(true);
                row.id = '';
                row.classList.remove('hidden');

                const idCell = row.querySelector('.id-cell');
                const nameSpan = row.querySelector('.name-cell');
                const nameInput = row.querySelector('.edit-name');
                const descSpan = row.querySelector('.description-cell');
                const descInput = row.querySelector('.edit-desc');
                const flightsCell = row.querySelector('.flights-cell');
                const actionsDiv = row.querySelector('.action-buttons');
                const editActionsDiv = row.querySelector('.edit-buttons');
                const errorMsg = row.querySelector('.error-msg');

                idCell.textContent = airline.id;
                nameSpan.textContent = airline.name;
                nameInput.value = airline.name;
                descSpan.textContent = airline.description;
                descInput.value = airline.description;
                flightsCell.textContent = airline.flights_count;

                row.querySelector('.delete-btn').addEventListener('click', () => {
                    fetch(`/api/airlines/${airline.id}`, {
                        method: 'DELETE',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(() => loadAirlines(currentPage));
                });

                row.querySelector('.edit-btn').addEventListener('click', () => {
                    nameSpan.classList.add('hidden');
                    nameInput.classList.remove('hidden');
                    descSpan.classList.add('hidden');
                    descInput.classList.remove('hidden');
                    actionsDiv.classList.add('hidden');
                    editActionsDiv.classList.remove('hidden');
                });

                row.querySelector('.cancel-btn').addEventListener('click', () => {
                    loadAirlines(currentPage);
                });

                row.querySelector('.save-btn').addEventListener('click', () => {
                    const newName = nameInput.value.trim();
                    const newDesc = descInput.value.trim();

                    errorMsg.textContent = '';
                    nameInput.classList.remove('border-red-500');
                    descInput.classList.remove('border-red-500');

                    fetch(`/api/airlines/${airline.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ name: newName, description: newDesc })
                    })
                    .then(async res => {
                        if (!res.ok) {
                            const data = await res.json();
                            const fields = data.error?.fields || {};
                            throw new Error(Object.values(fields).flat().join(', ') || data.error?.message || 'Unknown error');
                        }
                        return res.json();
                    })
                    .then(() => {
                        loadAirlines(currentPage);
                    })
                    .catch(err => {
                        errorMsg.textContent = err.message;
                    });
                });

                tbody.appendChild(row);
            });
        }




    </script>
</x-flight-layout>
