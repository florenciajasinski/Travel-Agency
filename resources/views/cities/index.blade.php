<x-flight-layout title="Cities" heading="City Management">
    <div class="max-w-4xl mx-auto">
        <x-filter-and-create
            filterId="airline_filter"
            filterLabel="All Airlines"
            createBtnId="add_city_btn"
            createLabel="Add City"
        />

        <div id="create_city_form" class="hidden mb-6">
            <input type="text" id="new_city_name" class="border px-3 py-2 rounded text-sm w-full mb-2" />
            <x-button
                id="save_city_btn"
                button="Save"
            />
            <x-error
                id="error_message"
                class="text-red-600 mt-2 hidden">
            </x-error>
        </div>

        <x-city-table/>
    </div>

    <x-pagination/>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</x-flight-layout>
