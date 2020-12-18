<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Mail</title>
</head>
<body>
    <h3>Dear {{ $accept ['name'] }}</h3>
    <br>
    <br>

    <p> Here's a confirmation mail that your appointments is confirmed. We're set to meet on {{$accept['appointment']}}.</p>
    <br>

    <p>If you have any questions, or want to cancel your appointment you can do it : {{$accept['token']}} </p>
    <br>
    <br>

    <p>See you soon!</p>

    <br>

    <p>{{$accept['secretary']}} </p>

    <p>The secretary </p>
</body>
</html>