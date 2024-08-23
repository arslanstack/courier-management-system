<!DOCTYPE html>
<html>
<head>
    <title>A company is inquiring regarding your response on their Driver Wanted Ad.</title>
</head>
<body>
    <b><h5>Dear {{ $maildata['name'] }}!</h5></b>
    <br>
    <p>Below you can find all the relevant information.</p>
    <br>
    <p>Subject: {{ $maildata['subject'] }}</p>
    <p>Body: {{ $maildata['body'] }}</p>
    <p>Reply Email: {{ $maildata['reply_email'] }}</p>
    <p>Company Advert for Driver: {{ $maildata['DriverAd'] }}</p>
    <p>Your Initial Response: {{ $maildata['DriverResponse'] }}</p>
    <br>
    <p>Thankyou for using Drivv powered by Courierboard</p>
    <br>
    <p>Best Regards,</p>
    <p>The Drivv Team</p>
</body>
</html>