<!DOCTYPE html>
<html>
<head>
    <title>A company replied to your classified on Courierboard.</title>
</head>
<body>
    <b><h5>Dear {{ $maildata['classifiedAuthor']['fname'] . ' ' .  $maildata['classifiedAuthor']['lname']}}!</h5></b>
    <br>
    <p>Below you can find all the relevant information.</p>
    <br>
    <p>Name: {{ $maildata['name'] }}</p>
    <p>Subject: {{ $maildata['subject'] }}</p>
    <p>Body: {{ $maildata['body'] }}</p>
    <p>Classified: {{ $maildata['classified'] }}</p>
    <br>
    <p>Thankyou for using Drivv powered by Courierboard</p>
    <br>
    <p>Best Regards,</p>
    <p>The Drivv Team</p>
</body>
</html>