<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello {{ $cancelByStudent['secretaryName'] }} ! </h1>
    <div>
    <p>An appointment request has been made by {{ $requestToSecretary['firstName'] }} {{ $requestToSecretary['lastName'] }} on {{ $requestToSecretary['date'] }} at {{ $requestToSecretary['startsAt'] }}.</p>
    <br>
    <hr>
    <p>Please visit your dashboard to accept or decline the request with the following link : "{{ $requestToSecretary['dashboardLink'] }}" </p>
    </div>
    
  

   


</body>
</html>