<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello {{ $requestForMail['firstName'] }} {{ $requestForMail['lastName'] }} ! </h1>
    <div>
    <p>You have made an appointment request with {{ $requestForMail['secretaryName'] }}  on {{ $requestForMail['date'] }} at {{ $requestForMail['startsAt'] }}.</p>
    <br>
    <hr>
    <p>You can still cancel your appointment using the following link : "{{ $requestForMail['cancelLink'] }}" </p>
    </div>
    
  

   


</body>
</html>