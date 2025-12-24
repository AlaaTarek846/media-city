@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Thank You'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.Thank You')])


  <!--start main content-->
  <main class="main-content">

    <section class="py-5 thank-you-section">
      <div class="container px-3">
          <div class="thank-you-content">
            <div class="text-center">
                 <div class="fs-1 mb-3">
                  <i class="bi bi-check-circle-fill text-success"></i>
                 </div>
                 <p class="mb-2">@lang('messages.OrderNumber') {{ $order->order_number }}</p>
                 <h5 class="mb-0 fw-semibold">@lang('messages.Thank you for your order!')</h5>
                 <div class="mt-4">
                   <a href="/home" class="btn btn-dark py-2 px-4 rounded-3">@lang('messages.Continue Shopping')</a>
                 </div>
            </div>
          </div>
      </div>
    </section>

     <!--start Recommended product-->
    <checkout-products :recommended="{{ $products }}" :user="{{ auth('user')->user() }}" :setting="{{ $setting }}"></checkout-products>
    <!--end Recommended product-->

  </main>
  <!--end main content-->

@endsection
