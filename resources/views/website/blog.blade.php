@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Blog'))

@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>@lang('messages.Blog List')</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">@lang('messages.Blog List')</li>
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
                    @if($articles->count() > 0)
                        <div class="row g-4">
                            @foreach($articles as $article)
                                @php
                                    $translation = $article->translation;
                                    $category = $article->category;
                                @endphp
                                @if($translation)
                                    <div class="col-12">
                                        <div class="blog-box blog-list wow fadeInUp">
                                            <div class="blog-image">
                                                <img src="{{ $article->image }}" class="blur-up lazyload" alt="{{ $translation->title }}">
                                            </div>

                                            <div class="blog-contain blog-contain-2">
                                                <div class="blog-label">
                                                    <span class="time">
                                                        <i data-feather="clock"></i>
                                                        <span>{{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d M, Y') }}</span>
                                                    </span>
                                                </div>
                                                <a href="{{ route('blog-details', $translation->slug) }}">
                                                    <h3>{{ $translation->title }}</h3>
                                                </a>
                                                <p>
                                                    {{ getExcerpt($translation->description ?? '', 200) }}
                                                </p>
                                                <button onclick="location.href='{{ route('blog-details', $translation->slug) }}'" class="blog-button">
                                                    @lang('messages.Read More')
                                                    @if(app()->getLocale() == 'ar')
                                                        <i class="fa-solid fa-left-long"></i>
                                                    @else
                                                        <i class="fa-solid fa-right-long"></i>
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($articles->hasPages())
                            <nav class="custome-pagination">
                                <ul class="pagination justify-content-center">
                                    {{-- Previous Page Link --}}
                                    @if($articles->onFirstPage())
                                        @if (app()->getLocale() == 'ar')
                                            <li class="page-item disabled">
                                                <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a class="page-link" href="javascript:void(0)" tabindex="-1">
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @else
                                        @if (app()->getLocale() == 'ar')
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $articles->previousPageUrl() }}">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                </a>
                                            </li>
                                        @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $articles->previousPageUrl() }}">
                                                <i class="fa-solid fa-angles-left"></i>
                                            </a>
                                        </li>
                                        @endif
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @php
                                        $currentPage = $articles->currentPage();
                                        $lastPage = $articles->lastPage();
                                        $range = 2; // Number of pages to show before and after current page
                                        $start = max(1, $currentPage - $range);
                                        $end = min($lastPage, $currentPage + $range);
                                    @endphp

                                    @for($page = $start; $page <= $end; $page++)
                                        <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $articles->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor

                                    {{-- Next Page Link --}}
                                    @if($articles->hasMorePages())
                                        @if (app()->getLocale() == 'ar')
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $articles->nextPageUrl() }}">
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $articles->nextPageUrl() }}">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @else
                                        @if (app()->getLocale() == 'ar')
                                            <li class="page-item disabled">
                                                <a class="page-link" href="javascript:void(0)">
                                                    <i class="fa-solid fa-angles-left"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a class="page-link" href="javascript:void(0)">
                                                    <i class="fa-solid fa-angles-right"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <p>@lang('messages.No articles found')</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
