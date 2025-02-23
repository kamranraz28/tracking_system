<!DOCTYPE html>
<html>
<head>
    <title>Your OTP for Login</title>
</head>
<body>
    <h3>Hello {{ $user->name }},</h3>
    <p>Your OTP for login is: <strong>{{ $otp }}</strong></p>
    <p>Please use this OTP to log in to your account.</p>
    <p>Thank you!</p>
    <p>Regards, <br>Md Kamran Hosan <br>Software Engineer</p>
</body>
</html>
