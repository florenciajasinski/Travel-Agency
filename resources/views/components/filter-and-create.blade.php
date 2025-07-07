<div class="flex justify-between items-center mb-6">
    <div class="flex gap-2">
        <select id="{{ $filterId }}" class="border px-3 py-2 rounded text-sm">
            <option value="">{{ $filterLabel }}</option>
        </select>

        <x-button
            id="filter"
            button="Filter"
            class="px-4 py-2 rounded text-sm font-medium bg-blue-600 text-white hover:bg-blue-700"
        />
        <x-button
            id="{{ $createBtnId }}"
            button="{{ $createLabel }}"
            class="px-4 py-2 rounded text-sm font-medium bg-green-600 text-white hover:bg-green-700"
        />
    </div>
</div>
