<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Mail</title>
</head>
<body>
<h3>Dear {{ $refuse ['name'] }}</h3>

<p> Your appointment on {{$refuse['appointment']}} has been confirmed.</p>
<p>If you want to change your appointment, cancel it, you can do it : localhost:8000/{{$refuse['token']}} </p>

<p>The secretary </p>
</body>
</html>