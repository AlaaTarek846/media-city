@extends('website.layouts.layoutPage')
@php
    $translation = $termsCondition->translation ?? null;
    $pageTitle = $translation->title ?? __('messages.Terms & Conditions');
@endphp
@section('pageTitle', $pageTitle)

@push('headStyle')
    {{-- SEO Meta Tags --}}
    @if($translation)
        <meta name="description" content="{{ getExcerpt($translation->description ?? '', 160) }}">
        @if($translation->keywords)
            <meta name="keywords" content="{{ is_array($translation->keywords) ? implode(', ', $translation->keywords) : $translation->keywords }}">
        @endif
        <link rel="canonical" href="{{ route('terms-condition') }}">
    @endif
    
    {{-- Custom Styles --}}
    <style>
        .terms-content {
            line-height: 1.8;
            color: #555;
        }
        
        .terms-content h5 {
            color: var(--theme-color, #0da487);
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }
        
        .terms-content h5:first-child {
            margin-top: 0;
        }
        
        .terms-content p {
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        
        .terms-content ul,
        .terms-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }
        
        .terms-content li {
            margin-bottom: 0.75rem;
            line-height: 1.7;
        }
        
        .terms-content ul li::marker {
            color: var(--theme-color, #0da487);
        }
        
        .terms-card {
            transition: all 0.3s ease;
        }
        
        .terms-card:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }
        
        @media (max-width: 768px) {
            .terms-content {
                font-size: 0.95rem;
            }
            
            .terms-content h5 {
                font-size: 1.1rem;
            }
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
                        <h2>{{ $translation->title ?? __('messages.Terms & Conditions') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">{{ $translation->title ?? __('messages.Terms & Conditions') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    @if($termsCondition && $translation)
    <!-- Terms & Conditions Section Start -->
    <section class="fresh-vegetable-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="row g-4">
                        {{-- العنوان الرئيسي --}}
                        <div class="col-12">
                            <div class="about-us-title text-center">
                                <h4 class="text-content">{{ __('messages.Terms & Conditions') }}</h4>
                                <h2 class="center">{{ $translation->title ?? __('messages.Terms & Conditions') }}</h2>
                            </div>
                        </div>

                        {{-- المحتوى --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 terms-card">
                                <div class="card-body p-4 p-md-5">
                                    {{-- أيقونة --}}
                                    <div class="text-center mb-4">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light" style="width: 80px; height: 80px;">
                                            <i class="fa-solid fa-file-contract fa-2x text-primary"></i>
                                        </div>
                                    </div>

                                    {{-- الوصف من قاعدة البيانات --}}
                                    @if($translation && $translation->description)
                                        <div class="text-content terms-content">
                                            {!! $translation->description !!}
                                        </div>
                                    @else
                                        <p class="text-content text-center">{{ __('messages.No description available') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Terms & Conditions Section End -->
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

