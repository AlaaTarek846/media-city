<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MediaCity">
    <meta name="keywords" content="MediaCity">
    <meta name="author" content="MediaCity">
    <link rel="icon" href="{{asset('website/images/logo.png')}}" type="image/x-icon">
    <title>MediaCity</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link id="rtl-link" rel="stylesheet" type="text/css" href="{{asset('website/css/vendors/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('website/css/animate.min.css')}}" >
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/vendors/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/vendors/feather-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/vendors/slick/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/vendors/slick/slick-theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/bulk-style.css')}}">
    @if (app()->getLocale() == 'ar')
        <link id="color-link" rel="stylesheet" type="text/css" href="{{asset('website/css/style-rtl.css')}}">
    @else
        <link id="color-link" rel="stylesheet" type="text/css" href="{{asset('website/css/style.css')}}">
    @endif
</head>
