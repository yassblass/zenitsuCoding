<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Hello {{ $verificationCode['firstname'] }} {{ $verificationCode['lastname'] }}! </h1>
    <p>Please verify yourself by filling in this verification code: {{$verificationCode['v_code']}}</p>
    <hr>
    <p>Ehb Secretary Team</p>
  

   


</body>
</html>