<!DOCTYPE html>
<html>
<head>
    <title>@lang('messages.Registration Confirmation')</title>
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
        <h1>@lang('messages.Thank You for Registering')</h1>
        <p>@lang('messages.Dear') {{ $userName }},</p>
        <p>@lang('messages.Thank you for joining us- We have received your registration and will review your data-')</p>
        <p>@lang('messages.We will send you an email as soon as possible with further information')</p>
        <p>@lang('messages.We appreciate your interest in our club and look forward to having you with us')</p>
        <p>@lang('messages.Best regards,')</p>
        <p>{{ env('APP_NAME') }} </p>
    </div>
</body>
</html>
