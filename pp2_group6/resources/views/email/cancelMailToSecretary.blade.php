<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Cancel</title>
</head>
<body>
    <h1>Dear {{ $cancelByStudent['secretaryName'] }} </h1>
    <div>
    <p>Be aware that the appointment made by {{ $cancelByStudent['studentName'] }} on {{ $cancelByStudent['date'] }} at {{ $cancelByStudent['startsAt'] }} has been canceled.</p>
    <br>
    <p>Do not reply to this email please. </p>
    <hr>
    </div>
    

</body>
</html>