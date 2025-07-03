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
                            <x-button-table class="edit-btn text-blue-600 hover:underline">Edit</x-button-table>
                            <x-button-table class="delete-btn text-red-600 hover:underline">Delete</x-button-table>
                        </div>
                        <div class="edit-buttons hidden flex gap-2 items-center">
                            <x-button-table class="save-btn text-green-600 hover:underline">Save</x-button-table>
                            <x-button-table class="cancel-btn text-gray-600 hover:underline">Cancel</x-button-table>
                            <span class="error-msg text-red-600 text-xs ml-2"></span>
                        </div>
                    </td>
                </tr>
            </tbody>
</table>
