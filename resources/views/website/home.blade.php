@extends('website.layouts.layoutPage')
@section('pageTitle', __('messages.HomePage'))
@push("headStyle")

@endpush
@push("headScript")
    <script>
        (function() {
            // Check if user just registered, logged in, or reset password
            var urlParams = new URLSearchParams(window.location.search);
            var message = '';

            if (urlParams.get('registered') === 'success') {
                message = '{{ __("messages.Registration successful") }}';
            } else if (urlParams.get('logged') === 'success') {
                message = '{{ __("messages.Logged in Successfully") }}';
            } else if (urlParams.get('password_reset') === 'success') {
                message = '{{ __("messages.Password reset successful") }}';
            }

            if (message) {
                // Create success message
                var messageDiv = document.createElement('div');
                messageDiv.className = 'alert alert-success alert-dismissible fade show';
                messageDiv.setAttribute('role', 'alert');
                messageDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 500px;';
                messageDiv.innerHTML = '<strong>{{ __("messages.Success") }}!</strong> ' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

                document.body.appendChild(messageDiv);

                // Auto remove after 5 seconds
                setTimeout(function() {
                    if (messageDiv.parentNode) {
                        messageDiv.classList.remove('show');
                        setTimeout(function() {
                            messageDiv.remove();
                        }, 300);
                    }
                }, 5000);

                // Clean URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        })();
    </script>
@endpush
@section('body')

    <!-- home section start -->
    <section class="hero-slider" style="padding-top: 0px;">
        <div class="slider" id="heroSlider">
            <div class="slides">
                <div class="slide active">
                    <img src="{{asset('website/images/veg-3/home-bg.png')}}" alt="Slide 1">
                </div>
                <div class="slide">
                    <img src="{{asset('website/images/veg-3/shape/background.png')}}" alt="Slide 2">
                </div>
                <div class="slide">
                    <img src="{{asset('website/images/veg-3/home-bg.png')}}" alt="Slide 3">
                </div>
            </div>

            <!-- Arrows -->
            <button class="nav prev" type="button" aria-label="Previous slide">‹</button>
            <button class="nav next" type="button" aria-label="Next slide">›</button>
        </div>
    </section>

    <!-- Home Section End -->

    <section class="category-section-3">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>{{ __('messages.Shop By Categories') }}</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="category-slider-1 arrow-slider wow fadeInUp">
                        @if(isset($shopByDepartment) && $shopByDepartment?->categories->count() > 0)
                            @foreach($shopByDepartment->categories as $category)
                                @php
                                    $categoryTranslation = $category->translation ?? $category->translations->first();
                                    $categoryUrl = url('/shop/' . $shopByDepartment->slug . '/' . $category->slug);
                                @endphp
                                @if($categoryTranslation)
                        <div>
                            <div class="category-box-list">
                                            <a href="{{ $categoryUrl }}" class="category-name">
                                                <h4>{{ $categoryTranslation->title }}</h4>
                                </a>
                                <div class="category-box-view">
                                                <a href="{{ $categoryUrl }}">
                                                    @if($category->image)
                                                        <img src="{{ $category->image }}"
                                                             class="img-fluid blur-up lazyload"
                                                             alt="{{ $categoryTranslation->title }}">
                                                    @else
                                                        <img src="{{ asset('website/svg/1/Cinema-camera.png') }}"
                                                             class="img-fluid blur-up lazyload"
                                                             alt="{{ $categoryTranslation->title }}">
                                                    @endif
                                    </a>
                                                <button onclick="location.href = '{{ $categoryUrl }}';" class="btn shop-button">
                                                    <span>{{ __('messages.shop now') }}</span>
                                                    @if(app()->getLocale() == 'en')
                                        <i class="fas fa-angle-right"></i>
                                                    @else
                                                        <i class="fas fa-angle-left"></i>
                                                    @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Deal Section Start -->
    <section class="deal-section">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>{{ __('messages.Deal Of The Day') }}</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="three-slider-1 arrow-slider">
                        @if(isset($dealProducts) && $dealProducts->count() > 0)
                            @foreach($dealProducts as $index => $product)
                                @php
                                    $translation = $product->translation ?? $product->translations->first();
                                    $variant = $product->variants->first();
                                    $productUrl = route('productDetail', ['id' => $translation->slug ?? $product->id]);
                                    $rating = round($product->rate ?? 0);
                                    $discountPrice = $variant->price ?? 0;
                                    $originalPrice = $variant->price_before_discount > 0 ? $variant->price_before_discount : ($variant->price ?? 0);
                                    $discountPercentage = $variant->discount_percentage ?? 0;
                                    $wowDelay = $index * 0.05;
                                    $timerId = 'clockdiv-' . ($index + 1);
                                @endphp
                                @if($translation && $variant && $discountPercentage > 0)
                        <div>
                                        <div class="deal-box wow fadeInUp" @if($index > 0) data-wow-delay="{{ $wowDelay }}s" @endif>
                                            <a href="{{ $productUrl }}" class="category-image order-sm-2">
                                                <img src="{{ $product->image }}"
                                                     class="img-fluid blur-up lazyload"
                                                     alt="{{ $translation->title }}">
                                </a>

                                <div class="deal-detail order-sm-1">
                                    <div class="hot-deal">
                                                    <span>{{ __('messages.Hot Deals') }}</span>
                                    </div>
                                    <ul class="rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                        <li>
                                                            <i data-feather="star" class="{{ $i <= $rating ? 'fill' : '' }}"></i>
                                        </li>
                                                    @endfor
                                    </ul>
                                                <a href="{{ $productUrl }}" class="text-title">
                                                    <h5>{{ $translation->title }}</h5>
                                    </a>
                                                <h5 class="price">
                                                    {{ __('messages.currency') }} {{ number_format($discountPrice, 2) }}
                                                    <span>{{ __('messages.currency') }} {{ number_format($originalPrice, 2) }}</span>
                                                </h5>
                                    <div class="progress custom-progressbar">
                                                    <div class="progress-bar"
                                                         style="width: {{ min(100, max(10, $discountPercentage)) }}%"
                                                         role="progressbar"
                                                         aria-valuenow="{{ $discountPercentage }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                    </div>
                                                <h4 class="offer">{{ __('messages.Hurry up offer end in') }}</h4>
                                                <div class="timer" id="{{ $timerId }}" data-hours="24" data-minutes="0" data-seconds="0">
                                        <ul>
                                            <li>
                                                <div class="counter">
                                                    <div class="days">
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="counter">
                                                    <div class="hours">
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="counter">
                                                    <div class="minutes">
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="counter">
                                                    <div class="seconds">
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                                @endif
                            @endforeach
                        @endif
                                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Deal Section End -->

    <!-- Product Sction Start -->
    <section class="studio-rent-section">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Studio Rental</h2>
            </div>
            <div class="row g-4 align-items-center">
                <div class="col-xl-7">
                    <div class="studio-rent-slider">
                        <div>
                            <div class="studio-rent-slide">
                                <img src="{{asset('website/images/151.jpeg')}}" class="img-fluid blur-up lazyload" alt="Studio - Slide 1">
                            </div>
                        </div>
                        <div>
                            <div class="studio-rent-slide">
                                <img src="{{asset('website/images/152.jpeg')}}" class="img-fluid blur-up lazyload" alt="Studio - Slide 2">
                            </div>
                        </div>
                        <div>
                            <div class="studio-rent-slide">
                                <img src="{{asset('website/images/153.jpg')}}" class="img-fluid blur-up lazyload" alt="Studio - Slide 3">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-5">
                    <div class="studio-rent-content">
                        <div class="title">
                            <h2>Studio For Rent</h2>
                        </div>
                        <p class="studio-rent-text">
                            Fully-equipped studio for photo & video shoots. Clean setup, pro lighting options, and flexible booking.
                        </p>
                        <div class="studio-rent-meta">
                            <span class="badge theme-bg-color text-white">Available Now</span>
                            <span class="ms-2">Hourly / Daily</span>
                        </div>
                        <div class="mt-3">
                            <a href="studio-details.html" class="btn theme-bg-color text-white btn-md">
                                Rent This Studio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Sction End -->

    <section class="section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-12 col-lg-12">
                    <div class="title d-block">
                        <h2 class="text-theme font-sm">{{ __('messages.Best Seller') }}</h2>
                        <p>{{ __('messages.A virtual assistant collects the products from your list') }}</p>
                    </div>
                    <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3 row-cols-2 g-sm-4 g-3 no-arrow section-b-space">
                        @if(isset($bestSellerProducts) && $bestSellerProducts->count() > 0)
                            @foreach($bestSellerProducts->take(10) as $index => $product)
                                @php
                                    $translation = $product->translation ?? $product->translations->first();
                                    $variant = $product->variants->first();
                                    $productUrl = route('productDetail', ['id' => $translation->slug ?? $product->id]);
                                    $categoryTranslation = $product->category->translation ?? $product->category->translations->first() ?? null;
                                    
                                    // Condition badge logic
                                    $conditionLabel = '';
                                    $conditionClass = '';
                                    $showBadge = false;
                                    if ($product->department) {
                                        if ($product->department->id == 2) {
                                            if ($product->condition === 'new') {
                                                $conditionLabel = __('messages.New');
                                                $conditionClass = 'bg-success';
                                                $showBadge = true;
                                            } elseif ($product->condition === 'used') {
                                                $conditionLabel = __('messages.Used');
                                                $conditionClass = 'bg-info';
                                                $showBadge = true;
                                            }
                                        } elseif ($product->department->id == 1 && $product->condition === 'rent') {
                                            $conditionLabel = __('messages.Rent');
                                            $conditionClass = 'bg-warning';
                                            $showBadge = true;
                                        }
                                    }
                                    
                                    $rating = round($product->rate ?? 0);
                                    $wowDelay = ($index % 4 == 0) ? 0 : ($index % 4) * 0.1;
                                @endphp
                                @if($translation && $variant)
                        <div>
                                        <div class="product-box-3 wow fadeInUp" @if($wowDelay > 0) data-wow-delay="{{ $wowDelay }}s" @endif>
                                            <div class="product-header product-box">
                                                @if($showBadge && $conditionLabel)
                                                    <div class="label-tag {{ $conditionClass }}">
                                                        <span>{{ $conditionLabel }}</span>
                                </div>
                                                @endif
                                <div class="product-image">
                                                    <a href="{{ $productUrl }}">
                                                        <img src="{{ $product->image }}" 
                                                             class="img-fluid blur-up lazyload" 
                                                             alt="{{ $translation->title }}">
                                    </a>
                                    <ul class="product-option">
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.View') }}">
                                                            <a href="javascript:void(0)" class="view-product-btn" data-bs-toggle="modal" data-bs-target="#view" data-product-id="{{ $product->id }}">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.Wishlist') }}">
                                                            <a href="javascript:void(0)" class="add-to-wishlist" data-product-id="{{ $product->id }}">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                            </div>
                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    @if($categoryTranslation)
                                                        <span class="span-name">{{ $categoryTranslation->title }}</span>
                                                    @endif
                                                    <a href="{{ $productUrl }}">
                                                        <h5 class="name">{{ $translation->title }}</h5>
                                    </a>
                                                    <div class="product-rating mt-2">
                                                        <ul class="rating">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <li>
                                                                    <i data-feather="star" class="{{ $i <= $rating ? 'fill' : '' }}"></i>
                                        </li>
                                                            @endfor
                                    </ul>
                                                        <span>({{ number_format($product->rate ?? 0, 1) }})</span>
                                </div>
                                                    @if($variant->discount_price && $variant->discount_percentage > 0)
                                                        <h5 class="price">
                                                            <span class="theme-color">{{ __('messages.currency') }} {{ number_format($variant->discount_price, 2) }}</span>
                                                            <del>{{ __('messages.currency') }} {{ number_format($variant->price_before_discount ?? $variant->price, 2) }}</del>
                                                        </h5>
                                                    @else
                                                        <h5 class="price">
                                                            <span class="theme-color">{{ __('messages.currency') }} {{ number_format($variant->price, 2) }}</span>
                                                        </h5>
                                                    @endif
                                                    <div class="add-to-cart-box bg-white">
                                                        <button class="btn btn-add-cart addcart-button"
                                                                data-product-id="{{ $product->id }}"
                                                                data-variant-id="{{ $variant->id }}"
                                                                data-condition="{{ $product->condition }}">{{ __('messages.Add') }}
                                                            <span class="add-icon bg-light-gray">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <section class="newsletter-section-2 section-b-space">
                        <div class="container-fluid-lg">
                            <div class="row">
                                <div class="col-12">
                                    <div class="newsletter-box hover-effect">
                                        <img src="{{asset('website/images/veg-3/shape/background.png')}}" class="img-fluid bg-img"
                                             alt="">

                                        <div class="row">
                                            <div class="col-xxl-8 col-xl-7">
                                                <div class="newsletter-detail p-center-left text-white">

                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-xl-5 d-xl-block d-none">
                                                <div class="shape-box">
                                                    <!-- <img src="../assets/images/veg-3/home/1.png" alt="" class="img-fluid image-1"> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


                    <div class="title d-block">
                        <h2 class="text-theme font-sm">{{ __('messages.Most Requested') }}</h2>
                        <p>{{ __('messages.A virtual assistant collects the products from your list') }}</p>
                    </div>
                    <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-md-3 row-cols-2 g-sm-4 g-3 no-arrow section-b-space">
                        @if(isset($mostRequestedProducts) && $mostRequestedProducts->count() > 0)
                            @foreach($mostRequestedProducts->take(10) as $index => $product)
                                @php
                                    $translation = $product->translation ?? $product->translations->first();
                                    $variant = $product->variants->first();
                                    $productUrl = route('productDetail', ['id' => $translation->slug ?? $product->id]);
                                    $categoryTranslation = $product->category->translation ?? $product->category->translations->first() ?? null;
                                    
                                    // Condition badge logic
                                    $conditionLabel = '';
                                    $conditionClass = '';
                                    $showBadge = false;
                                    if ($product->department) {
                                        if ($product->department->id == 2) {
                                            if ($product->condition === 'new') {
                                                $conditionLabel = __('messages.New');
                                                $conditionClass = 'bg-success';
                                                $showBadge = true;
                                            } elseif ($product->condition === 'used') {
                                                $conditionLabel = __('messages.Used');
                                                $conditionClass = 'bg-info';
                                                $showBadge = true;
                                            }
                                        } elseif ($product->department->id == 1 && $product->condition === 'rent') {
                                            $conditionLabel = __('messages.Rent');
                                            $conditionClass = 'bg-warning';
                                            $showBadge = true;
                                        }
                                    }
                                    
                                    $rating = round($product->rate ?? 0);
                                    $wowDelay = ($index % 4 == 0) ? 0 : ($index % 4) * 0.1;
                                @endphp
                                @if($translation && $variant)
                        <div>
                                        <div class="product-box-3 wow fadeInUp" @if($wowDelay > 0) data-wow-delay="{{ $wowDelay }}s" @endif>
                                            <div class="product-header product-box">
                                                @if($showBadge && $conditionLabel)
                                                    <div class="label-tag {{ $conditionClass }}">
                                                        <span>{{ $conditionLabel }}</span>
                                </div>
                                                @endif
                                <div class="product-image">
                                                    <a href="{{ $productUrl }}">
                                                        <img src="{{ $product->image }}" 
                                                             class="img-fluid blur-up lazyload" 
                                                             alt="{{ $translation->title }}">
                                    </a>
                                    <ul class="product-option">
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.View') }}">
                                                            <a href="javascript:void(0)" class="view-product-btn" data-bs-toggle="modal" data-bs-target="#view" data-product-id="{{ $product->id }}">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.Wishlist') }}">
                                                            <a href="javascript:void(0)" class="add-to-wishlist" data-product-id="{{ $product->id }}">
                                                <i data-feather="heart"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                            </div>
                                            <div class="product-footer">
                                                <div class="product-detail">
                                                    @if($categoryTranslation)
                                                        <span class="span-name">{{ $categoryTranslation->title }}</span>
                                                    @endif
                                                    <a href="{{ $productUrl }}">
                                                        <h5 class="name">{{ $translation->title }}</h5>
                                    </a>
                                                    <div class="product-rating mt-2">
                                                        <ul class="rating">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <li>
                                                                    <i data-feather="star" class="{{ $i <= $rating ? 'fill' : '' }}"></i>
                                        </li>
                                                            @endfor
                                    </ul>
                                                        <span>({{ number_format($product->rate ?? 0, 1) }})</span>
                                </div>
                                                    @if($variant->discount_price && $variant->discount_percentage > 0)
                                                        <h5 class="price">
                                                            <span class="theme-color">{{ __('messages.currency') }} {{ number_format($variant->discount_price, 2) }}</span>
                                                            <del>{{ __('messages.currency') }} {{ number_format($variant->price_before_discount ?? $variant->price, 2) }}</del>
                                                        </h5>
                                                    @else
                                                        <h5 class="price">
                                                            <span class="theme-color">{{ __('messages.currency') }} {{ number_format($variant->price, 2) }}</span>
                                                        </h5>
                                                    @endif
                                                    <div class="add-to-cart-box bg-white">
                                                        <button class="btn btn-add-cart addcart-button"
                                                                data-product-id="{{ $product->id }}"
                                                                data-variant-id="{{ $variant->id }}"
                                                                data-condition="{{ $product->condition }}">{{ __('messages.Add') }}
                                                            <span class="add-icon bg-light-gray">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endif
                            @endforeach
                        @endif
                        </div>
                </div>
            </div>
        </div>
    </section>

@endsection
