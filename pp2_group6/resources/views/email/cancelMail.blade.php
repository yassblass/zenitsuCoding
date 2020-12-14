<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Mail</title>
</head>
<body>
    <h1>Dear {{$cancel['name']}} {{$cancel['lastname']}}</h1>

    <p> Your appointment on {{$cancel['appoint']}} has been cancelled. For the next reason's: {{$cancel['description']}}</p>

    <p> You can take a new appointment online</p>


    <p>The secretary </p>
</body>
</html>