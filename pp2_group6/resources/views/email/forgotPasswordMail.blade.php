<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot password</title>
</head>
<body>
<h3>Dear {{$forgot['firstName']}}</h3>

<p> Your appointment on  has been confirmed.</p>
<p>here is your link to change your password localhost:8000/forgot/{{$forgot['forgot_password']}}</p>

<p>The secretary </p>
</body>
</html>