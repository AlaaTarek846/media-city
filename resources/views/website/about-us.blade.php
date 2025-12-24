@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.About the club'))

@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.About Us')])

	 <section class="py-5">
      <div class="container px-3">
        <div class="row g-4 g-lg-5">
          <div class="col-12 col-lg-6">
            <div class="about-img">
              <img src="{{ $aboutUs->image }}" class="img-fluid rounded-4" alt="">
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="about-text">
              <h4>@lang('messages.Welcome to Our Store')</h4>
              {{ $aboutUs->current_translation?->description }}
            </div>
          </div>
        </div><!--end row-->

       @include('website.components.about-icon')



        <div class="row g-4 g-lg-5">
          <div class="col-12 col-lg-6">
            <div class="about-text">
              <h4>@lang('messages.Our Vision')</h4>
              {{ $vision->current_translation?->description }}
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="about-img">
              <img src="{{ $vision->image }}" class="img-fluid rounded-4" alt="">
            </div>
          </div>
        </div><!--end row-->

      </div>
    </section>


    <section class="py-5">
      <div class="container px-3">
        <div class="text-center mb-5">
          <h2 class="section-title">@lang('messages.Meet Our Teams')</h2>
          <p class="mb-0">@lang('messages.Explore unforgettable experiences through the words of our happy customers')</p>
        </div>
        <div class="row row-cols-1 row-cols-lg-4">
        @foreach ($teams as $team)
            <div class="col">
                <div class="card border rounded-3">
                    <div class="card-body">
                        <img src="{{ $team->image }}" class="img-fluid rounded-3" alt="">
                        <div class="team-info text-center mt-3">
                            <h4 class="mb-0">{{ $team->current_translation?->title }}</h4>
                            <p>{{ $team->current_translation?->description }}</p>
                        </div>
                        <div class="social-link d-flex align-items-center justify-content-center gap-2">
                            <a href="{{ $team->facebook }}" class="btn btn-outline-dark border"><i class="bi bi-facebook"></i></a>
                            <a href="{{ $team->x }}" class="btn btn-outline-dark border"><i class="bi bi-twitter-x"></i></a>
                            <a href="{{ $team->instagram }}" class="btn btn-outline-dark border"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        </div><!--end row-->
      </div>
    </section>

    @include('website.components.brand',['brands' => $brands])

@endsection
