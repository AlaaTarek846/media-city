@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Thank You'))
@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{ __('messages.Thank You') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">{{ __('messages.Thank You') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

  <!--start main content-->
  <main class="main-content">

    <section class="py-5 thank-you-section">
      <div class="container px-3">
          <div class="thank-you-content">
            <div class="text-center">
                 <div class="fs-1 mb-3">
                  <i class="fa-solid fa-circle-check text-success" style="font-size: 80px;"></i>
                 </div>
                 <h3 class="mb-3 fw-bold text-success">{{ __('messages.Thank You') }}</h3>
                 <p class="mb-2 fs-5">{{ __('messages.OrderNumber') }}: <strong>{{ $order->order_number }}</strong></p>
                 <p class="mb-4 text-muted">{{ __('messages.Thank you for your order!') }}</p>
                 <p class="mb-4">{{ __('messages.Your order has been placed successfully and will be processed soon.') }}</p>
                 <div class="mt-4">
                   <a href="{{route('web.home')}}" class="btn theme-bg-color text-white btn-md px-5 py-2 rounded-3">
                     <i class="fa-solid fa-arrow-left me-2"></i>{{ __('messages.Continue Shopping') }}
                   </a>
                 </div>
            </div>
          </div>
      </div>
    </section>

  </main>
  <!--end main content-->

@endsection
