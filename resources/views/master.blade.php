<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Link Shortener</title>
    <!-- Bootstrap CSS -->
    @include('partial.style')
    @stack('css')
</head>
<body>

<!-- Navbar -->
@include('inc.navbar')

<!-- Main Content -->

@yield('content')


<!-- Bootstrap JS (Optional) -->
<!-- ... Bootstrap and Popper.js scripts here ... -->

@include('partial.script')
@stack('js')
</body>
</html>
