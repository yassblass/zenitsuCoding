<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Mail</title>
</head>
<body>
    <h3>Dear {{$cancel['name']}},</h3>

    <p> I have an appointment with you scheduled on <strong>{{$cancel['appointment']}}</strong>. </p>

   <p>Unfortunately, I must cancel the appointment for the next reason : <strong>{{$cancel['description']}}</strong> 
   <br><br>

   I will be grateful if we can reschedule for a future date. 
   You can schedule a new appointment on this website : www.localhost:8000/
   <br>
   </p>


    <p>The secretary</p>
    <p>{{$cancel['secretary']}} </p>

</body>
</html>