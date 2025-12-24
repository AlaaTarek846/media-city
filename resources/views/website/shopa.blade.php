@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Thank You'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')


   <!--start main content-->
  <main class="main-content">

    <!--start breadcrumb-->
    <section class="py-4 section-breadcrumb">
      <div class="container px-3">
	  <h2 class="d-none">@lang('messages.Product Details')</h2>
        <nav>
          <ol class="breadcrumb mb-0 gap-2">
            <li class="breadcrumb-item"><a href="javascript:;" class="breadcrumb-link">@lang('messages.homePage')</a></li>
            <li><i class="bi bi-chevron-right"></i></li>
            <li class="breadcrumb-item"><a href="javascript:;" class="breadcrumb-link">{{ $product->category?->current_translation?->title }}</a></li>
            <li><i class="bi bi-chevron-right"></i></li>
            <li class="breadcrumb-item breadcrumb-active">{{ $product->current_translation?->title }}</li>
          </ol>
        </nav>
      </div>
    </section>
    <!--end breadcrumb-->

    <!--start product details-->
    <product-detail :detail="{{ $product }}" :policy="{{ $return_policy }}" :shipping="{{ $shipping_information }}" :rate='@json($rating_percentage)' :user="{{ auth('user')->user() }}" :setting="{{ $setting }}"></product-detail>
    <!--end product details-->

    <!--start Recommended product-->
    <checkout-products :recommended="{{ $products }}" :user="{{ auth('user')->user() }}" :setting="{{ $setting }}"></checkout-products>
    <!--end Recommended product-->
  </main>
  <!--end main content-->

@endsection
