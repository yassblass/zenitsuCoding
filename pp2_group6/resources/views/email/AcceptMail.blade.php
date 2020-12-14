<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Mail</title>
</head>
<body>
    <h1>Dear {{ $accept ['name'] }} {{ $accept ['lastname'] }}</h1>

    <p> Your appointment on {{$accept['appoint']}} has been confirmed.</p>
    <p>If you want to change your appointment, cancel it, you can do it : {{$accept['token']}} </p>

    <p>The secretary </p>
</body>
</html>