<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <title>@yield("title")</title>
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @section("custom-css")
    @show
</head>
<body class="">
    @include('layouts.navbar')
    <div class="container py-5 px-5">
        @section("content")
        @show
    </div>
    @section("scripts")
    @show
</body>
</html>
