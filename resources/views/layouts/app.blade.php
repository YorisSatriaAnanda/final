<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mekarjaya Coffee') }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}" />

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f6f6f6] text-gray-900">
    <div class="min-h-screen">
        {{ $slot }}
    </div>
</body>
</html>