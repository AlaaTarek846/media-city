@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.register_new_account'))
@push("headScript")
    <style>
        .account-type-option .check-icon {
            display: none;
        }
        .btn-check:checked + .account-type-option .check-icon {
            display: block;
        }
        #termsError {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        #terms.is-invalid {
            border-color: #dc3545;
        }
        .form-check #terms.is-invalid + label {
            color: #dc3545;
        }
    </style>
    <script>
        (function () {
            function setBusinessVisibility(accountType) {
                var isPerson = accountType === 'person';
                var isCompany = accountType === 'company';

                // Update full name label based on account type
                var fullNameLabel = document.getElementById('fullNameLabel');
                var fullNameInput = document.getElementById('fullName');
                if (fullNameLabel && fullNameInput) {
                    var labelText = '';
                    var placeholderText = '';

                    if (accountType === 'person') {
                        labelText = fullNameLabel.getAttribute('data-person');
                        placeholderText = fullNameLabel.getAttribute('data-person');
                    } else if (accountType === 'company') {
                        labelText = fullNameLabel.getAttribute('data-company');
                        placeholderText = fullNameLabel.getAttribute('data-company');
                    } else if (accountType === 'studio') {
                        labelText = fullNameLabel.getAttribute('data-studio');
                        placeholderText = fullNameLabel.getAttribute('data-studio');
                    }

                    if (labelText) {
                        fullNameLabel.textContent = labelText + ' *';
                        fullNameInput.setAttribute('placeholder', placeholderText);
                    }
                }
            }

            var accountRadios = document.querySelectorAll('input[name="accountType"]');
            function getSelectedType() {
                var checked = document.querySelector('input[name="accountType"]:checked');
                return checked ? checked.value : 'person';
            }

            // Function to update check icons visibility
            function updateCheckIcons() {
                accountRadios.forEach(function (radio) {
                    var label = document.querySelector('label[for="' + radio.id + '"]');
                    var checkIcon = label ? label.querySelector('.check-icon') : null;
                    if (checkIcon) {
                        if (radio.checked) {
                            checkIcon.style.display = 'block';
                        } else {
                            checkIcon.style.display = 'none';
                        }
                    }
                });
                // Re-initialize feather icons after visibility change
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }

            accountRadios.forEach(function (r) {
                r.addEventListener('change', function () {
                    setBusinessVisibility(getSelectedType());
                    updateCheckIcons();
                });
            });
            setBusinessVisibility(getSelectedType());
            updateCheckIcons();

            // Add event listener to terms checkbox to hide error when checked
            var termsCheckbox = document.getElementById('terms');
            var termsError = document.getElementById('termsError');
            if (termsCheckbox) {
                termsCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        if (termsError) {
                            termsError.style.display = 'none';
                        }
                        this.classList.remove('is-invalid');
                    }
                });
            }

            var form = document.getElementById('registerForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validate terms checkbox
                    var termsCheckbox = document.getElementById('terms');
                    var termsError = document.getElementById('termsError');
                    if (!termsCheckbox.checked) {
                        if (termsError) {
                            termsError.style.display = 'block';
                        }
                        if (termsCheckbox) {
                            termsCheckbox.classList.add('is-invalid');
                        }
                        form.classList.add('was-validated');
                        termsCheckbox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        return;
                    } else {
                        if (termsError) {
                            termsError.style.display = 'none';
                        }
                        if (termsCheckbox) {
                            termsCheckbox.classList.remove('is-invalid');
                        }
                    }

                    if (!form.checkValidity()) {
                        form.classList.add('was-validated');
                        return;
                    }

                    // Get message container
                    var messageDiv = document.getElementById('registerMessage');

                    // Hide previous messages
                    if (messageDiv) {
                        messageDiv.classList.add('d-none');
                        messageDiv.classList.remove('alert-success', 'alert-danger');
                    }

                    // Validate password confirmation
                    var password = document.getElementById('password').value;
                    var confirmation = document.getElementById('confirmation').value;
                    if (password !== confirmation) {
                        if (messageDiv) {
                            messageDiv.classList.remove('d-none');
                            messageDiv.classList.add('alert-danger');
                            messageDiv.innerHTML = '<strong>{{ __("messages.Error") }}!</strong> {{ __("messages.Password confirmation does not match") }}';
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                        return;
                    }

                    // Validate Egyptian phone numbers
                    var mobile = document.getElementById('mobile').value.trim();
                    var whatsapp = document.getElementById('whatsapp').value.trim();
                    var egyptianPhoneRegex = /^(01[0-9]{9}|201[0-9]{8}|\+20[0-9]{10})$/;

                    if (!egyptianPhoneRegex.test(mobile)) {
                        if (messageDiv) {
                            messageDiv.classList.remove('d-none');
                            messageDiv.classList.add('alert-danger');
                            messageDiv.innerHTML = '<strong>{{ __("messages.Error") }}!</strong> {{ __("messages.Invalid Egyptian mobile number") }}';
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                        document.getElementById('mobile').focus();
                        return;
                    }

                    if (!egyptianPhoneRegex.test(whatsapp)) {
                        if (messageDiv) {
                            messageDiv.classList.remove('d-none');
                            messageDiv.classList.add('alert-danger');
                            messageDiv.innerHTML = '<strong>{{ __("messages.Error") }}!</strong> {{ __("messages.Invalid Egyptian WhatsApp number") }}';
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                        document.getElementById('whatsapp').focus();
                        return;
                    }

                    // Get selected user type
                    var userType = getSelectedType();

                    // Prepare form data
                    var formData = {
                        user_type: userType,
                        name: document.getElementById('fullName').value,
                        email: document.getElementById('email').value,
                        mobile: document.getElementById('mobile').value,
                        whatsapp: document.getElementById('whatsapp').value,
                        password: document.getElementById('password').value,
                        confirmation: document.getElementById('confirmation').value,
                        _token: '{{ csrf_token() }}'
                    };

                    // Add how_did_you_hear_about_us if available
                    var howDidYouHear = document.getElementById('howDidYouHear');
                    if (howDidYouHear && howDidYouHear.value) {
                        formData.how_did_you_hear_about_us = howDidYouHear.value;
                    }

                    // Disable submit button during request
                    var submitBtn = form.querySelector('button[type="submit"]');
                    var originalBtnText = submitBtn ? submitBtn.innerHTML : '';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '{{ __("messages.Sending") }}...';
                    }

                    // Submit form via AJAX
                    $.ajax({
                        url: '/api/web/register',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            window.location.href = '{{ route("web.home") }}?registered=success';
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
                        <h2>{{ __('messages.register_new_account') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1">{{ __('messages.register_new_account') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section auth-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row g-4 align-items-center">
                <div class="col-xxl-5 col-xl-6 col-lg-6 d-lg-block d-none">
                    <div class="image-contain">
                        <img src="{{asset('website/images/inner-page/sign-up.png')}}" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-7 col-xl-6 col-lg-6 col-sm-11 mx-auto">
                    <div class="auth-card">
                        <div class="auth-card-body">
                            <div class="auth-title">
                                <h3>{{ __('messages.Create your account') }}</h3>
                                <p class="text-content">{{ __('messages.Fill in your information to complete registration') }}</p>
                            </div>

                            <!-- Success/Error Messages Container -->
                            <div id="registerMessage" class="alert d-none mb-3" role="alert"></div>

                            <form class="row g-3" id="registerForm" novalidate>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <strong>{{ __('messages.Account type') }}</strong>
                                    </div>

                                    <div class="account-type-grid">
                                        <div>
                                            <input class="btn-check" type="radio" name="accountType" id="typePerson" value="person" checked>
                                            <label class="account-type-option" for="typePerson">
                                                <div class="left">
                                                    <div class="icon"><i data-feather="user"></i></div>
                                                    <div class="text">
                                                        <h6>{{ __('messages.Person') }}</h6>
                                                        <small>{{ __('messages.Individual') }}</small>
                                                    </div>
                                                </div>
                                                <i class="check-icon" data-feather="check"></i>
                                            </label>
                                        </div>

                                        <div>
                                            <input class="btn-check" type="radio" name="accountType" id="typeCompany" value="company">
                                            <label class="account-type-option" for="typeCompany">
                                                <div class="left">
                                                    <div class="icon"><i data-feather="briefcase"></i></div>
                                                    <div class="text">
                                                        <h6>{{ __('messages.Company') }}</h6>
                                                        <small>{{ __('messages.Business') }}</small>
                                                    </div>
                                                </div>
                                                <i class="check-icon" data-feather="check"></i>
                                            </label>
                                        </div>

                                        <div>
                                            <input class="btn-check" type="radio" name="accountType" id="typeStudio" value="studio">
                                            <label class="account-type-option" for="typeStudio">
                                                <div class="left">
                                                    <div class="icon"><i data-feather="camera"></i></div>
                                                    <div class="text">
                                                        <h6>{{ __('messages.Studio') }}</h6>
                                                        <small>{{ __('messages.Production') }}</small>
                                                    </div>
                                                </div>
                                                <i class="check-icon" data-feather="check"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="fullName" placeholder="{{ __('messages.Full name') }}" required>
                                        <label for="fullName" id="fullNameLabel" data-person="{{ __('messages.Full name') }}" data-company="{{ __('messages.Company name') }}" data-studio="{{ __('messages.Studio name') }}">{{ __('messages.Full name') }} *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="tel" class="form-control" id="mobile" placeholder="{{ __('messages.Mobile number') }}" pattern="^(01[0-9]{9}|201[0-9]{8}|\+20[0-9]{10})$" required>
                                        <label for="mobile">{{ __('messages.Mobile number') }} *</label>
                                        <div class="invalid-feedback">{{ __('messages.Invalid Egyptian mobile number') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="tel" class="form-control" id="whatsapp" placeholder="{{ __('messages.WhatsApp number') }}" pattern="^(01[0-9]{9}|201[0-9]{8}|\+20[0-9]{10})$" required>
                                        <label for="whatsapp">{{ __('messages.WhatsApp number') }} *</label>
                                        <div class="invalid-feedback">{{ __('messages.Invalid Egyptian WhatsApp number') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="{{ __('messages.Email address') }}" required>
                                        <label for="email">{{ __('messages.Email address') }} *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <select class="form-select" id="howDidYouHear" required>
                                            <option value="" selected disabled>{{ __('messages.Select') }}</option>
                                            <option value="facebook">{{ __('messages.Facebook') }}</option>
                                            <option value="instagram">{{ __('messages.Instagram') }}</option>
                                            <option value="tiktok">{{ __('messages.TikTok') }}</option>
                                            <option value="linkedin">{{ __('messages.Linkedin') }}</option>
                                            <option value="youtube">{{ __('messages.Youtube') }}</option>
                                            <option value="google">{{ __('messages.Google') }}</option>
                                            <option value="friend">{{ __('messages.Friend / Referral') }}</option>
                                            <option value="other">{{ __('messages.Other') }}</option>
                                        </select>
                                        <label for="howDidYouHear">{{ __('messages.How did you hear about us?') }}</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password" placeholder="{{ __('messages.Password') }}" required>
                                        <label for="password">{{ __('messages.Password') }} *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="confirmation" placeholder="{{ __('messages.Confirm Password') }}" required>
                                        <label for="confirmation">{{ __('messages.Confirm Password') }} *</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check ps-0 m-0 remember-box">
                                        <input class="checkbox_animated check-box" type="checkbox" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            <a href="{{ route('terms-condition') }}" target="_blank">
                                                {{ __('messages.I agree with Terms and Privacy') }}
                                            </a>
                                        </label>
                                        <div class="invalid-feedback d-block" id="termsError" style="display: none !important;">
                                            {{ __('messages.Please agree to Terms and Privacy') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center" type="submit">{{ __('messages.Create account') }}</button>
                                </div>
                            </form>

                            <div class="sign-up-box">
                                <h4>{{ __('messages.Already have an account?') }}</h4>
                                <a href="{{ route('web.login') }}">{{ __('messages.Log In') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

@endsection

