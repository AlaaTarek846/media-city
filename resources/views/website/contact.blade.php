@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.contactPage'))
@push('headScript')
    <style>
        .custom-form .form-control {
            transition: all 0.3s ease;
        }
        .custom-form .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6 .4.4.4-.4m0 4.8h-.8'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .custom-form .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .custom-form .form-control.is-valid {
            border-color: #198754;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.98-.98-.98-.98-.98.98.98.98zm3.25-3.25L8.03 6.73l.98-.98-3.5-3.5-.98.98z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }
        .custom-form .form-control.is-valid:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }
        .custom-form .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.5rem;
            font-size: 0.875em;
            color: #dc3545;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .custom-form .form-control.is-invalid ~ .invalid-feedback,
        .custom-form .form-control.is-invalid:focus ~ .invalid-feedback,
        .was-validated .custom-form .form-control:invalid ~ .invalid-feedback {
            display: block;
        }
        .custom-form .form-control.is-valid ~ .invalid-feedback,
        .custom-form .form-control.is-valid:focus ~ .invalid-feedback,
        .was-validated .custom-form .form-control:valid ~ .invalid-feedback {
            display: none;
        }
        .custom-form .form-label .text-danger {
            font-weight: bold;
            font-size: 1.1em;
        }
        .custom-form .custom-input,
        .custom-form .custom-textarea {
            position: relative;
        }
        .custom-form .custom-input i,
        .custom-form .custom-textarea i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            transition: color 0.3s ease;
            pointer-events: none;
        }
        .custom-form .custom-textarea i {
            top: 20px;
            transform: none;
        }
        .custom-form .form-control.is-invalid ~ i {
            color: #dc3545;
        }
        .custom-form .form-control.is-valid ~ i {
            color: #198754;
        }
    </style>
@endpush
@section('body')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{__('messages.Contact')}}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">{{__('messages.Contact')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Box Section Start -->
    <section class="contact-box-section">
        <div class="container-fluid-lg">
            <div class="row g-lg-5 g-3">
                <div class="col-lg-6">
                    <div class="left-sidebar-box">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="contact-image">
                                    <img src="{{asset('website/images/inner-page/contact-us.png')}}"
                                         class="img-fluid blur-up lazyloaded" alt="">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="contact-title">
                                    <h3>{{__('messages.GetInTouch')}}</h3>
                                </div>

                                <div class="contact-detail">
                                    <div class="row g-4">
                                        @if($contactUs && $contactUs->mobile)
                                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                                <div class="contact-detail-box">
                                                    <div class="contact-icon">
                                                        <i class="fa-solid fa-phone"></i>
                                                    </div>
                                                    <div class="contact-detail-title">
                                                        <h4>{{__('messages.Phone')}}</h4>
                                                    </div>
                                                    <div class="contact-detail-contain">
                                                        <p>{{ $contactUs->mobile }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($contactUs && $contactUs->email)
                                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                                <div class="contact-detail-box">
                                                    <div class="contact-icon">
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </div>
                                                    <div class="contact-detail-title">
                                                        <h4>{{__('messages.Email')}}</h4>
                                                    </div>
                                                    <div class="contact-detail-contain">
                                                        <p>{{ $contactUs->email }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($contactUs && $contactUs->address)
                                            <div class="col-12">
                                                <div class="contact-detail-box">
                                                    <div class="contact-icon">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                    </div>
                                                    <div class="contact-detail-title">
                                                        <h4>{{__('messages.Address')}}</h4>
                                                    </div>
                                                    <div class="contact-detail-contain">
                                                        <p>{!! $contactUs->address !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="title d-xxl-none d-block">
                        <h2>{{__('messages.Contact')}}</h2>
                    </div>
                    <div class="right-sidebar-box">
                        <!-- Contact Form - matching contact_messages table columns -->
                        <form id="contactForm" method="POST" novalidate>
                        @csrf

                        <!-- Success/Error Messages Container -->
                            <div id="contactMessage" class="alert d-none" role="alert"></div>

                            <div class="row">
                                <!-- Name Field - matches 'name' column in contact_messages table -->
                                <div class="col-12">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="name" class="form-label">{{__('messages.Name')}} <span class="text-danger">*</span></label>
                                        <div class="custom-input">
                                            <input type="text"
                                                   class="form-control"
                                                   id="name"
                                                   name="name"
                                                   placeholder="{{__('messages.Name')}}"
                                                   minlength="3"
                                                   maxlength="255"
                                                   required>
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <div class="invalid-feedback">{{__('messages.Name must be at least 3 characters')}}</div>
                                    </div>
                                </div>

                                <!-- Email Field - matches 'email' column in contact_messages table -->
                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="email" class="form-label">{{__('messages.Email Address')}} <span class="text-danger">*</span></label>
                                        <div class="custom-input">
                                            <input type="email"
                                                   class="form-control"
                                                   id="email"
                                                   name="email"
                                                   placeholder="{{__('messages.Email Address')}}"
                                                   maxlength="255"
                                                   required>
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                        <div class="invalid-feedback">{{__('messages.Please enter a valid email address')}}</div>
                                    </div>
                                </div>

                                <!-- Phone Field - matches 'phone' column in contact_messages table -->
                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="phone" class="form-label">{{__('messages.Phone')}} <span class="text-danger">*</span></label>
                                        <div class="custom-input">
                                            <input type="tel"
                                                   class="form-control"
                                                   id="phone"
                                                   name="phone"
                                                   placeholder="{{__('messages.Phone')}}"
                                                   pattern="^(01[0-9]{9}|201[0-9]{8}|\+20[0-9]{10})$"
                                                   required>
                                            <i class="fa-solid fa-mobile-screen-button"></i>
                                        </div>
                                        <div class="invalid-feedback">{{__('messages.Invalid Egyptian mobile number')}}</div>
                                    </div>
                                </div>

                                <!-- Subject Field - matches 'subject' column in contact_messages table -->
                                <div class="col-12">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="subject" class="form-label">{{__('messages.Subject')}} <span class="text-danger">*</span></label>
                                        <div class="custom-input">
                                            <input type="text"
                                                   class="form-control"
                                                   id="subject"
                                                   name="subject"
                                                   placeholder="{{__('messages.Subject')}}"
                                                   minlength="3"
                                                   maxlength="255"
                                                   required>
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                        <div class="invalid-feedback">{{__('messages.Subject must be at least 3 characters')}}</div>
                                    </div>
                                </div>

                                <!-- Message Field - matches 'message' column in contact_messages table -->
                                <div class="col-12">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="message" class="form-label">{{__('messages.Message')}} <span class="text-danger">*</span></label>
                                        <div class="custom-textarea">
                                            <textarea class="form-control"
                                                      id="message"
                                                      name="message"
                                                      placeholder="{{__('messages.Message')}}"
                                                      rows="6"
                                                      minlength="10"
                                                      required></textarea>
                                            <i class="fa-solid fa-message"></i>
                                        </div>
                                        <div class="invalid-feedback">{{__('messages.Message must be at least 10 characters')}}</div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-animation btn-md fw-bold ms-auto" id="submitBtn">
                                {{__('messages.Send')}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Box Section End -->

    <!-- Map Section Start -->
    <section class="map-section">
        <div class="container-fluid p-0">
            <div class="map-box">
                @if($contactUs && $contactUs->map)
                    {!! $contactUs->map !!}
                @else
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d2994.3803116994895!2d55.29773782339708!3d25.222534631321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m5!1s0x3e5f43496ad9c645%3A0xbde66e5084295162!2sDubai%20-%20United%20Arab%20Emirates!3m2!1d25.2048493!2d55.2707828!4m0!5e1!3m2!1sen!2sin!4v1652217109535!5m2!1sen!2sin"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                @endif
            </div>
        </div>
    </section>
    <!-- Map Section End -->
@endsection

@push('headScript')
    <!-- Contact Form AJAX Script - Loads after jQuery -->
    <script>
        // Wait for jQuery to be loaded before executing
        (function() {
            function initContactForm() {
                // Check if jQuery is available
                if (typeof jQuery === 'undefined') {
                    setTimeout(initContactForm, 100);
                    return;
                }

                var $ = jQuery; // Use jQuery instead of $

                $(document).ready(function() {
                    var form = document.getElementById('contactForm');
                    if (!form) return;

                    // Handle form submission with AJAX
                    $('#contactForm').on('submit', function(e) {
                        e.preventDefault(); // Prevent default form submission and page reload

                        // Validate Egyptian phone number first
                        var phone = document.getElementById('phone').value.trim();
                        var egyptianPhoneRegex = /^(01[0-9]{9}|201[0-9]{8}|\+20[0-9]{10})$/;
                        
                        if (!egyptianPhoneRegex.test(phone)) {
                            var phoneInput = document.getElementById('phone');
                            phoneInput.setCustomValidity('{{ __("messages.Invalid Egyptian mobile number") }}');
                            if (!form.checkValidity()) {
                                form.classList.add('was-validated');
                                phoneInput.focus();
                                phoneInput.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                                return;
                            }
                        } else {
                            document.getElementById('phone').setCustomValidity('');
                        }

                        // Check form validity
                        if (!form.checkValidity()) {
                            form.classList.add('was-validated');
                            return;
                        }

                        // Get form data
                        var formData = $(this).serialize();
                        var submitBtn = $('#submitBtn');
                        var messageDiv = $('#contactMessage');
                        var originalBtnText = submitBtn.text();

                        // Disable submit button during request to prevent double submission
                        submitBtn.prop('disabled', true).text('{{__("messages.Sending")}}...');

                        // Hide previous messages
                        messageDiv.addClass('d-none').removeClass('alert-success alert-danger');

                        // Send AJAX request to contactUsForm endpoint
                        $.ajax({
                            url: '/api/web/contact-us',
                            type: 'POST',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'Accept': 'application/json',
                                'lang': '{{app()->getLocale()}}',
                                'Accept-Language': '{{app()->getLocale()}}'
                            },
                            success: function(response) {
                                // Show success message
                                messageDiv
                                    .removeClass('d-none alert-danger')
                                    .addClass('alert-success')
                                    .html('<strong>{{__("messages.Success")}}!</strong> ' + response.message);

                                // Reset and clear all form fields after successful submission
                                form.reset();
                                form.classList.remove('was-validated');
                                document.getElementById('phone').setCustomValidity('');

                                // Scroll to message for better UX
                                $('html, body').animate({
                                    scrollTop: messageDiv.offset().top - 100
                                }, 500);
                            },
                            error: function(xhr) {
                                // Handle validation errors or server errors
                                var errorMessage = '{{__("messages.ThereIsAnErrorInTheSystem")}}';

                                // Check if response contains validation errors or custom message
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    // Display validation errors without exposing sensitive details
                                    var errors = '';
                                    $.each(xhr.responseJSON.errors, function(key, value) {
                                        errors += value[0] + '<br>';
                                    });
                                    errorMessage = errors;
                                }

                                // Show error message
                                messageDiv
                                    .removeClass('d-none alert-success')
                                    .addClass('alert-danger')
                                    .html('<strong>{{__("messages.Error")}}!</strong> ' + errorMessage);

                                // Scroll to message
                                $('html, body').animate({
                                    scrollTop: messageDiv.offset().top - 100
                                }, 500);
                            },
                            complete: function() {
                                // Re-enable submit button after request completes
                                submitBtn.prop('disabled', false).text(originalBtnText);
                            }
                        });
                    });
                });
            }

            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initContactForm);
            } else {
                initContactForm();
            }
        })();
    </script>
@endpush
