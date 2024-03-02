<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/403.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>403 page is restricted</title>
</head>

<body>
    <i class="fa-solid fa-lock fs-1 mb-4"></i>
    <div class="message">
        <h1>Access to this page is restricted</h1>
        <p>You cannot access this profile because you have been blocked by this user</p>
    </div>
</body>

</html>
