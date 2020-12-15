<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2> Hello {{ $requestForMail['firstName'] }} {{ $requestForMail['lastName'] }} !</h1>

    <p>You have made an appointment request on {{ $requestForMail['date']}} at {{ $requestForMail['startsAt'] }} with {{ $requestForMail['secretaryName'] }}. </p>

    <p> You can still cancel your appointment with following link: {{ $requestForMail['cancelLink'] }}</p>


</body>
</html>