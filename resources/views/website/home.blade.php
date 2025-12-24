@extends('website.layouts.layoutPage')
@section('pageTitle', __('messages.HomePage'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')

 <!--start slider-->
  <section class="main-slider-wrapper">
    <div class="swiper main-slider position-relative">
      <div class="swiper-wrapper">
      @foreach ($banners as $banner)
        <div class="swiper-slide position-relative">
          <div class="slider-content position-absolute top-50 start-0 end-0 translate-middle-y">
            <div class="container px-3">
              <p class="sub-title mb-lg-3">{{ $banner->current_translation?->title }}</p>
              <h2 class="large-title">{{ $banner->current_translation?->description }}</h2>
              <div class="slide-btn mt-lg-5">
                <a href="/shop" class="btn btn-dark px-md-5 py-md-3 rounded-5">@lang('messages.shop now')</a>
              </div>
            </div>
          </div>
          <img src="{{ $banner->image }}" class="img-fluid rounded-0" alt="">
        </div>
        @endforeach

      </div>
      <div class="swiper-nav d-flex align-items-center justify-content-between gap-3 position-absolute end-0 start-0 mx-3 d-none d-lg-flex">
        <div class="slide-icon main-slider-icon-left"><i class="bi bi-arrow-left"></i></div>
        <div class="slide-icon main-slider-icon-right"><i class="bi bi-arrow-right"></i></div>
      </div>
    </div>
  </section>
  <!--end slider-->


  <!--start main content-->
  <main class="main-content">
    <!--start cotegories-->
    <section class="categories-slider-wrapper py-5">
      <div class="container position-relative px-3">
        <div class="d-flex align-items-center justify-content-between mb-5">
          <h2 class="section-title">@lang('messages.Top Categories')</h2>
          <a href="/category" class="btn btn-outline-dark px-4">@lang('messages.All Categories')</a>
        </div>
        <div class="categories-catalog">
          <div class="swiper categories-slider">
            <div class="swiper-wrapper">
            @foreach ($categories as $category)


              <div class="swiper-slide">
                <a href="/shop?category_id={{ $category->id }}">
                  <div class="d-flex flex-column align-items-center gap-3">
                    <img src="{{ $category->image }}" class="cat-img img-fluid rounded-circle" alt="">
                    <div class="text-center">
                      <h3 class="cat-title mb-0">{{ $category->current_translation?->title }}</h3>
                      <p class="mb-0 cat-number">{{ $category->products_count }} @lang('messages.Products_category')</p>
                    </div>
                  </div>
                </a>
              </div>

              @endforeach

            </div>
          </div>
        </div>
        <div class="category-swiper-nav d-flex align-items-center justify-content-center justify-content-lg-between gap-3 end-0 start-0 translate-middle-y">
          <div class="slide-icon categories-slider-icon-left"><i class="bi bi-arrow-left"></i></div>
          <div class="slide-icon categories-slider-icon-right"><i class="bi bi-arrow-right"></i></div>
        </div>
      </div>
    </section>
    <!--end cotegories-->

    <!--start tabular product-->
    <tabular-product :arrivals="{{ $newArrivals }}" :best-seller="{{ $bestSellers }}" :trending="{{ $trending }}" :offers="{{ $offers }}" :user="{{ auth('user')->user() }}" :setting="{{ $setting }}"></tabular-product>
    <!--end tabular product-->


    <!--start special offer-->
    <section class="special-offer py-5">
      <div class="container px-3">
        <div class="d-flex align-items-center justify-content-center mb-4">
          <h2 class="section-title">@lang('messages.Just for you')</h2>
        </div>
        <div class="row g-4">
          <div class="col-12 col-xl-4 d-flex">
            <div class="card w-100 border">
              <div class="card-body">
                <!-- Swiper -->
                <div class="swiper dealsSwiper position-relative">
                  <div class="swiper-wrapper">
                  @foreach ($justForYouProducts->take(3) as $product)
                    <div class="swiper-slide">
                      <div class="text-center position-relative">
                        <div class="discount-ribben position-absolute top-0 start-0 m-3">{{ $product->variants[0]?->discount_percentage }} {{ $setting->current_translation?->title }}</div>
                        <img src="{{ $product->image }}" style="width: 598px!important; height: 399px!important; object-fit: cover!important;" class="img-fluid rounded-3" alt="">
                        <div class="mt-4">
                          <h6>{{ $product->current_translation?->title }}</h6>
                          <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                            <h5 class="mb-0 text-decoration-line-through text-danger">{{ $product->variants[0]?->price_before_discount }} {{ $setting->current_translation?->title }}</h5>
                            <h5 class="mb-0">{{ $product->variants[0]?->price }} {{ $setting->current_translation?->title }}</h5>
                          </div>
                          <div class="mt-3">
                            <a href="/shop" class="btn btn-dark px-4">@lang('messages.Buy Now')</a>
                          </div>

                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                  <div class="swiper-nav d-flex align-items-center justify-content-center gap-3 mt-5">
                    <div class="slide-icon deal-slide-icon-left"><i class="bi bi-arrow-left"></i></div>
                    <div class="slide-icon deal-slide-icon-right"><i class="bi bi-arrow-right"></i></div>
                  </div>
                </div>
                <!--swiper-->
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-8 d-flex">
            <div class="d-flex flex-column gap-4 w-100">
            @if ($justForYouProducts->count() > 3)
               <div class="card rounded-3 bg-light border-0">
                <div class="card-body">
                  <div class="row g-4 align-items-center">
                    <div class="col-12 col-md-7">
                      <h6>{{ $justForYouProducts[3]->current_translation?->title }}</h6>
                      <h5 class="fw-semibold">{{ $justForYouProducts[3]->current_translation?->description }}</h5>
                      <div class="d-flex align-items-center gap-2 my-4">
                        <h4 class="mb-0 text-decoration-line-through text-danger">{{ $justForYouProducts[3]->variants[0]?->price_before_discount }} {{ $setting->current_translation?->title }}</h4>
                        <h4 class="mb-0">{{ $justForYouProducts[3]->variants[0]?->price }} {{ $setting->current_translation?->title }}</h4>
                      </div>
                      <a href="/shop" class="btn btn-dark px-4">{{ __('messages.shop now') }}</a>
                    </div>
                    <div class="col-12 col-md-5">
                      <div>
                        <img src="{{ $justForYouProducts[3]->image }}" class="img-fluid rounded-3" style="height: 200px; width: 250px;" alt="">
                      </div>
                    </div>
                  </div><!--end row-->
                </div>
              </div>

            @endif
            @if ($justForYouProducts->count() > 4)
              <div class="card rounded-3 bg-light border-0">
                <div class="card-body">
                  <div class="row g-4 align-items-center">
                    <div class="col-12 col-md-7 order-2">
                      <h6>{{ $justForYouProducts[4]->current_translation?->title }}</h6>
                      <h5 class="fw-semibold">{{ $justForYouProducts[4]->current_translation?->description }}</h5>
                      <div class="d-flex align-items-center gap-2 my-4">
                        <h4 class="mb-0 text-decoration-line-through text-danger">{{ $justForYouProducts[4]->variants[0]?->price_before_discount }} {{ $setting->current_translation?->title }}</h4>
                        <h4 class="mb-0">{{ $justForYouProducts[4]->variants[0]?->price }} {{ $setting->current_translation?->title }}</h4>
                      </div>
                      <a href="/shop" class="btn btn-dark px-4">{{ __('messages.shop now') }}</a>
                    </div>
                    <div class="col-12 col-md-5">
                      <div class="">
                        <img src="{{ $justForYouProducts[4]->image }}" class="img-fluid rounded-3" style="height: 200px; width: 250px;" alt="">
                      </div>
                    </div>
                  </div><!--end row-->
                </div>
              </div>
            @endif
            @if ($justForYouProducts->count() > 5)
              <div class="card rounded-3 bg-light border-0">
                <div class="card-body">
                  <div class="row g-4 align-items-center">
                    <div class="col-12 col-md-7">
                      <h6>{{ $justForYouProducts[5]->current_translation?->title }}</h6>
                      <h5 class="fw-semibold">{{ $justForYouProducts[5]->current_translation?->description }}</h5>
                      <div class="d-flex align-items-center gap-2 my-4">
                        <h4 class="mb-0 text-decoration-line-through text-danger">{{ $justForYouProducts[5]->variants[0]?->price_before_discount }} {{ $setting->current_translation?->title }}</h4>
                        <h4 class="mb-0">{{ $justForYouProducts[5]->variants[0]?->price }} {{ $setting->current_translation?->title }}</h4>
                      </div>
                      <a href="/shop" class="btn btn-dark px-4">{{ __('messages.shop now') }}</a>
                    </div>
                    <div class="col-12 col-md-5">
                      <div>
                        <img src="{{ $justForYouProducts[5]->image }}" class="img-fluid rounded-3" style="height: 200px; width: 250px;" alt="">
                      </div>
                    </div>
                  </div><!--end row-->
                </div>
              </div>
              @endif
            </div>
          </div>
        </div><!--end row-->
      </div>
    </section>
    <!--end special offer-->


    @include('website.components.brand',['brands' => $brands])

    <!--start shop Instagram-->
    <section class="shop-instagram py-5">
      <div class="container px-3">
        <div class="d-flex align-items-center justify-content-center mb-4">
          <h2 class="section-title">@lang('messages.Shop By Instagram')</h2>
        </div>
        <div class="swiper Instagram-Swiper">
          <div class="swiper-wrapper">
          @foreach ($shopInstagram as $instagram)


            <div class="swiper-slide">
              <div class="position-relative overflow-hidden rounded-3">
                <div
                  class="instagram-block position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center justify-content-center">
                  <a href="{{ $instagram->link }}" class="instagram-logo" target="_plank"><i class="bi bi-instagram"></i></a>
                </div>
                <img src="{{ $instagram->image }}" class="img-fluid rounded-3" alt="">
              </div>
            </div>
        @endforeach
          </div>
        </div>
      </div>
    </section>
    <!--end shop Instagram-->


    <!--services-->
    @include('website.components.about-icon')
    <!--end services-->
  </main>
  <!--end main content-->


@endsection
