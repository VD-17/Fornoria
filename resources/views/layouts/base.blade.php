<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="images/icons/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    @vite('resources/css/toast.css')
    @stack('styles')
    <title>@yield('title', 'Fornoria')</title>

    <style>
        :root { --bg-image: url("{{ asset('images/restaurant/background.jpeg') }}");
        --hero-img: url("{{ asset('images/restaurant/hero.jpeg')}}");
    --gallery-img1: url("{{ asset('storage/gallery_images/XDkCp7IuwTXxJokoGHsGD8iKpIHxOJWdTeDSPWEh.jpg') }}");
    --gallery-img2: url("{{ asset('storage/gallery_images/sWwn3Lnc5VCiP2kx2SG0TjIeZJ3O1cWQxUCXswIh.jpg') }}");
    --gallery-img3: url("{{ asset('storage/gallery_images/OJF8h7GzzHlotbSkKjoEmaqJoLF7d29IGkI5Aa3P.jpg') }}");
    --gallery-img4: url("{{ asset('storage/gallery_images/DFz6DCNu0kULhke7jNnTWFwr1QFk6AR1PFpNzvfg.jpg') }}"); }

    </style>
</head>
<body @yield('body_class') @yield('body_style')>
    @include('components.toast')

    @yield('content')

    @stack('scripts')
    @vite('resources/js/toast.css')
</body>
</html>
