<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Mail</title>
</head>
<body>
    <h3>Dear {{$cancel['name']}},</h3>

<br>
    <p> I have an appointment scheduled on {{$cancel['appointment']}}. </p>

    <br>
   <p>Unfortunately, I must cancel the appointment for the next reason : {{$cancel['description']}}
   <br>

   I will be grateful if we can reschedule for a future date. 
   You can schedule a new appointment on this website : www.localhost:8000/
   <br>
   </p>


    <p>The secretary</p>
    <p>{{$cancel['secretary']}} </p>

</body>
</html>