@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Blog'))

@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Blog List</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Blog List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Start -->
    <section class="blog-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-4">
                <div class="col-xxl-12 col-xl-12 col-lg-12 order-lg-2">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="blog-box blog-list wow fadeInUp">
                                <div class="blog-image">
                                    <img src="{{asset('website/images/veg-3/home/19.jpg')}}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="blog-contain blog-contain-2">
                                    <div class="blog-label">
                                        <span class="time"><i data-feather="clock"></i> <span>25 Feg, 2022</span></span>

                                    </div>
                                    <a href="{{route('blog-details','test')}}">
                                        <h3>
                                            Sony Alpha a7 IV Mirrorless Digital Camera
                                        </h3>
                                    </a>
                                    <p>
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                    </p>
                                    <button  onclick="location.href='{{ route('blog-details', 'test') }}'"  class="blog-button">Read
                                        More <i class="fa-solid fa-right-long"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="blog-box blog-list wow fadeInUp">
                                <div class="blog-image">
                                    <img src="{{asset('website/images/veg-3/home/19.jpg')}}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="blog-contain blog-contain-2">
                                    <div class="blog-label">
                                        <span class="time"><i data-feather="clock"></i> <span>25 Feg, 2022</span></span>

                                    </div>
                                    <a href="{{route('blog-details','test')}}">
                                        <h3>
                                            Sony Alpha a7 IV Mirrorless Digital Camera
                                        </h3>
                                    </a>
                                    <p>
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                    </p>
                                    <button onclick="location.href='{{ route('blog-details', 'test') }}'" class="blog-button">Read
                                        More <i class="fa-solid fa-right-long"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="blog-box blog-list wow fadeInUp">
                                <div class="blog-image">
                                    <img src="{{asset('website/images/veg-3/home/19.jpg')}}" class="blur-up lazyload" alt="">
                                </div>

                                <div class="blog-contain blog-contain-2">
                                    <div class="blog-label">
                                        <span class="time"><i data-feather="clock"></i> <span>25 Feg, 2022</span></span>

                                    </div>
                                    <a href="{{route('blog-details','test')}}">
                                        <h3>
                                            Sony Alpha a7 IV Mirrorless Digital Camera
                                        </h3>
                                    </a>
                                    <p>
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                        Sony Alpha a7 IV Mirrorless Digital Camera
                                    </p>
                                    <button onclick="location.href='{{ route('blog-details', 'test') }}'" class="blog-button">Read
                                        More <i class="fa-solid fa-right-long"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav class="custome-pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                    <i class="fa-solid fa-angles-left"></i>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="javascript:void(0)">1</a>
                            </li>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="javascript:void(0)">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)">
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
