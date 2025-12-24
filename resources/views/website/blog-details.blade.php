@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Blog Details'))

@section('body')
@include('website.layouts.breadcrump', ['currentPage' => __('messages.Blog Details'),'parentPage'=>__('messages.Blog'),'parentPageUri' => 'Blog'])



<section class="py-5">
    <div class="container px-3">
        <div class="row g-4 g-lg-5">
            <div class="col-12 col-lg-8">
                <div class="blog-leftside">
                    <div class="blog-post">
                        <div class="hstack mb-4 gap-3 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-calendar fs-5"></i>
                                {{ \Carbon\Carbon::parse($news->created_at)->format('M d, Y') }}
                            </div>
                        </div>


                        <div class="blog-img mt-4">
                            <img src="{{$news->image}}" class="img-fluid rounded-3" alt="{{$news->current_translation->title}}">
                        </div>
                        <div class="post-content mt-4">
                            <div class="mb-3">
                                <h3 class="post-title fw-semibold">{{$news->current_translation->title}}</h3>
                            </div>
                            {!!$news->details?->current_translation->description!!}
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="blog-rightside">

                    <div class="recent-posts mb-4">
                        <h4 class="fw-semibold mb-4">@lang('messages.Latest News')</h4>
                        <div class="recent-posts-list">
                            @foreach ($mightLikeThis as $blog)
                                <div class="recent-posts-list-item d-flex gap-3">
                                    <div class="recent-posts-img flex-shrink-0">
                                        <img src="{{$blog->image}}" class="img-fluid rounded-3" alt="{{$blog->current_translation->title}}">
                                    </div>
                                    <div class="recent-posts-details">
                                        <a href="/blog-details/{{$blog->id}}-{{$blog->slug}}">
                                            <h6 class="mb-2 recent-post-title fw-semibold">{{$blog->current_translation->title}}</h6>
                                        </a>
                                        <p class="mb-0 font-14">{{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="border-top my-4"></div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</section>


@endsection
