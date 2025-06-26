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
    <a href="/" class="bg-white text-gray-800 px-4 py-2 rounded-lg shadow flex items-center gap-2">
        Information
    </a>

    <a href="/cities" class="bg-white text-gray-800 px-4 py-2 rounded-lg shadow flex items-center gap-2">
        Cities
    </a>

    <a href="#" class="bg-white text-gray-800 px-4 py-2 rounded-lg shadow flex items-center gap-2">
        Airlines
    </a>

    <a href="#" class="bg-white text-gray-800 px-4 py-2 rounded-lg shadow flex items-center gap-2">
        Flights
    </a>
   </div>


  <main class="px-4">
    {{ $slot }}
  </main>

</body>
</html>
