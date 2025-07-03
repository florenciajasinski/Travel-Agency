<x-flight-layout title="Airlines" heading="Airline Management">
    <div class="max-w-4xl mx-auto">
        <x-filter-and-create
            filterId="city_filter"
            filterLabel="All Cities"
            createBtnId="add_airline_btn"
            createLabel="Add airline"
        />

        <x-airline-create-form
            id="create_airline_form"
            nameId="new_airline_name"
            descriptionId="new_airline_description"
            buttonId="save_airline_btn"
            buttonCancelId="cancel_airline_btn"
            buttonText="Save Airline"
        />
        <x-airline-table/>

    </div>
    <x-pagination/>

    <script>
        let airlines = [];
        let currentPage = 1;
        let currentCityId = '';
        const HTTP_METHODS = {
        GET: 'GET',
        POST: 'POST',
        PUT: 'PUT',
        DELETE: 'DELETE'
        };

        document.addEventListener('DOMContentLoaded', () => {
            initAirlinesPage();
        });

        function initAirlinesPage() {
            loadAirlines(currentPage);
            loadCities();

            document.getElementById('add_airline_btn').addEventListener('click', toggleCreateAirlineForm);
            document.getElementById('filter').addEventListener('click', handleCityFilter);
            document.getElementById('save_airline_btn').addEventListener('click', createAirline);
            document.getElementById('cancel_airline_btn').addEventListener('click', hideCreateAirlineForm);
        }

        function toggleCreateAirlineForm() {
            document.getElementById('create_airline_form').classList.toggle('hidden');
        }

        function handleCityFilter() {
            currentCityId = document.getElementById('city_filter').value;
            loadAirlines(currentPage);
        }

        function hideCreateAirlineForm() {
            document.getElementById('create_airline_form').classList.add('hidden');
        }

        function loadAirlines(page = 1) {
            currentPage = page;
            const url = currentCityId ? `api/cities/${currentCityId}/airlines` : `/api/airlines?page=${page}`;

            fetch(url, {
                headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
                },
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

        function loadCities() {
            fetch('/api/cities', {
                method: HTTP_METHODS.GET,
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
                btn.className = `px-2 py-1 mx-1 border rounded`;
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
            airlines.forEach(function(airline) {
                const row = template.cloneNode(true);
                row.id = '';
                row.classList.remove('hidden');

                const idCell = row.querySelector('.id-cell');
                const nameSpan = row.querySelector('.name-cell');
                const nameInput = row.querySelector('.edit-name');
                const descSpan = row.querySelector('.description-cell');
                const descInput = row.querySelector('.edit-desc');
                const flightsCell = row.querySelector('.flights-cell');
                const actions = row.querySelector('.action-buttons');
                const editActions = row.querySelector('.edit-buttons');
                const errorMessage = row.querySelector('.error-msg');

                idCell.textContent = airline.id;
                nameSpan.textContent = airline.name;
                nameInput.value = airline.name;
                descSpan.textContent = airline.description;
                descInput.value = airline.description;
                flightsCell.textContent = airline.flights_count;

                const deleteBtn = row.querySelector('.delete-btn');
                deleteBtn.addEventListener('click', function() {
                    fetch(`/api/airlines/${airline.id}`, {
                        method: HTTP_METHODS.DELETE,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    }).then(function() {
                        loadAirlines(currentPage);
                    });
                });

                const editBtn = row.querySelector('.edit-btn');
                editBtn.addEventListener('click', function() {
                    nameSpan.classList.add('hidden');
                    nameInput.classList.remove('hidden');
                    descSpan.classList.add('hidden');
                    descInput.classList.remove('hidden');
                    actions.classList.add('hidden');
                    editActions.classList.remove('hidden');
                });

                const cancelBtn = row.querySelector('.cancel-btn');
                cancelBtn.addEventListener('click', function() {
                    loadAirlines(currentPage);
                });

                const saveBtn = row.querySelector('.save-btn');
                saveBtn.addEventListener('click', function() {
                    const newName = nameInput.value;
                    const newDesc = descInput.value;
                    errorMessage.textContent = '';

                    fetch(`/api/airlines/${airline.id}`, {
                        method: HTTP_METHODS.PUT,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            name: newName,
                            description: newDesc
                        })
                    })
                    .then(function(res) {
                        if (!res.ok) {
                            return res.json().then(function(data) {
                                const fields = data.error?.fields;
                                const message = Object.values(fields);
                                throw new Error(message);
                            });
                        }
                        return res.json();
                    })
                    .then(function() {
                        loadAirlines(currentPage);
                    })
                    .catch(function(err) {
                        errorMessage.textContent = err.message;
                    });
                });
                tbody.appendChild(row);
            });
        }

        function createAirline() {
                const errorMessage = document.getElementById('airline_form_error');
                const name = document.getElementById('new_airline_name').value;
                const description = document.getElementById('new_airline_description').value;
                errorMessage.textContent = '';

                fetch('/api/airlines', {
                    method: HTTP_METHODS.POST,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ name, description })
                })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then((data) => {
                            if (data?.error?.fields) {
                                const fields = data.error.fields;
                                const message = Object.values(fields).flat().join(', ');
                                throw new Error(message);
                            }
                            throw new Error(data?.error?.message || 'An error occurred');
                        });
                    }
                    return res.json();
                })
                .then((res => {
                    if (res.data.status === 'error') {
                        errorMessage.textContent = res.data.message;
                        return;
                    }
                    document.getElementById('create_airline_form').classList.add('hidden');
                    loadAirlines(currentPage);
                    document.getElementById('new_airline_name').value = '';
                    document.getElementById('new_airline_description').value = '';
                    errorMessage.textContent = '';
                }))
                .catch((err) => {
                    const response = err?.response;
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
                    errorMessage.textContent = err.message ;
                });
        }
    </script>
</x-flight-layout>
