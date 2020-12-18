<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot password</title>
</head>
<body>
<h3>Dear Mr.{{$forgot['firstName']}}</h3>

<p> Did you forgot your password ?.</p>
<p>here is your link to change your password localhost:8000/forgot/{{$forgot['forgot_password']}}</p>
<p>if you did not forgot your password juste skip this email, maybe someone is trying to connect on your account , change your password if it is not secure</p>

<p>EHB - Appointment</p>
</body>
</html>