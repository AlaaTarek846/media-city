@extends('website.layouts.layoutPage')
@section('pageTitle', $article->translation->title ?? __('messages.Blog Details'))

@push('headStyle')
    {{-- SEO Meta Tags --}}
    @if(isset($article) && $article->translation)
        <meta name="description" content="{{ getExcerpt($article->translation->description ?? '', 160) }}">
        @if($article->translation->keywords)
            <meta name="keywords" content="{{ is_array($article->translation->keywords) ? implode(', ', $article->translation->keywords) : $article->translation->keywords }}">
        @endif
        <link rel="canonical" href="{{ route('blog-details', $article->translation->slug) }}">
    @endif
@endpush

@section('body')
    @php
        $translation = $article->translation;
        $category = $article->category;
    @endphp

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
                                    <li class="breadcrumb-item mx-1">
                                        <a href="{{ route('blog') }}">@lang('messages.Blog')</a>
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

        <!-- Blog Details Section Start -->
        <section class="blog-section section-b-space">
            <div class="container-fluid-lg">
                <div class="row g-sm-4 g-3">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 ratio_50">
                        <div class="blog-detail-image rounded-3 mb-4">
                            <img src="{{ $article->image }}" class="bg-img blur-up lazyload" alt="{{ $translation->title }}">
                            <div class="blog-image-contain">
                                {{-- Tags --}}
                                @if($article->tags && $article->tags->count() > 0)
                                    <ul class="contain-list">
                                        @foreach($article->tags as $tag)
                                            <li>{{ $tag->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                {{-- Article Title --}}
                                <h2>{{ $translation->title }}</h2>

                                {{-- Date --}}
                                <ul class="contain-comment-list">
                                    <li>
                                        <div class="user-list">
                                            <i data-feather="calendar"></i>
                                            <span>{{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('F d, Y') }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Article Content --}}
                        <div class="blog-detail-contain" style="overflow: hidden;word-wrap: break-word;">
                            {!! $translation->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog Details Section End -->

        {{-- Related Articles --}}
        @if(isset($relatedArticles) && $relatedArticles->count() > 0)
            <section class="blog-section section-b-space">
                <div class="container-fluid-lg">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="mb-4">@lang('messages.Related Articles')</h2>
                        </div>
                    </div>
                    <div class="row g-4">
                        @foreach($relatedArticles as $relatedArticle)
                            @php
                                $relatedTranslation = $relatedArticle->translation;
                            @endphp
                            @if($relatedTranslation)
                                <div class="col-md-4">
                                    <div class="blog-box blog-list wow fadeInUp">
                                        <div class="blog-image">
                                            <img src="{{ $relatedArticle->image }}" class="blur-up lazyload" alt="{{ $relatedTranslation->title }}">
                                        </div>
                                        <div class="blog-contain blog-contain-2">
                                            <div class="blog-label">
                                                <span class="time">
                                                    <i data-feather="clock"></i>
                                                    <span>{{ \Carbon\Carbon::parse($relatedArticle->created_at)->translatedFormat('d M, Y') }}</span>
                                                </span>
                                            </div>
                                            <a href="{{ route('blog-details', $relatedTranslation->slug) }}">
                                                <h3>{{ $relatedTranslation->title }}</h3>
                                            </a>
                                            <p>{{ getExcerpt($relatedTranslation->description ?? '', 150) }}</p>
                                            <button onclick="location.href='{{ route('blog-details', $relatedTranslation->slug) }}'" class="blog-button">
                                                @lang('messages.Read More') <i class="fa-solid fa-right-long"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @else
        <section class="blog-section section-b-space">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <p>@lang('messages.No articles found')</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
