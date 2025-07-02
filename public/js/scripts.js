let cities = [];
let currentAirlineId = '';
let currentPage = 1;
const HTTP_METHODS = {
  GET: 'GET',
  POST: 'POST',
  PUT: 'PUT',
  DELETE: 'DELETE'
};

$(document).ready(function () {
  loadCities(currentPage);
  loadAirlines();
  registerEventHandlers();
});

function registerEventHandlers() {
  $(document).on('click', '#add_city_btn', CreateCityForm);
  $(document).on('click', '#save_city_btn', saveCity);
  $(document).on('click', '#filter', filterCities);
  $(document).on('click', '.delete-btn', deleteCity);
}

function CreateCityForm() {
  $('#create_city_form').toggleClass('hidden');
}


function saveCity() {
  const name = $('#new_city_name').val();
  const errorMessage = $('#error_message');

  $.ajax({
    url: '/api/cities',
    method: HTTP_METHODS.POST,
    data: { name },
    success: function () {
      $('#new_city_name').val('');
      $('#create_city_form').addClass('hidden');
      errorMessage.text('').hide();
      loadCities(currentPage);
    },
    error: function (xhr) {
      let message = xhr.responseJSON?.error?.fields?.name?.[0] || xhr.responseJSON?.error?.message;
      errorMessage.text(message).show();
    }
  });
}

function deleteCity() {
  const id = $(this).data('id');
  $.ajax({
    url: `/api/cities/${id}`,
    method: HTTP_METHODS.DELETE,
    success: function () {
      loadCities(currentPage);
    }
  });
}

function filterCities() {
  currentAirlineId = $('#airline_filter').val();
  loadCities(currentPage);
}

function loadCities(page = 1) {
  currentPage = page;

  const url = currentAirlineId ? `/api/airlines/${currentAirlineId}/cities` : '/api/cities';

  const params = currentAirlineId ? {} : { page };

  $.ajax({
    url,
    method: HTTP_METHODS.GET,
    data: params,
    success: function (response) {
      cities = response.data;
      renderTable();
      if (!currentAirlineId) renderPagination(response.meta);
    },
    error: function () {
      alert('Error loading cities');
    }
  });
}

function loadAirlines() {
  $.ajax({
    url: '/api/airlines',
    method: HTTP_METHODS.GET,
    success: function (response) {
      const select = $('#airline_filter');
      select.empty();
      select.append('<option value="">All Airlines</option>');
      response.data.forEach(airline => {
        select.append(`<option value="${airline.id}">${airline.name}</option>`);
      });
    },
    error: function () {
      alert('Error loading airlines');
    }
  });
}

function renderTable() {
  $('#city_table_body').empty();

  for (const { id, name, incoming_flights, outgoing_flights } of cities) {
    const row = $(`
      <tr class="border-t">
        <td class="px-4 py-2">${id}</td>
        <td class="px-4 py-2">${name}</td>
        <td class="px-4 py-2">${incoming_flights}</td>
        <td class="px-4 py-2">${outgoing_flights}</td>
        <td class="px-4 py-2">
          <div class="flex gap-2 action-buttons">
            <button class="edit-btn text-blue-600 hover:underline" data-id="${id}">Edit</button>
            <button class="delete-btn text-red-600 hover:underline" data-id="${id}">Delete</button>
          </div>
          <div class="edit-form hidden mt-2">
            <input type="text" class="edit-name border px-2 py-1 text-sm rounded" value="${name}" />
            <button class="save-edit-btn text-sm bg-green-500 text-white px-2 py-1 rounded" data-id="${id}">Save</button>
            <button class="cancel-edit-btn text-sm bg-gray-300 px-2 py-1 rounded">Cancel</button>
          </div>
        </td>
      </tr>
    `);
    const editBtn = row[0].querySelector('.edit-btn');
    if (editBtn) {
      editBtn.addEventListener('click', () => {
        window.location.href = `/cities/${id}/edit`;
      });
    }

    $('#city_table_body').append(row);
  }
}

function renderPagination(pagination) {
  $('#pagination').empty();
  for (let i = 1; i <= pagination.last_page; i++) {
    const button = $('<button></button>').text(i).addClass('px-2 py-1 border rounded mx-1');
    button.on('click', function () {
      loadCities(i);
    });
    $('#pagination').append(button);
  }
}
