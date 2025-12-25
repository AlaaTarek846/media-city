
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

@include('website.layouts.headStyle')

<body class="theme-color-2 bg-effect">

<!-- Loader Start -->
<!-- <div class="fullpage-loader">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div> -->
<!-- Loader End -->

@include('website.layouts.header')

@yield('body')



@include('website.layouts.footer')



<!-- latest jquery-->
<script src="{{asset('website/js/jquery-3.6.0.min.js')}}"></script>

<!-- jquery ui-->
<script src="{{asset('website/js/jquery-ui.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('website/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('website/js/bootstrap/popper.min.js')}}"></script>

<!-- feather icon js-->
<script src="{{asset('website/js/feather/feather.min.js')}}"></script>
<script src="{{asset('website/js/feather/feather-icon.js')}}"></script>

<!-- Lazyload Js -->
<script src="{{asset('website/js/lazysizes.min.js')}}"></script>

<!-- Slick js-->
<script src="{{asset('website/js/slick/slick.js')}}"></script>
<script src="{{asset('website/js/bootstrap/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('website/js/slick/custom_slick.js')}}"></script>

<!-- Auto Height Js -->
<script src="{{asset('website/js/auto-height.js')}}"></script>

<!-- Quantity Js -->
<script src="{{asset('website/js/quantity.js')}}"></script>

<!-- Timer Js -->
<script src="{{asset('website/js/timer1.js')}}"></script>
<script src="{{asset('website/js/timer2.js')}}"></script>
<script src="{{asset('website/js/timer3.js')}}"></script>
<script src="{{asset('website/js/timer4.js')}}"></script>

<!-- Fly Cart Js -->
<script src="{{asset('website/js/fly-cart.js')}}"></script>

<!-- WOW js -->
<script src="{{asset('website/js/wow.min.js')}}"></script>
<script src="{{asset('website/js/custom-wow.js')}}"></script>

<!-- script js -->
<script src="{{asset('website/js/script.js')}}"></script>




</body>

</html>

