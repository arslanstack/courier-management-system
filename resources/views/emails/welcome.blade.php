<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <b><h5>Dear {{ $maildata['name'] }}!</h5></b>
    <p><b>Your Quote Request is Active.</b>  You will be notified when quotes arrive.  You can view all delivery quotes and ask questions on your quote page. </p>
    <br>
    <p>Your account log in information is below.</p>
    <br>
    <p>Company: {{ $maildata['company'] }}</p>
    <p>Username: {{ $maildata['username'] }}</p>
    <p>Password: {{ $maildata['password'] }}</p>
    <br>
    <!-- <p>You can reset a permanent password by logging in <a href="https://www.courierboard.com/account/login">here</a>.</p> -->
    <br>
    <!-- <p>If you have any questions, please contact a Drivv support representative <a href="https://www.courierboard.com/home/contact">here</a>.</p> -->
    <p>Thank you for registering with Drivv, helping you get competitive quotes from professional courier companies easily.</p>
    <br>
    <p>Best Regards,</p>
    <p>The Drivv Team</p>
</body>
</html>