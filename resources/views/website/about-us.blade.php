@extends('website.layouts.layoutPage')
@php
    $translation = $aboutUs->translation ?? null;
    $pageTitle = $translation->title ?? __('messages.About the club');
@endphp
@section('pageTitle', $pageTitle)

@push('headStyle')
    {{-- SEO Meta Tags --}}
    @if($translation)
        <meta name="description" content="{{ getExcerpt($translation->description ?? '', 160) }}">
        @if($translation->keywords)
            <meta name="keywords" content="{{ is_array($translation->keywords) ? implode(', ', $translation->keywords) : $translation->keywords }}">
        @endif
        <link rel="canonical" href="{{ route('about-us') }}">
    @endif
@endpush

@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{ __('messages.About Us') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">{{ __('messages.About Us') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    @if($aboutUs)
    <!-- Fresh Vegetable Section Start -->
    <section class="fresh-vegetable-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row gx-xl-5 gy-xl-0 g-3 ratio_148_1">
                <div class="col-xl-6 col-12">
                    <div class="row g-sm-4 g-2">
                        {{-- الصورة الأولى (الكبيرة) --}}
                        <div class="col-6">
                            <div class="fresh-image-2">
                                <div>
                                    @if($aboutUs->image_1)
                                        <img src="{{ $aboutUs->image_1 }}"
                                             class="bg-img blur-up lazyload"
                                             alt="{{ $translation->title ?? 'About Us' }}">
                                    @else
                                        <img src="{{asset('website/images/151.jpeg')}}"
                                             class="bg-img blur-up lazyload"
                                             alt="{{ $translation->title ?? 'About Us' }}">
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- الصورة الثانية (الصغيرة) --}}
                        <div class="col-6">
                            <div class="fresh-image">
                                <div>
                                    @if($aboutUs->image_2)
                                        <img src="{{ $aboutUs->image_2 }}"
                                             class="bg-img blur-up lazyload"
                                             alt="{{ $translation->title ?? 'About Us' }}">
                                    @else
                                        <img src="{{asset('website/images/151.jpeg')}}"
                                             class="bg-img blur-up lazyload"
                                             alt="{{ $translation->title ?? 'About Us' }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-12">
                    <div class="fresh-contain p-center-left">
                        <div>
                            <div class="review-title">
                                <h4>{{ __('messages.About Us') }}</h4>
                                <h2>{{ $translation->title ?? __('messages.About Us') }}</h2>
                            </div>

                            <div class="delivery-list">
                                {{-- الوصف من قاعدة البيانات --}}
                                @if($translation && $translation->description)
                                    <div class="text-content">
                                        {!! $translation->description !!}
                                    </div>
                                @else
                                    <p class="text-content">{{ __('messages.No description available') }}</p>
                                @endif

                                {{-- المميزات (Features) من قاعدة البيانات --}}
                                @if($aboutUs->features && $aboutUs->features->count() > 0)
                                    <ul class="delivery-box">
                                        @foreach($aboutUs->features as $feature)
                                            @php
                                                // جلب الترجمة الحالية للـ feature
                                                $featureTranslation = $feature->translation ?? $feature->translations->first();
                                            @endphp
                                            @if($featureTranslation && $featureTranslation->title)
                                                <li>
                                                    <div class="delivery-box">
                                                        <div class="delivery-icon">
                                                            @if($feature->icon)
                                                                <img src="{{ $feature->icon }}"
                                                                     class="blur-up lazyload"
                                                                     alt="{{ $featureTranslation->title ?? 'Feature Icon' }}">
                                                            @else
                                                                <img src="{{asset('website/svg/3/delivery.svg')}}"
                                                                     class="blur-up lazyload"
                                                                     alt="{{ $featureTranslation->title ?? 'Feature Icon' }}">
                                                            @endif
                                                        </div>
                                                        <div class="delivery-detail">
                                                            <h5 class="text">{{ $featureTranslation->title }}</h5>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fresh Vegetable Section End -->

    <!-- Client Section Start -->
    <section class="client-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="about-us-title text-center">
                        <h4>{{ __('messages.What We Do') }}</h4>
                        <h2 class="center">{{ __('messages.We are Trusted by Clients') }}</h2>
                    </div>

                    {{-- الإحصائيات (Statistics) من قاعدة البيانات --}}
                    @if($aboutUs->statistics && $aboutUs->statistics->count() > 0)
                        <div class="slider-3_1 product-wrapper">
                            @foreach($aboutUs->statistics as $statistic)
                                @php
                                    // جلب الترجمة الحالية للـ statistic
                                    $statisticTranslation = $statistic->translation ?? $statistic->translations->first();
                                @endphp
                                @if($statisticTranslation && $statisticTranslation->title)
                                    <div>
                                        <div class="clint-contain">
                                            <div class="client-icon">
                                                @if($statistic->icon)
                                                    <img src="{{ $statistic->icon }}"
                                                         class="blur-up lazyload"
                                                         alt="{{ $statisticTranslation->title ?? 'Statistic Icon' }}">
                                                @else
                                                    <img src="{{asset('website/svg/3/work.svg')}}"
                                                         class="blur-up lazyload"
                                                         alt="{{ $statisticTranslation->title ?? 'Statistic Icon' }}">
                                                @endif
                                            </div>
                                            @if($statistic->value)
                                                <h2>{{ $statistic->value }}</h2>
                                            @endif
                                            <h4>{{ $statisticTranslation->title }}</h4>
                                            @if($statisticTranslation->description)
                                                <p>{{ $statisticTranslation->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Client Section End -->
    @else
        {{-- في حالة عدم وجود بيانات --}}
        <section class="section-lg-space">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>{{ __('messages.No data available') }}</p>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
