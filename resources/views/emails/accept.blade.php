<!DOCTYPE html>
<html>
<head>
    <title>Application Acceptance</title>
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
            color: #5cb85c;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center;width:100%"><img src="https://alethihadfc.com/assets/images/brand-logos/desktop-dark.png" alt="logo" style="height:85px"></div>
        <h1>Application Accepted</h1>
        <p>Dear {{ $clubName }} Club,</p>
        <p>We are pleased to inform you that your application has been accepted. Congratulations, your team meets our current requirements.</p>
        <p>We are excited to have you as a part of our club and look forward to your participation.</p>
        <p>Thank you for your interest in our club.</p>
        <p>Best regards,</p>
        <p>{{ env('APP_NAME') }} </p>
    </div>
</body>
</html>
