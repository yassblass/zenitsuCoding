<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Mail</title>
</head>
<body>
    <h1>Dear {{ $refuse ['name'] }} {{ $refuse ['lastname'] }}</h1>

    <p> Your appointment on {{$refuse['appoint']}} has been refused.</p>
    <p> You can take a new appointment on the site</p>

    <p>The secretary </p>
</body>
</html>