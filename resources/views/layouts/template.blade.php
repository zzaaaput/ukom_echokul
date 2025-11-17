<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Echokul')</title>

  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

  @include('components.navbar-public')
  @include('layouts.header')

  <main class="min-vh-100">
    @yield('content')
  </main>

  @include('layouts.footer')

</body>
</html>