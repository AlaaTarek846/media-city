@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.categories'))

@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.categories')])

	 <!--start shop-->
    <section class="py-5 shop-page-section">
      <div class="container px-3">
         <div class="shop-categories">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @foreach ($categories as $category)
              <div class="col">
                <div class="category-card border p-3 rounded-3">
                  <a href="/shop?category_id={{ $category->id }}">
                    <img src="{{ $category->image }}" class="rounded-3 img-fluid product-img" alt="">
                  </a>
                  <div class="mt-3">
                    <h5 class="mb-1">{{ $category->current_translation?->title }}</h5>
                    <p class="mb-0">{{ $category->products_count }} @lang('messages.Products_category')</p>
                  </div>
                  <div class="d-grid mt-3">
                    <a href="/shop?category_id={{ $category->id }}" class="btn btn-dark rounded-3 d-flex align-items-center justify-content-center gap-2 py-2"><span>@lang('messages.shop now')</span><i class="bi bi-arrow-up-right"></i></a>
                  </div>
                </div>
              </div>
            @endforeach


            </div><!--end row-->
         </div>
      </div>
    </section>
    <!--end shop-->

@endsection
