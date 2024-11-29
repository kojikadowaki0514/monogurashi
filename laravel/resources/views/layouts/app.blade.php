<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .small {
            display: none;
        }
    </style>

</head>
<body class="font-sans antialiased flex flex-col min-h-screen">
    <div class="flex-grow">
        @include('layouts.header')

        <!-- ページのコンテンツ -->
        <main>
            {{ $slot }}
        </main>
        @include('layouts.footer')
    </div>
</body>
</html>
