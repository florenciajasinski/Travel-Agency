<x-table-layout bodyId="flight_table_body">
    <x-slot name="head">
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Origin</th>
            <th class="px-4 py-2">Destination</th>
            <th class="px-4 py-2">Airline</th>
            <th class="px-4 py-2">Departure</th>
            <th class="px-4 py-2">Arrival</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </x-slot>

    <tr id="flight_row_template" class="hidden">
        <td class="px-4 py-2 id-cell"></td>
        <td class="px-4 py-2 origin-cell"></td>
        <td class="px-4 py-2 destination-cell"></td>
        <td class="px-4 py-2 airline-cell"></td>
        <td class="px-4 py-2 departure-cell"></td>
        <td class="px-4 py-2 arrival-cell"></td>
        <td class="px-4 py-2">
            <x-button-table class="edit-btn text-blue-600 hover:underline">Edit</x-button-table>
            <x-button-table class="delete-btn text-red-600 hover:underline">Delete</x-button-table>
        </td>
    </tr>
</x-table-layout>
