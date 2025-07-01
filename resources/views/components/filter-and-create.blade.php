<div class="flex justify-between items-center mb-6">
    <div class="flex gap-2">
        <select id="{{ $filterId }}" class="border px-3 py-2 rounded text-sm">
            <option value="">{{ $filterLabel }}</option>
        </select>

        <button id="filter" class="px-4 py-2 rounded text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            Filter
        </button>

        <button id="{{ $createBtnId }}" class="px-4 py-2 rounded text-sm font-medium bg-green-600 text-white hover:bg-green-700">
            {{ $createLabel }}
        </button>
    </div>
</div>
