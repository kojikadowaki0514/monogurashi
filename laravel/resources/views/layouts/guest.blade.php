<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/favicon-32x32.png')}}"/>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .min-h-screen { min-height: calc(100vh - 96px);}
        </style>
    </head>
    <body class="h-full font-sans text-gray-900 antialiased">
        @include('layouts.header')
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-0 sm:pt-0" style="background-color: #ece0cf;">
            <div class="w-full sm:max-w-md mt-0 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        @include('layouts.footer')
    </body>
</html>
