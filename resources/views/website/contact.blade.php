@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.contactPage'))
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
                        <form id="contactForm" method="POST">
                        @csrf

                        <!-- Success/Error Messages Container -->
                            <div id="contactMessage" class="alert d-none" role="alert"></div>

                            <div class="row">
                                <!-- Name Field - matches 'name' column in contact_messages table -->
                                <div class="col-12">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="name" class="form-label">{{__('messages.Name')}}</label>
                                        <div class="custom-input">
                                            <input type="text"
                                                   class="form-control"
                                                   id="name"
                                                   name="name"
                                                   placeholder="{{__('messages.Name')}}"
                                                   required>
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Field - matches 'email' column in contact_messages table -->
                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="email" class="form-label">{{__('messages.Email Address')}}</label>
                                        <div class="custom-input">
                                            <input type="email"
                                                   class="form-control"
                                                   id="email"
                                                   name="email"
                                                   placeholder="{{__('messages.Email Address')}}"
                                                   required>
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone Field - matches 'phone' column in contact_messages table -->
                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="phone" class="form-label">{{__('messages.Phone')}}</label>
                                        <div class="custom-input">
                                            <input type="tel"
                                                   class="form-control"
                                                   id="phone"
                                                   name="phone"
                                                   placeholder="{{__('messages.Phone')}}"
                                                   required>
                                            <i class="fa-solid fa-mobile-screen-button"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subject Field - matches 'subject' column in contact_messages table -->
                                <div class="col-12">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="subject" class="form-label">{{__('messages.Subject')}}</label>
                                        <div class="custom-input">
                                            <input type="text"
                                                   class="form-control"
                                                   id="subject"
                                                   name="subject"
                                                   placeholder="{{__('messages.Subject')}}"
                                                   required>
                                            <i class="fa-solid fa-tag"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Field - matches 'message' column in contact_messages table -->
                                <div class="col-12">
                                    <div class="mb-md-4 mb-3 custom-form">
                                        <label for="message" class="form-label">{{__('messages.Message')}}</label>
                                        <div class="custom-textarea">
                                            <textarea class="form-control"
                                                      id="message"
                                                      name="message"
                                                      placeholder="{{__('messages.Message')}}"
                                                      rows="6"
                                                      required></textarea>
                                            <i class="fa-solid fa-message"></i>
                                        </div>
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
                    // Handle form submission with AJAX
                    $('#contactForm').on('submit', function(e) {
                        e.preventDefault(); // Prevent default form submission and page reload

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
                                $('#contactForm')[0].reset();

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
