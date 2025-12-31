@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Shopping Cart'))
@push("headStyle")
@endpush
@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{ __('messages.Shopping Cart') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('web.home') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">{{ __('messages.Shopping Cart') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Cart Section Start -->
    <section class="cart-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-5 g-3">
                <div class="col-xxl-9">
                    <div class="cart-table">
                        <div class="table-responsive-xl">
                            <table class="table">
                                <tbody id="cart-items-container">
                                    <!-- Cart items will be loaded here via JavaScript -->
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="spinner-border" role="status">
                                                <span class="visually-hidden">{{ __('messages.Loading') }}...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3">
                    <div class="summery-box p-sticky">
                        <div class="summery-header">
                            <h3>{{ __('messages.Cart Total') }}</h3>
                        </div>

                        <div class="summery-contain">
                            <ul>
                                <li>
                                    <h4>{{ __('messages.Subtotal') }}</h4>
                                    <h4 class="price cart-subtotal" id="cart-subtotal">{{ __('messages.currency') }} 0.00</h4>
                                </li>
                            </ul>
                        </div>

                        <ul class="summery-total">
                            <li class="list-total border-top-0">
                                <h4>{{ __('messages.Total') }}</h4>
                                <h4 class="price theme-color cart-total" id="cart-total">{{ __('messages.currency') }} 0.00</h4>
                            </li>
                        </ul>

                        <div class="button-group cart-button">
                            <ul>
                                <li>
                                    <a href="{{ route('checkout') }}" class="btn btn-animation proceed-btn fw-bold w-100">{{ __('messages.Process To Checkout') }}</a>
                                </li>

                                <li>
                                    <a href="{{ route('web.home') }}" class="btn btn-dark shopping-button text-light">
                                        <i class="fa-solid fa-arrow-left-long mx-2"></i> {{ __('messages.Return To Shopping') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->
@endsection
