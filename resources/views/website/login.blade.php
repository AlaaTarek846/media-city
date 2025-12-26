@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.login'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2 class="mb-2">Log In</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Log In</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section auth-section background-image-2 section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row g-4 align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 d-lg-block d-none">
                    <div class="image-contain">
                        <img src="{{asset('website/images/inner-page/log-in.png')}}" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-5 col-xl-6 col-lg-6 col-sm-10 mx-auto">
                    <div class="auth-card">
                        <div class="auth-card-body">
                            <div class="auth-title">
                                <h3>Welcome Back</h3>
                                <p class="text-content">Sign in to continue to MediaCity.</p>
                            </div>

                            <form class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password" placeholder="Password" required>
                                        <label for="password">Password</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="form-check ps-0 m-0 remember-box">
                                            <input class="checkbox_animated check-box" type="checkbox" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                        </div>
                                        <a href="forgot.html" class="forgot-password">Forgot Password?</a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center" type="submit">Log In</button>
                                </div>
                            </form>

                            <div class="other-log-in">
                                <h6>or</h6>
                            </div>

                            <div class="log-in-button">
                                <ul>
                                    <li>
                                        <a href="https://www.google.com/" class="btn google-button w-100">
                                            <img src="{{asset('website/images/inner-page/google.png')}}" class="blur-up lazyload" alt=""> Log In with Google
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.facebook.com/" class="btn google-button w-100">
                                            <img src="{{asset('website/images/inner-page/facebook.png')}}" class="blur-up lazyload" alt=""> Log In with Facebook
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="sign-up-box">
                                <h4>Don't have an account?</h4>
                                <a href="{{url('register')}}">Create account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

@endsection
