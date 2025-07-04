<div class="flex flex-col">
    <label for="{{ $id }}" class="text-gray-700 font-semibold mb-1">{{ $label ?? '' }}</label>
    <input type="date" id="{{ $id }}" class="border px-3 py-2 rounded text-sm" value="{{ $value ?? '' }}">
</div>
