<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP VERIFICATION</title>
</head>

<body>
    <h1>Your Login OTP</h1>
    <p>Hello {{ $user }}</p>
    <p>Your OTP for login is <strong>{{ $randomnumber }}</strong>.</p>
    <p>Please enter this OTP in the login form to proceed.</p>
    <p>If you did not request this OTP, please ignore this email.</p>

    <p>Thank you,<br>Team</p>
</body>

</html>
