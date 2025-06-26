let cities = [];
let currentAirlineId = '';
let currentPage = 1;

$(document).ready(function () {
  loadCities(currentPage);
  loadAirlines();

  $(document).on('click', '#add-city-btn', function () {
    $('#create-city-form').toggleClass('hidden');
  });

  $(document).on('click', '#save-city-btn', function () {
    const name = $('#new-city-name').val();
    $.ajax({
      url: '/api/cities',
      method: 'POST',
      data: { name },
      success: function (city) {
        $('#new-city-name').val('');
        $('#create-city-form').addClass('hidden');
        loadCities(currentPage);
      },
      error: function (xhr) {
        let message = 'The city name must be unique.';
        alert('Error: ' + message);
      }
    });
  });

  $(document).on('click', '#filter', function () {
    currentAirlineId = $('#airline-filter').val();
    loadCities(1);
  });

  $(document).on('click', '.delete-btn', function () {
    const id = $(this).data('id');
    $.ajax({
      url: `/api/cities/${id}`,
      type: 'DELETE',
      success: function () {
        cities = cities.filter(city => city.id !== id);
        renderTable();
        loadCities(currentPage);
      }
    });
  });

  $(document).on('click', '.edit-btn', function () {
    const td = $(this).closest('td');
    td.find('.action-buttons').addClass('hidden');
    td.find('.edit-form').removeClass('hidden');
  });

  $(document).on('click', '.cancel-edit-btn', function () {
    const td = $(this).closest('td');
    td.find('.edit-form').addClass('hidden');
    td.find('.action-buttons').removeClass('hidden');
  });

  $(document).on('click', '.save-edit-btn', function () {
    const id = $(this).data('id');
    const td = $(this).closest('td');
    const newName = td.find('.edit-name').val();

    $.ajax({
      url: `/api/cities/${id}`,
      method: 'PUT',
      data: { name: newName },
      success: function (updated) {
        loadCities(currentPage);
      },
      error: function (xhr) {
        let message = 'The city name must be unique.';
        alert('Error: ' + message);
      }
    });
  });
});

function loadCities(page = 1) {
  currentPage = page;
  $.ajax({
    url: '/api/cities',
    method: 'GET',
    data: {
      page,
      airline_id: currentAirlineId,
    },
    success: function (response) {
      cities = response.data;
      renderTable();
      renderPagination(response.meta);
    }
  });
}

function loadAirlines() {
  $.ajax({
    url: '/api/airlines',
    method: 'GET',
    success: function (response) {
      const select = $('#airline-filter');
      response.data.forEach(airline => {
        select.append(`<option value="${airline.id}">${airline.name}</option>`);
      });
    }
  });
}

function renderTable() {
  const tbody = $('#city-table-body');
  tbody.empty();

  cities.forEach(city => {
    const row = $(`
      <tr class="border-t">
        <td class="px-4 py-2">${city.id}</td>
        <td class="px-4 py-2">${city.name}</td>
        <td class="px-4 py-2">${city.incoming_flights ?? 0}</td>
        <td class="px-4 py-2">${city.outgoing_flights ?? 0}</td>
        <td class="px-4 py-2">
          <div class="flex gap-2 action-buttons">
            <button class="edit-btn text-blue-600 hover:underline" data-id="${city.id}">Edit</button>
            <button class="delete-btn text-red-600 hover:underline" data-id="${city.id}">Delete</button>
          </div>
          <div class="edit-form hidden mt-2">
            <input type="text" class="edit-name border px-2 py-1 text-sm rounded" value="${city.name}" />
            <button class="save-edit-btn text-sm bg-green-500 text-white px-2 py-1 rounded" data-id="${city.id}">Save</button>
            <button class="cancel-edit-btn text-sm bg-gray-300 px-2 py-1 rounded">Cancel</button>
          </div>
        </td>
      </tr>
    `);
    tbody.append(row);
  });
}

function renderPagination(meta) {
  const container = $('#pagination');
  container.empty();

  for (let i = 1; i <= meta.last_page; i++) {
    const btn = $(`<button class="px-2 py-1 mx-1 border rounded ${i === meta.current_page ? 'bg-blue-500 text-white' : ''}">${i}</button>`);
    btn.on('click', function (e) {
      e.preventDefault();
      loadCities(i);
    });
    container.append(btn);
  }
}
