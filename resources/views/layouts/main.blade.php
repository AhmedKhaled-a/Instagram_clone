<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title")</title>
    @section("custom-css")
    @show
</head>
<body class="bg-dark text-white">
    @include('layouts.navbar')
    <div class="container">
        @section("content")
        @show
    </div>
    @section("scripts")
    @show
</body>
</html>