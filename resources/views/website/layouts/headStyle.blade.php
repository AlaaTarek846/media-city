<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {{-- add meta language --}}
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <title>{{env("APP_NAME")}} | @yield('pageTitle')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="icon" type="image/png" href="/website/images/favicon.png">

  <!--font-->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&amp;display=swap"
    rel="stylesheet">

    <link href="/website/css/sweetalert2.min.css" rel="stylesheet">
    <link href="/website/js/ajax/libs/jqueryui/1.12.1/jquery-ui.css" type="text/css" rel="stylesheet"
    media="all">
    <link rel="stylesheet" type="text/css" href="/website/css/price_range_style.css">

    @if (app()->getLocale() == 'ar')
            <link href="/website/css/rtl.min.css" rel="stylesheet">
        @else
            <!-- Plugins-->
            <!-- Link Swiper's CSS -->
            <link rel="stylesheet" href="/website/plugins/swiper/css/swiper-bundle.min.css">

             <!--Bootstrap files-->
           <link href="/website/css/bootstrap.min.css" rel="stylesheet">
           <link rel="stylesheet" href="/website/css/bootstrap-icons.min.css">
           <!--main style sheet-->
           <link href="/website/sass/style.css" rel="stylesheet">

    @endif


    @stack("headStyle")

</head>
