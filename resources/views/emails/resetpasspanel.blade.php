<!DOCTYPE html>
<html>

<head>
    <title>Password Reset Request</title>
</head>

<body>
    <b>
        <h5>Dear {{ $maildata['name'] }}!</h5>
    </b>
    <p><b>We recieved a password reset request from an admin user of your company against this email address.</b> </p>
    <br>
    <p>Your temporary account log in information is below.</p>
    <br>
    <p>Username: {{ $maildata['email'] }}</p>
    <p>Password: {{ $maildata['password'] }}</p>
    <br>
    <p>To continue using Drivv powered by Courierboard, log in with your username and temporary password</p>
    <br>
    <p>Best Regards,</p>
    <p>The Drivv Team</p>
</body>

</html>