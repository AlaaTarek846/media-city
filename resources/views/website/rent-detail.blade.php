@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Thank You'))
@section('body')
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Studio Details</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Studio Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="row g-4">
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="product-left-box">
                                <div class="row g-2">
                                    <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                        <div class="product-main-2 no-arrow" id="studioMainSlider">
                                            <div>
                                                <div class="slider-image">
                                                    <img src="/website/images/151.jpeg" class="img-fluid blur-up lazyload" alt="Studio - Main 1">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="slider-image">
                                                    <img src="/website/images/152.jpeg" class="img-fluid blur-up lazyload" alt="Studio - Main 2">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="slider-image">
                                                    <img src="/website/images/153.jpeg" class="img-fluid blur-up lazyload" alt="Studio - Main 3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                        <div class="left-slider-image-2 left-slider no-arrow slick-top" id="studioThumbSlider">
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="/website/images/veg-3/banner/1.png" class="img-fluid blur-up lazyload" alt="Studio - Thumb 1">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="/website/images/veg-3/banner/2.png" class="img-fluid blur-up lazyload" alt="Studio - Thumb 2">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="/website/images/veg-3/banner/3.png" class="img-fluid blur-up lazyload" alt="Studio - Thumb 3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="right-box-contain">
                                <h6 class="offer-top">Available Now</h6>
                                <h2 class="name">MediaCity Studio (Photo & Video)</h2>

                                <div class="price-rating">
                                    <h3 class="theme-color price">EGP 800 <span class="text-content">/ hour</span></h3>
                                    <div class="product-rating custom-rate">
                                        <ul class="rating">
                                            <li><i data-feather="star" class="fill"></i></li>
                                            <li><i data-feather="star" class="fill"></i></li>
                                            <li><i data-feather="star" class="fill"></i></li>
                                            <li><i data-feather="star" class="fill"></i></li>
                                            <li><i data-feather="star"></i></li>
                                        </ul>
                                        <span class="review">Professional setup</span>
                                    </div>
                                </div>

                                <div class="procuct-contain">
                                    <p>Fully-equipped studio for photo & video shoots. Clean setup, pro lighting options, and flexible booking.</p>
                                </div>

                                <div class="pickup-box">
                                    <div class="product-title">
                                        <h4>Studio Features</h4>
                                    </div>

                                    <div class="product-info">
                                        <ul class="product-info-list product-info-list-2">
                                            <li>Space : <a href="javascript:void(0)">60 m²</a></li>
                                            <li>Backdrop : <a href="javascript:void(0)">White / Black</a></li>
                                            <li>Lighting : <a href="javascript:void(0)">Softbox + Continuous</a></li>
                                            <li>Power : <a href="javascript:void(0)">Multiple outlets</a></li>
                                            <li>Extras : <a href="javascript:void(0)">Tripods, Stands</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="note-box product-packege">
                                    <a href="#rentForm" class="btn btn-md bg-dark cart-button text-white w-100" id="rentNowBtn">Rent Now</a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-box-section" id="rentForm">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Rental Request</h2>
            </div>

            <div class="row g-lg-5 g-3">
                <div class="col-lg-7">
                    <div class="right-sidebar-box">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating theme-form-floating" style="margin-top: 21px;">
                                    <input type="text" class="form-control" id="rentName" placeholder="Full name" required>
                                    <label for="rentName">Full name</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating"  style="margin-top: 21px;">
                                    <input type="email" class="form-control" id="rentEmail" placeholder="Email" required>
                                    <label for="rentEmail">Email</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating"  style="margin-top: 21px;">
                                    <input type="tel" class="form-control" id="rentPhone" placeholder="Phone" required>
                                    <label for="rentPhone">Phone</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating"  style="margin-top: 21px;">
                                    <input type="date" class="form-control" id="rentDate" required>
                                    <label for="rentDate">Date</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating"  style="margin-top: 21px;">
                                    <input type="time" class="form-control" id="rentTime" required>
                                    <label for="rentTime">Start time</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating"  style="margin-top: 21px;">
                                    <select class="form-select" id="rentDuration" required>
                                        <option value="" selected disabled>Select duration</option>
                                        <option value="1">1 hour</option>
                                        <option value="2">2 hours</option>
                                        <option value="3">3 hours</option>
                                        <option value="4">4 hours</option>
                                        <option value="8">Full day</option>
                                    </select>
                                    <label for="rentDuration">Duration</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating"  style="margin-top: 21px;">
                                    <select class="form-select" id="rentPurpose" required>
                                        <option value="" selected disabled>Select purpose</option>
                                        <option value="photo">Photo shoot</option>
                                        <option value="video">Video shoot</option>
                                        <option value="podcast">Podcast</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <label for="rentPurpose">Purpose</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating"  style="margin-top: 21px;">
                                    <textarea class="form-control" placeholder="Message" id="rentMessage" style="height: 140px"></textarea>
                                    <label for="rentMessage">Notes (optional)</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-animation btn-md fw-bold ms-auto" type="button" id="rentSubmit">Submit Request</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="left-sidebar-box">
                        <div class="contact-title">
                            <h3>Booking Notes</h3>
                        </div>
                        <div class="contact-detail">
                            <div class="contact-detail-box">
                                <div class="contact-icon">
                                    <i data-feather="clock"></i>
                                </div>
                                <div class="contact-detail-title">
                                    <h4>Hours</h4>
                                    <p>Daily 10:00 AM - 12:00 AM</p>
                                </div>
                            </div>

                            <div class="contact-detail-box">
                                <div class="contact-icon">
                                    <i data-feather="map-pin"></i>
                                </div>
                                <div class="contact-detail-title">
                                    <h4>Location</h4>
                                    <p>MediaCity Studio, Cairo</p>
                                </div>
                            </div>

                            <div class="contact-detail-box">
                                <div class="contact-icon">
                                    <i data-feather="phone"></i>
                                </div>
                                <div class="contact-detail-title">
                                    <h4>Contact</h4>
                                    <p>+20 10 0000 0000</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
