<!DOCTYPE html>
<html>
<head>
    <title>Membership Application Rejection</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        h1 {
            color: #d9534f;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center;width:100%"><img src="https://alethihadfc.com/assets/images/brand-logos/desktop-dark.png" alt="logo" style="height:85px"></div>
        <h1>Application Rejection</h1>
        <p>Dear {{ $clubName }} Club,</p>
        <p>We regret to inform you that your application has been rejected. Unfortunately, your team, does not meet our current requirements .</p>
        <p>We appreciate your interest in our club and encourage you to apply again in the future.</p>
        <p>Thank you for your understanding.</p>
        <p>Best regards,</p>
        <p>{{ env('APP_NAME') }} </p>
    </div>
</body>
</html>
