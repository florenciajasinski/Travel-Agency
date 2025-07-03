<table class="table-auto w-full bg-white shadow-md rounded text-sm">
    <thead class="bg-gray-100 text-gray-700 text-left">
        {{ $head }}
    </thead>
    <tbody id="{{ $bodyId ?? '' }}">
        {{ $slot }}
    </tbody>
</table>
