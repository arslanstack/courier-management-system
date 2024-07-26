<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <b><h5>Dear {{ $maildata['name'] }}!</h5></b>
    <p><b>This message is to inform you that Davidson and Rocha Co has invited you to join Drivv powered by Courierboard. </p>
    <br>
    <p>Your account log in information is below.</p>
    <br>
    <p>Company: {{ $maildata['company'] }}</p>
    <p>Username: {{ $maildata['email'] }}</p>
    <p>Password: {{ $maildata['password'] }}</p>
    <br>
    <p>To begin using Drivv powered by Courierboard, log in with your username and temporary password</p>
    <br>
    <p>Best Regards,</p>
    <p>The Drivv Team</p>
</body>
</html>