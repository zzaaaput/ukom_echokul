<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Echokul')</title>

  {{-- Vite Bootstrap + JS --}}
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

  {{-- NAVBAR PUBLIC --}}
  @include('components.navbar-public')

  <main class="min-vh-100">
    @yield('content')
  </main>

  {{-- FOOTER --}}
  @include('layouts.footer')

</body>
</html>