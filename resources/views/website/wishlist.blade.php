@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.wishlist'))
@push("headStyle")

@endpush
@section('body')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Wishlist</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">Wishlist</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Wishlist Section Start -->
    <section class="wishlist-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-3 g-2" id="wishlist-products-container">
                @if(auth('user')->check() && $wishlistProducts->count() > 0)
                    @foreach($wishlistProducts as $product)
                        @php
                            $translation = $product->translation ?? $product->translations->first();
                            $variant = $product->variants->first();
                            $category = $product->category;
                        @endphp
                        <div class="col-xxl-2 col-lg-3 col-md-4 col-6 product-box-contain" data-product-id="{{ $product->id }}">
                            <div class="product-box-3 h-100">
                                <div class="product-header">
                                    <div class="product-image">
                                        <a href="{{ route('productDetail', $translation->slug ?? $product->id) }}">
                                            <img src="{{ $product->image }}" class="img-fluid blur-up lazyload" alt="{{ $translation->title ?? '' }}">
                                        </a>

                                        <div class="product-header-top">
                                            <button class="btn wishlist-button close_button" data-product-id="{{ $product->id }}">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="product-detail">
                                        <span class="span-name">{{ $category->translation->title ?? ($category->translations->first()->title ?? '') }}</span>
                                        <a href="{{ route('productDetail', $translation->slug ?? $product->id) }}">
                                            <h5 class="name">{{ $translation->title ?? '' }}</h5>
                                        </a>
                                        @if($variant && $variant->unit)
                                            <h6 class="unit mt-1">{{ $variant->unit }}</h6>
                                        @endif
                                        <h5 class="price">
                                            @if($variant && $variant->discount_price && $variant->discount_percentage > 0)
                                                <span class="theme-color">{{ __('messages.currency') }} {{ number_format($variant->discount_price, 2) }}</span>
                                                <del>{{ __('messages.currency') }} {{ number_format($variant->price_before_discount ?? $variant->price, 2) }}</del>
                                            @elseif($variant)
                                                <span class="theme-color">{{ __('messages.currency') }} {{ number_format($variant->price, 2) }}</span>
                                            @endif
                                        </h5>

                                        <div class="add-to-cart-box bg-white mt-2">
                                            <button class="btn btn-add-cart addcart-button" 
                                                    data-product-id="{{ $product->id }}"
                                                    data-variant-id="{{ $variant->id ?? '' }}">{{ __('messages.Add') }}
                                                <span class="add-icon bg-light-gray">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </button>
                                            <div class="cart_qty qty-box">
                                                <div class="input-group bg-white">
                                                    <button type="button" class="qty-left-minus bg-gray" data-type="minus" data-field="">
                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                    </button>
                                                    <input class="form-control input-number qty-input" type="text" name="quantity" value="0">
                                                    <button type="button" class="qty-right-plus bg-gray" data-type="plus" data-field="">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @elseif(auth('user')->check() && $wishlistProducts->count() == 0)
                    <div class="col-12">
                        <div class="text-center py-5">
                            <h4>{{ __('messages.Your wishlist is empty') }}</h4>
                            <p class="text-muted">{{ __('messages.Add products to your wishlist to see them here') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Wishlist Section End -->
@endsection

