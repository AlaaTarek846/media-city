@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Forgot Password?'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@push("headScript")
    <script>
        (function () {
            var form = document.getElementById('forgotForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Get message container
                    var messageDiv = document.getElementById('forgotMessage');

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
                        _token: '{{ csrf_token() }}'
                    };

                    // Submit form via AJAX
                    $.ajax({
                        url: '/api/web/password/email',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            // Show success message
                            if (messageDiv) {
                                messageDiv.classList.remove('d-none');
                                messageDiv.classList.add('alert-success');
                                messageDiv.innerHTML = '<strong>{{ __("messages.Success") }}!</strong> ' + (data.message || '{{ __("passwords.sent") }}');
                                messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                            }
                            // Reset form
                            form.reset();
                            form.classList.remove('was-validated');
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
                        <h2>{{ __('messages.Forgot Password?') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1">{{ __('messages.Forgot Password?') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section auth-section section-b-space forgot-section">
        <div class="container-fluid-lg w-100">
            <div class="row g-4 align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 d-lg-block d-none">
                    <div class="image-contain">
                        <img src="{{asset('website/images/inner-page/forgot.png')}}" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-5 col-xl-6 col-lg-6 col-sm-10 mx-auto">
                    <div class="auth-card">
                        <div class="auth-card-body">
                            <div class="auth-title">
                                <h3>{{ __('messages.Reset your password') }}</h3>
                                <p class="text-content">{{ __('messages.Enter your email and we will send you a password reset link') }}</p>
                            </div>

                            <!-- Success/Error Messages Container -->
                            <div id="forgotMessage" class="alert d-none mb-3" role="alert"></div>

                            <form class="row g-3" id="forgotForm" novalidate>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="{{ __('messages.Email address') }}" required>
                                        <label for="email">{{ __('messages.Email address') }} *</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center" type="submit">{{ __('messages.Send Reset Link') }}</button>
                                </div>

                                <div class="col-12">
                                    <div class="sign-up-box">
                                        <h4>{{ __('messages.Remembered your password?') }}</h4>
                                        <a href="{{ route('web.login') }}">{{ __('messages.Back to login') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

@endsection
