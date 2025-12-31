@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.login'))
@push("headScript")
    <script>
        (function () {
            var form = document.getElementById('loginForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Get message container
                    var messageDiv = document.getElementById('loginMessage');

                    // Hide previous messages
                    if (messageDiv) {
                        messageDiv.classList.add('d-none');
                        messageDiv.classList.remove('alert-success', 'alert-danger');
                    }

                    if (!form.checkValidity()) {
                        form.classList.add('was-validated');
                        return;
                    }

                    // Disable submit button during request
                    var submitBtn = form.querySelector('button[type="submit"]');
                    var originalBtnText = submitBtn ? submitBtn.innerHTML : '';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '{{ __("messages.Sending") }}...';
                    }

                    // Prepare form data
                    var formData = {
                        email: document.getElementById('email').value,
                        password: document.getElementById('password').value,
                        _token: '{{ csrf_token() }}'
                    };

                    var rememberMe = document.getElementById('rememberMe');
                    if (rememberMe && rememberMe.checked) {
                        formData.remember_me = '1';
                    }

                    // Submit form via AJAX
                    $.ajax({
                        url: '/api/web/login',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            // Trigger custom event for wishlist sync
                            $(document).trigger('userLoggedIn');
                            
                            // Small delay to ensure event is processed
                            setTimeout(function() {
                                window.location.href = '{{ route("web.home") }}?logged=success';
                            }, 100);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            var errorMessage = '{{ __("messages.An error occurred. Please try again.") }}';

                            // Try to get error message from response
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                var errors = '';
                                $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                    if (Array.isArray(errorArray)) {
                                        $.each(errorArray, function(index, error) {
                                            errors += error + '<br>';
                                        });
                                    } else {
                                        errors += errorArray + '<br>';
                                    }
                                });
                                errorMessage = errors;
                            }

                            if (messageDiv) {
                                messageDiv.classList.remove('d-none');
                                messageDiv.classList.add('alert-danger');
                                messageDiv.innerHTML = '<strong>{{ __("messages.Error") }}!</strong> ' + errorMessage;
                                messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                            }
                        },
                        complete: function() {
                            // Re-enable submit button
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnText;
                            }
                        }
                    });
                });
            }
        })();
    </script>
@endpush
@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2 class="mb-2">{{ __('messages.Login') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1">{{ __('messages.Login') }}</li>
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
                                <h3>{{ __('messages.Welcome Back') }}</h3>
                                <p class="text-content">{{ __('messages.Sign in to continue') }}</p>
                            </div>

                            <!-- Success/Error Messages Container -->
                            <div id="loginMessage" class="alert d-none mb-3" role="alert"></div>

                            <form class="row g-3" id="loginForm" novalidate>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="{{ __('messages.Email address') }}" required>
                                        <label for="email">{{ __('messages.Email address') }} *</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password" placeholder="{{ __('messages.Password') }}" required>
                                        <label for="password">{{ __('messages.Password') }} *</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="form-check ps-0 m-0 remember-box">
                                            <input class="checkbox_animated check-box" type="checkbox" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">{{ __('messages.Remember me') }}</label>
                                        </div>
                                        <a href="{{ route('web.forgot') ?? 'forgot.html' }}" class="forgot-password">{{ __('messages.Forgot Password?') }}</a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center" type="submit">{{ __('messages.Log In') }}</button>
                                </div>
                            </form>

                            <div class="sign-up-box">
                                <h4>{{ __('messages.Don\'t have an account?') }}</h4>
                                <a href="{{ route('web.register') }}">{{ __('messages.Create account') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

@endsection
