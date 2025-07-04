<div id="{{ $id }}" class="hidden mb-6">
    <input type="text" id="{{ $nameId }}" class="border px-3 py-2 rounded text-sm w-full mb-2" placeholder="Name" />
    <input type="text" id="{{ $descriptionId }}" class="border px-3 py-2 rounded text-sm w-full mb-2" placeholder="Description" />

    <x-button
        id="{{ $buttonId }}"
        button="{{ $buttonText ?? 'Save' }}"
    />

    <x-button
        id="{{ $buttonCancelId }}"
        button="Cancel"
        class="px-4 py-2 bg-gray-300 text-gray-800 rounded text-sm ml-2"
    />

    <x-error id="airline_form_error" />
</div>
