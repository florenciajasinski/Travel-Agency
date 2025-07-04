<div class="max-w-lg mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col col-span-2">
            <label for="name" class="text-gray-700 font-semibold mb-1">Name</label>
            <input type="text" id="name" name="name" class="border px-3 py-2 rounded text-sm mb-4" value="{{ $city->name }}">
        </div>

        <div class="flex flex-col col-span-2">
            <label class="text-gray-700 font-semibold mb-2">Airlines</label>
            <div id="airline-checkboxes" class="grid grid-cols-2 gap-2">
            </div>
        </div>

        <div class="col-span-2 flex justify-end gap-2">
            <x-button
                id="save_flight_btn"
                button="Save"
            />
            <x-button
                id="cancel_flight_btn"
                button="Cancel"
                class="bg-gray-300 px-4 py-2 rounded cancel-edit-btn"
            />
        </div>
        <x-error
            id="edit_city_error"
        />
</div>
