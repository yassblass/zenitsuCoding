<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Mail</title>
</head>
<body>
<h3>Dear {{$refuse['name']}},</h3>

<br>
    <p> I have a request for an appointment on {{$refuse['appointment']}}. </p>

    <br>
   <p>Unfortunately, I must refuse the appointment.
   <br>

   I will be grateful if we can reschedule for a future date. 
   You can schedule a new appointment on this website : www.localhost:8000/
   <br>
   </p>


    <p>The secretary</p>
    <p>{{$refuse['secretary']}} </p>
</body>
</html>