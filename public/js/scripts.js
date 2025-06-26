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
        $('#create-city-form').hide();
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
    const parentDiv = $(this).parent();
    parentDiv.hide();
    parentDiv.siblings('.edit-form').show();
  });

  $(document).on('click', '.cancel-edit-btn', function () {
    const parentDiv = $(this).parent();
    parentDiv.hide();
    parentDiv.siblings('.action-buttons').show();
  });

  $(document).on('click', '.save-edit-btn', function () {
    const id = $(this).data('id');
    const parentDiv = $(this).parent();
    const newName = parentDiv.find('.edit-name').val();

    $.ajax({
      url: `/api/cities/${id}`,
      method: 'PUT',
      data: { name: newName },
      success: function () {
        loadCities(currentPage);
      },
      error: function () {
        alert('Error: The city name must be unique.');
      }
    });
  });
});

function loadCities(page = 1) {
  currentPage = page;

  if (currentAirlineId) {
    $.ajax({
      url: `/api/airlines/${currentAirlineId}/cities`,
      method: 'GET',
      success: function (response) {
        cities = response.data;
        renderTable();
      },
      error: function (xhr) {
        alert('Error loading cities for the selected airline');
      }
    });
  } else {
    $.ajax({
      url: '/api/cities',
      method: 'GET',
      data: { page },
      success: function (response) {
        cities = response.data;
        renderTable();
        renderPagination(response.meta);
      },
      error: function (xhr) {
        alert('Error loading cities');
      }
    });
  }
}

function loadAirlines() {
  $.ajax({
    url: '/api/airlines',
    method: 'GET',
    success: function (response) {
      const select = $('#airline-filter');
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
  $('#city-table-body').empty();

  for (const city of cities) {
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
    $('#city-table-body').append(row);
  }
}

function renderPagination(pagination) {
  $('#pagination').empty();
  for (let i = 1; i <= pagination.last_page; i++) {
    const button = $('<button></button>').text(i).addClass('px-2 py-1 mx-1 border rounded');
    button.on('click', function (event) {
      loadCities(i);
    });
    $('#pagination').append(button);
  }
}
