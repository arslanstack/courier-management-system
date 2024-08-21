<!DOCTYPE html>
<html>
<head>
    <title>A user showed interest in your vehicle available post</title>
</head>
<body>
    <b><h5>Dear {{ $maildata['to_name'] }}!</h5></b>
    <p><b>This message is to inform you that {{ $maildata['from_name'] }} from {{ $maildata['from_company'] }} showed interest in one of your vehicle post. </p>
    <br>
    <p>Below you can find all the relevant information.</p>
    <br>
    <p>Start Point: {{ $maildata['start_addr'] }}</p>
    <p>Destination: {{ $maildata['destination_addr'] }}</p>
    <p>Date: {{ $maildata['date'] }}</p>
    <p>User: {{ $maildata['from_name'] }}</p>
    <p>Company: {{ $maildata['from_company'] }}</p>
    <p>Email: {{ $maildata['from_email'] }}</p>
    <p>Phone: {{ $maildata['from_phone'] }}</p>
    <p>Subject: {{ $maildata['subject'] }}</p>
    <p>Body: {{ $maildata['body'] }}</p>
    <br>
    <p>Thankyou for using Drivv powered by Courierboard</p>
    <br>
    <p>Best Regards,</p>
    <p>The Drivv Team</p>
</body>
</html>