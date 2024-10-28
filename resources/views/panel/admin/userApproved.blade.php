<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Approval Notification</title>
</head>

<body>
    @if ($user->type == 1)
        <div class="div">
            <h1>Hello, {{ $user->name }}</h1>
            <p>Your account has been approved!</p>
            <p>OTP:{{ $randomnumber }}</p>
            <p>Thank you for being with us.</p>
        </div>
    @endif


    @if ($user->type == 0)
        <div class="disappove">
            <h1>Sorry, {{ $user->name }}</h1>
            <p>Your account has been disaaprove!</p>
            <p>Contact Admin to process...</p>
        </div>
    @endif


</body>

</html>
