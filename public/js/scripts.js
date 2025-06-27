let cities = [];
let currentAirlineId = '';
let currentPage = 1;

$(document).ready(function () {
  loadCities(currentPage);
  loadAirlines();

  $(document).on('click', '#add_city_btn', function () {
    $('#create_city_form').toggleClass('hidden');
  });

  $(document).on('click', '#save_city_btn', function () {
    const name = $('#new_city_name').val();
    $.ajax({
      url: '/api/cities',
      method: 'POST',
      data: { name },
      success: function () {
        $('#new_city_name').val('');
        $('#create_city_form').hide();
        loadCities(currentPage);
      },
      error: function () {
        alert('Error: The city name must be unique.');
      }
    });
  });

  $(document).on('click', '#filter', function () {
    currentAirlineId = $('#airline_filter').val();
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
    const new_name = parentDiv.find('.edit-name').val();

    $.ajax({
      url: `/api/cities/${id}`,
      method: 'PUT',
      data: { name: new_name },
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
      error: function () {
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
      error: function () {
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

  for (const city of cities) {
    const row = $(`
      <tr class="border-t">
        <td class="px-4 py-2">${city.id}</td>
        <td class="px-4 py-2">${city.name}</td>
        <td class="px-4 py-2">${city.incoming_flights}</td>
        <td class="px-4 py-2">${city.outgoing_flights}</td>
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
