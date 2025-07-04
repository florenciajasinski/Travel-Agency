<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Flight Management System' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50">

  <header class="py-10 text-center">
    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
      Travel Agency
    </h1>
    @isset($heading)
      <div class="mt-4 text-xl text-gray-600">
        {{ $heading }}
      </div>
    @endisset
  </header>

  <div class="flex justify-center gap-4 mb-8">

   <x-nav-links href="/cities">
        Cities
    </x-nav-links>

    <x-nav-links href="/airlines">
        Airlines
    </x-nav-links>

    <x-nav-links href="/flights">
        Flights
    </x-nav-links>
   </div>


  <main class="px-4">
    {{ $slot }}
  </main>

</body>
</html>
