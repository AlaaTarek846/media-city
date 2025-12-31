@php
    $translation = $product->translation ?? null;
    $pageTitle = $translation->title ?? __('messages.Product Details');
    $productImages = $product->images;
    // If no images, use main product image
    if ($productImages->isEmpty() && $product->image) {
        $productImages = collect([(object)['image' => $product->image, 'alt' => $translation->title ?? '']]);
    }
    $firstVariant = $product->variants->first();
    $categoryTranslation = $product->category->translation ?? null;
    $brandTranslation = $product->brand->translation ?? null;
    $averageRating = round($product->rate ?? 0, 1);
    $reviewCount = $product->review_count ?? 0;
@endphp

@extends('website.layouts.layoutPage')
@section('pageTitle', $pageTitle)

@push('headStyle')
    {{-- SEO Meta Tags --}}
    @if($translation)
        <meta name="description" content="{{ getExcerpt($translation->description ?? '', 160) }}">
        @if($translation->keywords)
            <meta name="keywords" content="{{ is_array($translation->keywords) ? implode(', ', $translation->keywords) : $translation->keywords }}">
        @endif
        <link rel="canonical" href="{{ route('productDetail', $translation->slug) }}">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="product">
        <meta property="og:url" content="{{ route('productDetail', $translation->slug) }}">
        <meta property="og:title" content="{{ $translation->title }}">
        <meta property="og:description" content="{{ getExcerpt($translation->description ?? '', 160) }}">
        @if($productImages->isNotEmpty())
            <meta property="og:image" content="{{ $productImages->first()->image }}">
        @elseif($product->image)
            <meta property="og:image" content="{{ $product->image }}">
        @endif

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $translation->title }}">
        <meta name="twitter:description" content="{{ getExcerpt($translation->description ?? '', 160) }}">
        @if($productImages->isNotEmpty())
            <meta name="twitter:image" content="{{ $productImages->first()->image }}">
        @elseif($product->image)
            <meta name="twitter:image" content="{{ $product->image }}">
        @endif
    @endif

    {{-- Product Image Slider Styles --}}
    <style>
        .product-image-slider {
            position: relative;
            margin-bottom: 20px;
        }
        .product-main-slider {
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
        }
        .product-main-slider .slider-image {
            text-align: center;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .product-main-slider .slider-image img {
            max-height: 500px;
            width: auto;
            object-fit: contain;
            border-radius: 4px;
        }
        .product-thumbnail-slider {
            margin-top: 0;
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
            padding: 0;
            max-height: 500px;
            overflow: hidden;
            position: relative;
        }
        .product-thumbnail-slider .slick-slide {
            padding: 0;
            margin-bottom: 12px;
        }
        .product-thumbnail-slider .slick-slide:last-child {
            margin-bottom: 0;
        }
        .product-thumbnail-slider .sidebar-image {
            position: relative;
            padding: 5px;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
            overflow: hidden;
            margin: 0;
            display: block;
        }
        .product-thumbnail-slider .sidebar-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(13, 164, 135, 0);
            transition: all 0.3s ease;
            z-index: 1;
            border-radius: 6px;
        }
        .product-thumbnail-slider .sidebar-image:hover {
            border-color: var(--theme-color, #0da487);
            box-shadow: 0 4px 12px rgba(13, 164, 135, 0.25);
            transform: translateX({{ app()->getLocale() == 'ar' ? '-3px' : '3px' }});
        }
        .product-thumbnail-slider .sidebar-image:hover::before {
            background: rgba(13, 164, 135, 0.1);
        }
        .product-thumbnail-slider .sidebar-image.active {
            border-color: var(--theme-color, #0da487);
            border-width: 3px;
            box-shadow: 0 4px 16px rgba(13, 164, 135, 0.4);
            transform: translateX({{ app()->getLocale() == 'ar' ? '-5px' : '5px' }});
            background: linear-gradient(135deg, rgba(13, 164, 135, 0.05) 0%, rgba(13, 164, 135, 0.1) 100%);
        }
        .product-thumbnail-slider .sidebar-image.active::after {
            content: '';
            position: absolute;
            top: 8px;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 8px;
            width: 20px;
            height: 20px;
            background: var(--theme-color, #0da487);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            box-shadow: 0 2px 6px rgba(13, 164, 135, 0.5);
        }
        .product-thumbnail-slider .sidebar-image.active::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23fff' d='M10 3L4.5 8.5 2 6' stroke='%23fff' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 12px;
        }
        .product-thumbnail-slider .sidebar-image img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 0;
            display: block;
        }
        .product-thumbnail-slider .sidebar-image:hover img {
            transform: scale(1.08);
        }
        .product-thumbnail-slider .sidebar-image.active img {
            transform: scale(1.1);
        }
        @media (max-width: 768px) {
            .product-thumbnail-slider .sidebar-image img {
                height: 70px;
            }
            .product-thumbnail-slider .slick-slide {
                padding: 0 3px;
            }
        }
        @if(app()->getLocale() == 'ar')
        .product-main-slider .slick-prev {
            right: 10px;
            left: auto;
        }
        .product-main-slider .slick-next {
            left: 10px;
            right: auto;
        }
        @else
        .product-main-slider .slick-prev {
            left: 10px;
            right: auto;
        }
        .product-main-slider .slick-next {
            right: 10px;
            left: auto;
        }
        @endif
        /* Thumbnail slider container improvements - Vertical Layout with Hidden Scrollbar */
        .product-thumbnail-slider .slick-list {
            margin: 0;
            height: 100% !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .product-thumbnail-slider .slick-list::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        .product-thumbnail-slider .slick-track {
            display: block;
            height: auto !important;
            min-height: 100%;
        }
        .product-thumbnail-slider .slick-track .slick-slide {
            display: block;
            height: auto;
            width: 100% !important;
        }
        .product-thumbnail-slider .thumbnail-item {
            height: auto;
            width: 100%;
        }

        /* Smooth transitions for all states */
        .product-thumbnail-slider .sidebar-image * {
            transition: all 0.3s ease;
        }

        /* Focus state for accessibility */
        .product-thumbnail-slider .sidebar-image:focus {
            outline: 2px solid var(--theme-color, #0da487);
            outline-offset: 2px;
        }

        /* Loading state */
        .product-thumbnail-slider .thumbnail-img.lazyload {
            opacity: 0.7;
        }
        .product-thumbnail-slider .thumbnail-img.lazyloaded {
            opacity: 1;
        }

        /* Vertical slider specific styles with scrollable hidden scrollbar */
        .product-thumbnail-slider.slick-vertical .slick-slide {
            display: block;
            height: auto;
            margin: 0;
        }
        .product-thumbnail-slider.slick-vertical .slick-list {
            height: 500px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
            scroll-behavior: smooth;
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .product-thumbnail-slider.slick-vertical .slick-list::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        .product-thumbnail-slider.slick-vertical .slick-track {
            transform: translate3d(0, 0, 0) !important;
            display: block;
            height: auto !important;
        }
        .product-thumbnail-slider.slick-vertical .slick-track .slick-slide {
            display: block;
            width: 100% !important;
            float: none;
        }

        /* Smooth scrolling enhancement */
        .product-thumbnail-slider .slick-list {
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }

        /* Additional scrollbar hiding for all browsers */
        .product-thumbnail-slider * {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        .product-thumbnail-slider *::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
            width: 0;
            height: 0;
        }

        @media (max-width: 1200px) {
            .product-thumbnail-slider.slick-vertical .slick-list {
                height: 400px !important;
            }
        }

        @media (max-width: 768px) {
            .product-main-slider .slider-image img {
                max-height: 300px;
            }
            .product-thumbnail-slider {
                margin-top: 15px;
            }
            .product-thumbnail-slider.slick-vertical .slick-list {
                height: 350px !important;
            }
            .product-thumbnail-slider .sidebar-image img {
                height: 80px;
            }
        }

        @media (max-width: 576px) {
            .product-thumbnail-slider .sidebar-image img {
                height: 70px;
            }
            .product-thumbnail-slider.slick-vertical .slick-list {
                height: 300px !important;
            }
        }
    </style>
@endpush

@section('body')
    @if($translation)
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                            <h2>{{ $translation->title }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">{{ $translation->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

        <!-- Product Section Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 wow fadeInUp">
                    <div class="row g-4">
                            {{-- Product Images Slider --}}
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="product-left-box">
                                <div class="row g-2">
                                    <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                            <div class="product-main-slider product-main-2 no-arrow">
                                                @if($productImages->isNotEmpty())
                                                    @foreach($productImages as $index => $image)
                                            <div>
                                                <div class="slider-image">
                                                                <img src="{{ $image->image }}"
                                                                     id="img-{{ $index }}"
                                                                     data-zoom-image="{{ $image->image }}"
                                                                     class="img-fluid image_zoom_cls-{{ $index }} blur-up lazyload"
                                                                     alt="{{ $image->alt ?? $translation->title }}">
                                                </div>
                                            </div>
                                                    @endforeach
                                                @else
                                            <div>
                                                <div class="slider-image">
                                                            <img src="{{ $product->image ?? asset('website/images/veg-3/home/17.jpg') }}"
                                                                 class="img-fluid blur-up lazyload"
                                                                 alt="{{ $translation->title }}">
                                                </div>
                                            </div>
                                                @endif
                                                </div>
                                            </div>

                                        @if($productImages->count() > 1)
                                    <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                                <div class="product-thumbnail-slider left-slider-image-2 left-slider no-arrow slick-top">
                                                    @foreach($productImages as $index => $image)
                                            <div class="thumbnail-item">
                                                            <div class="sidebar-image {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}" role="button" tabindex="0" aria-label="{{ __('messages.View image') }} {{ $index + 1 }}">
                                                                <img src="{{ $image->image }}"
                                                                     class="img-fluid blur-up lazyload thumbnail-img"
                                                                     alt="{{ $image->alt ?? $translation->title }}"
                                                                     loading="lazy">
                                                </div>
                                            </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                                </div>
                                                </div>
                                            </div>

                            {{-- Product Details --}}
                        <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="right-box-contain">
                                    @if($firstVariant && $firstVariant->discount_percentage > 0)
                                        <h6 class="offer-top">{{ round($firstVariant->discount_percentage) }}% {{ __('messages.Off') }}</h6>
                                    @endif

                                    <h2 class="name">{{ $translation->title }}</h2>

                                <div class="price-rating">
                                        @if($firstVariant)
                                            @if($firstVariant->discount_price && $firstVariant->discount_percentage > 0)
                                                <h3 class="theme-color price">
                                                    {{ __('messages.currency') }} {{ number_format($firstVariant->discount_price, 2) }}
                                                    <del class="text-content">{{ __('messages.currency') }} {{ number_format($firstVariant->price_before_discount ?? $firstVariant->price, 2) }}</del>
                                                    <span class="offer theme-color">({{ round($firstVariant->discount_percentage) }}% {{ __('messages.Off') }})</span>
                                                </h3>
                                            @else
                                                <h3 class="theme-color price">{{ __('messages.currency') }} {{ number_format($firstVariant->price, 2) }}</h3>
                                            @endif
                                        @endif

                                    <div class="product-rating custom-rate">
                                        <ul class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                            <li>
                                                        <i data-feather="star" class="{{ $i <= $averageRating ? 'fill' : '' }}"></i>
                                            </li>
                                                @endfor
                                        </ul>
                                            @if($reviewCount > 0)
                                                <span class="review">{{ $reviewCount }} {{ $reviewCount > 1 ? __('messages.Customer Reviews') : __('messages.Customer Review') }}</span>
                                            @else
                                                <span class="review">{{ __('messages.No reviews yet') }}</span>
                                            @endif
                                    </div>
                                </div>

                                <div class="procuct-contain">
                                        <p>{{ $translation->description ?? __('messages.No description available') }}</p>
                                </div>

                                <div class="note-box product-packege">
{{--                                    <div class="cart_qty qty-box product-qty">--}}
{{--                                        <div class="input-group">--}}
{{--                                            <button type="button" class="qty-right-plus" data-type="plus" data-field="">--}}
{{--                                                <i class="fa fa-plus" aria-hidden="true"></i>--}}
{{--                                            </button>--}}
{{--                                            <input class="form-control input-number qty-input" type="text"--}}
{{--                                                       name="quantity" value="1" min="1" id="product-quantity">--}}
{{--                                                <button type="button" class="qty-left-minus" data-type="minus" data-field="">--}}
{{--                                                <i class="fa fa-minus" aria-hidden="true"></i>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <button class="btn btn-md bg-dark cart-button text-white w-100 addcart-button"
                                            id="add-to-cart-btn"
                                            data-product-id="{{ $product->id }}"
                                            data-variant-id="{{ $firstVariant->id ?? '' }}">
                                        {{ __('messages.Add to cart') }}
                                    </button>
                                </div>

                                <div class="buy-box">
                                   <a href="javascript:void(0)" class="add-to-wishlist" data-product-id="{{ $product->id }}">
                                        <i data-feather="heart" class="{{ $product->is_favorite ? 'fill' : '' }}"></i>
                                        <span>{{ __('messages.Add To Wishlist') }}</span>
                                    </a>
                                </div>

                                <div class="pickup-box">
                                    <div class="product-title">
                                            <h4>{{ __('messages.Product Information') }}</h4>
                                    </div>

                                    <div class="product-info">
                                        <ul class="product-info-list product-info-list-2">
                                                @if($brandTranslation)
                                                    <li>{{ __('messages.Brand') }}: <a href="javascript:void(0)">{{ $brandTranslation->title }}</a></li>
                                                @endif
                                                @if($firstVariant && $firstVariant->sku)
                                                    <li>{{ __('messages.SKU') }}: <a href="javascript:void(0)" id="product-sku">{{ $firstVariant->sku }}</a></li>
                                                @endif
                                                @if($categoryTranslation)
                                                    <li>{{ __('messages.Category') }}: <a href="{{ route('shop', ['category' => $product->category_id]) }}">{{ $categoryTranslation->title }}</a></li>
                                                @endif
                                                @if($firstVariant)
                                                    <li>{{ __('messages.Stock') }}:
                                                        <a href="javascript:void(0)">
                                                            @if($firstVariant->quantity > 0)
                                                                {{ $firstVariant->quantity }} {{ __('messages.Items Available') }}
                                                            @else
                                                                <span class="text-danger">{{ __('messages.Out of Stock') }}</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endif
                                                @if($product->condition)
                                                    <li>{{ __('messages.Condition') }}: <a href="javascript:void(0)">{{ ucfirst($product->condition) }}</a></li>
                                                @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                            {{-- Product Tabs --}}
                        <div class="col-12">
                            <div class="product-section-box">
                                <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                                data-bs-target="#description" type="button" role="tab"
                                                    aria-controls="description" aria-selected="true">{{ __('messages.Description') }}</button>
                                    </li>

                                        @if($product->attributes->count() > 0)
                                    <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="attributes-tab" data-bs-toggle="tab"
                                                        data-bs-target="#attributes" type="button" role="tab" aria-controls="attributes"
                                                        aria-selected="false">{{ __('messages.Additional Information') }}</button>
                                    </li>
                                        @endif

                                        @if($product->features && $product->features->translation)
                                    <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="features-tab" data-bs-toggle="tab"
                                                        data-bs-target="#features" type="button" role="tab" aria-controls="features"
                                                        aria-selected="false">{{ __('messages.Features') }}</button>
                                    </li>
                                        @endif

                                        @if($reviewCount > 0)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                                                        data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews"
                                                        aria-selected="false">{{ __('messages.Reviews') }} ({{ $reviewCount }})</button>
                                            </li>
                                        @endif
                                </ul>

                                <div class="tab-content custom-tab" id="myTabContent">
                                        {{-- Description Tab --}}
                                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                                         aria-labelledby="description-tab">
                                        <div class="product-description">
                                            <div class="nav-desh">
                                                    <p>{{ $translation->description ?? __('messages.No description available') }}</p>
                                            </div>
                                                </div>
                                            </div>

                                        {{-- Attributes Tab --}}
                                        @if($product->attributes->count() > 0)
                                            <div class="tab-pane fade" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
                                        <div class="table-responsive">
                                            <table class="table info-table">
                                                <tbody>
                                                            @foreach($product->attributes as $attribute)
                                                                @php
                                                                    $attrTranslation = $attribute->attribute->translation ?? null;
                                                                @endphp
                                                                @if($attrTranslation)
                                                <tr>
                                                                        <td>{{ $attrTranslation->title }}</td>
                                                                        <td>{{ $attribute->value }}</td>
                                                </tr>
                                                                @endif
                                                            @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                        @endif

                                        {{-- Features Tab --}}
                                        @if($product->features && $product->features->translation)
                                            <div class="tab-pane fade" id="features" role="tabpanel" aria-labelledby="features-tab">
                                        <div class="information-box">
                                                    @php
                                                        $featureTranslation = $product->features->translation;
                                                    @endphp
                                                    @if($featureTranslation->title)
                                                        <h5>{{ $featureTranslation->title }}</h5>
                                                    @endif
                                                    @if($featureTranslation->description)
                                                        <p>{{ $featureTranslation->description }}</p>
                                                    @endif
                                        </div>
                                    </div>
                                        @endif

                                        {{-- Reviews Tab --}}
                                        @if($reviewCount > 0)
                                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                                <div class="reviews-section">
            <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="rating-summary text-center">
                                                                <h2 class="mb-2">{{ $averageRating }}</h2>
                                                                <div class="product-rating mb-3">
                                                                    <ul class="rating justify-content-center">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            <li>
                                                                                <i data-feather="star" class="{{ $i <= $averageRating ? 'fill' : '' }}"></i>
                                            </li>
                                                                        @endfor
                                        </ul>
                                    </div>
                                                                <p>{{ $reviewCount }} {{ $reviewCount > 1 ? __('messages.Reviews') : __('messages.Review') }}</p>

                                                                @if(isset($rating_percentage))
                                                                    <div class="rating-breakdown mt-4">
                                                                        @foreach($rating_percentage as $ratingData)
                                                                            <div class="rating-bar mb-2">
                                                                                <div class="d-flex justify-content-between mb-1">
                                                                                    <span>{{ $ratingData['rate'] }} {{ __('messages.Star') }}</span>
                                                                                    <span>{{ $ratingData['percentage'] }}%</span>
                                        </div>
                                                                                <div class="progress" style="height: 8px;">
                                                                                    <div class="progress-bar" role="progressbar"
                                                                                         style="width: {{ $ratingData['percentage'] }}%"
                                                                                         aria-valuenow="{{ $ratingData['percentage'] }}"
                                                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                                                        @endforeach
                                        </div>
                                                                @endif
                                    </div>
                                </div>
                                                        <div class="col-md-8">
                                                            <div class="reviews-list">
                                                                @foreach($product->reviews->take(10) as $review)
                                                                    <div class="review-item mb-4 pb-4 border-bottom">
                                                                        <div class="d-flex justify-content-between mb-2">
                        <div>
                                                                                <h6 class="mb-1">{{ $review->user->name ?? __('messages.Anonymous') }}</h6>
                                                                                <div class="product-rating">
                                            <ul class="rating">
                                                                                        @for($i = 1; $i <= 5; $i++)
                                                <li>
                                                                                                <i data-feather="star" class="{{ $i <= $review->rating ? 'fill' : '' }}"></i>
                                                </li>
                                                                                        @endfor
                                            </ul>
                                        </div>
                                                </div>
                                                                            <span class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('d M, Y') }}</span>
                                            </div>
                                                                        @if($review->comment)
                                                                            <p class="mb-0">{{ $review->comment }}</p>
                                                                        @endif
                                        </div>
                                                                @endforeach
                                    </div>
                                </div>
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
                                </div>
        </section>
        <!-- Product Section End -->

        {{-- Related Products Section --}}
        @if(isset($products) && $products->count() > 0)
            <section class="product-list-section section-b-space">
                <div class="container-fluid-lg">
                    <div class="title">
                        <h2>{{ __('messages.Related Products') }}</h2>
                        <span class="title-leaf">
                            <svg class="icon-width">
                                <use xlink:href="../assets/svg/leaf.svg#leaf"></use>
                            </svg>
                                                </span>
                                                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="slider-6_1 product-wrapper">
                                @foreach($products as $relatedProduct)
                                    @php
                                        $relatedTranslation = $relatedProduct->translation;
                                        $relatedVariant = $relatedProduct->variants->first();
                                    @endphp
                                    @if($relatedTranslation)
                        <div>
                            <div class="product-box-3 wow fadeInUp">
                                <div class="product-header">
                                    <div class="product-image">
                                                        <a href="{{ route('productDetail', $relatedTranslation->slug) }}">
                                                            <img src="{{ $relatedProduct->image ?? asset('website/images/veg-3/home/19.jpg') }}"
                                                                 class="img-fluid blur-up lazyload"
                                                                 alt="{{ $relatedTranslation->title }}">
                                                        </a>
                                        <ul class="product-option">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.View') }}">
                                                                <a href="javascript:void(0)" class="view-product-btn" data-bs-toggle="modal"
                                                                   data-bs-target="#view" data-product-id="{{ $relatedProduct->id }}">
                                                    <i data-feather="eye"></i>
                                                </a>
                                            </li>
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.Wishlist') }}">
                                                                <a href="javascript:void(0)" class="add-to-wishlist" data-product-id="{{ $relatedProduct->id }}">
                                                    <i data-feather="heart"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="product-detail">
                                                        @if($relatedProduct->category && $relatedProduct->category->translation)
                                                            <span class="span-name">{{ $relatedProduct->category->translation->title }}</span>
                                                        @endif
                                                        <a href="{{ route('productDetail', $relatedTranslation->slug) }}">
                                                            <h5 class="name">{{ $relatedTranslation->title }}</h5>
                                        </a>
                                        <div class="product-rating mt-2">
                                            <ul class="rating">
                                                                @php
                                                                    $relatedRating = round($relatedProduct->rate ?? 0);
                                                                @endphp
                                                                @for($i = 1; $i <= 5; $i++)
                                                <li>
                                                                        <i data-feather="star" class="{{ $i <= $relatedRating ? 'fill' : '' }}"></i>
                                                </li>
                                                                @endfor
                                            </ul>
                                                            <span>({{ number_format($relatedProduct->rate ?? 0, 1) }})</span>
                                        </div>
                                                        @if($relatedVariant)
                                                            @if($relatedVariant->discount_price && $relatedVariant->discount_percentage > 0)
                                                                <h5 class="price">
                                                                    <span class="theme-color">{{ __('messages.currency') }} {{ number_format($relatedVariant->discount_price, 2) }}</span>
                                                                    <del>{{ __('messages.currency') }} {{ number_format($relatedVariant->price_before_discount ?? $relatedVariant->price, 2) }}</del>
                                        </h5>
                                                            @else
                                                                <h5 class="price">
                                                                    <span class="theme-color">{{ __('messages.currency') }} {{ number_format($relatedVariant->price, 2) }}</span>
                                                                </h5>
                                                            @endif
                                                        @endif
                                        <div class="add-to-cart-box bg-white">
                                                            <button class="btn btn-add-cart addcart-button">{{ __('messages.Add') }}
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
                            </div>
                        </div>
                                    </div>
                                </div>
            </section>
        @endif
    @else
        <section class="product-section section-b-space">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3>{{ __('messages.Product not found') }}</h3>
                                        </div>
                                                </div>
                                            </div>
        </section>
    @endif

    @push('headScript')
    <script>
        $(document).ready(function() {
            // Wait a bit to ensure DOM is fully ready
            setTimeout(function() {
                // Initialize image slider
                var isRTL = '{{ app()->getLocale() }}' === 'ar';
                var $mainSlider = $('.product-main-slider');
                var $thumbnailSlider = $('.product-thumbnail-slider');

                // Destroy existing slick instances if any
                if ($mainSlider.hasClass('slick-initialized')) {
                    $mainSlider.slick('unslick');
                }
                if ($thumbnailSlider.hasClass('slick-initialized')) {
                    $thumbnailSlider.slick('unslick');
                }

                // Check if main slider exists and has content
                if ($mainSlider.length && $mainSlider.find('div > .slider-image').length > 0) {
                    var sliderConfig = {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: true,
                        fade: true,
                        rtl: isRTL,
                        prevArrow: isRTL ? '<button type="button" class="slick-prev"><i class="fa fa-angle-right"></i></button>' : '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                        nextArrow: isRTL ? '<button type="button" class="slick-next"><i class="fa fa-angle-left"></i></button>' : '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                        adaptiveHeight: false,
                        infinite: false,
                        accessibility: true,
                        focusOnSelect: false
                    };

                    // Only add asNavFor if thumbnail slider exists and has content
                    if ($thumbnailSlider.length && $thumbnailSlider.find('.sidebar-image').length > 0) {
                        sliderConfig.asNavFor = '.product-thumbnail-slider';
                    }

                    try {
                        $mainSlider.slick(sliderConfig);
                    } catch (e) {
                        console.error('Error initializing main slider:', e);
                    }
                }

                // Initialize thumbnail slider if it exists and has content - VERTICAL LAYOUT with SCROLL
                if ($thumbnailSlider.length && $thumbnailSlider.find('.sidebar-image').length > 0 && $mainSlider.length) {
                    try {
                        $thumbnailSlider.slick({
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            asNavFor: '.product-main-slider',
                            dots: false,
                            arrows: false,
                            focusOnSelect: true,
                            vertical: true,
                            verticalSwiping: true,
                            swipeToSlide: true,
                            rtl: isRTL,
                            infinite: false,
                            accessibility: true,
                            adaptiveHeight: false,
                            touchMove: true,
                            touchThreshold: 5,
                            responsive: [
                                {
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 3,
                                        vertical: true,
                                        verticalSwiping: true
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 3,
                                        vertical: true,
                                        verticalSwiping: true
                                    }
                                }
                            ]
                        });

                        // Enable smooth scrolling with mouse wheel
                        $thumbnailSlider.on('wheel', function(e) {
                            e.preventDefault();
                            var delta = e.originalEvent.deltaY;
                            if (delta > 0) {
                                $thumbnailSlider.slick('slickNext');
                            } else {
                                $thumbnailSlider.slick('slickPrev');
                            }
                        });
                    } catch (e) {
                        console.error('Error initializing thumbnail slider:', e);
                    }
                }

                // Update active thumbnail on slide change
                $mainSlider.on('afterChange', function(event, slick, currentSlide) {
                    $('.sidebar-image').removeClass('active');
                    var $activeThumb = $('.sidebar-image[data-slide-index="' + currentSlide + '"]');
                    if ($activeThumb.length) {
                        $activeThumb.addClass('active');
                    }
                });

                // Click thumbnail to change main image
                $(document).on('click', '.sidebar-image', function() {
                    var slideIndex = $(this).data('slide-index');
                    if (slideIndex !== undefined && $mainSlider.length && $mainSlider.hasClass('slick-initialized')) {
                        try {
                            $mainSlider.slick('slickGoTo', parseInt(slideIndex));
                        } catch (e) {
                            console.error('Error navigating to slide:', e);
                        }
                    }
                });
            }, 100);

            // Reinitialize feather icons after content loads
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
    @endpush
@endsection
