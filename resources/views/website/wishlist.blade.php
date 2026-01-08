@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.wishlist'))
@push("headStyle")
<style>
    /* Make product-option always visible in wishlist page */
    .wishlist-section .product-box-3 .product-header .product-image .product-option,
    .wishlist-section .product-box .product-image .product-option {
        opacity: 1 !important;
        bottom: 15px !important;
        visibility: visible !important;
        display: flex !important;
        pointer-events: auto !important;
    }

    /* Ensure product-option is visible on mobile too */
    @media (max-width: 480px) {
        .wishlist-section .product-box-3 .product-header .product-image .product-option,
        .wishlist-section .product-box .product-image .product-option {
            display: flex !important;
            opacity: 1 !important;
        }
    }

    /* Add a delete button in product-footer as backup */
    .wishlist-section .wishlist-delete-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #fff;
        border: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    [dir="rtl"] .wishlist-section .wishlist-delete-btn{
        left: 10px;
        right: unset;
    }

    .wishlist-section .wishlist-delete-btn:hover {
        background-color: #e74c3c;
        border-color: #e74c3c;
        transform: scale(1.1);
    }

    .wishlist-section .wishlist-delete-btn:hover i {
        color: #fff;
    }

    .wishlist-section .wishlist-delete-btn i {
        color: #e74c3c;
        font-size: 16px;
    }
</style>
@endpush
@section('body')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{ __('messages.wishlist') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">{{ __('messages.wishlist') }}</li>
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
            <div class="row g-sm-4 g-3 row-cols-xxl-5 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section" id="wishlist-products-container">
                @if(auth('user')->check() && $wishlistProducts->count() > 0)
                    @foreach($wishlistProducts as $product)
                        @php
                            $translation = $product->translation ?? $product->translations->first();
                            $variant = $product->variants->first();
                            $category = $product->category;
                            $categoryTranslation = $category->translation ?? $category->translations->first();

                            // Condition badge logic (same as shop.blade.php)
                            $conditionLabel = '';
                            $conditionClass = '';
                            $showBadge = false;

                            if ($product->department) {
                                if ($product->department->id == 2) {
                                    // Buying department: show new/used badge
                                    if ($product->condition === 'new') {
                                        $conditionLabel = __('messages.New');
                                        $conditionClass = 'bg-success';
                                        $showBadge = true;
                                    } elseif ($product->condition === 'used') {
                                        $conditionLabel = __('messages.Used');
                                        $conditionClass = 'bg-info';
                                        $showBadge = true;
                                    }
                                } elseif ($product->department->id == 1 && $product->condition === 'rent') {
                                    // Renting department: show rent badge
                                    $conditionLabel = __('messages.Rent');
                                    $conditionClass = 'bg-warning';
                                    $showBadge = true;
                                }
                            }
                        @endphp
                        <div>
                            <div class="product-box-3 h-100 wow fadeInUp" style="position: relative;">
                                {{-- Delete Button (Top Right) --}}
                                <button type="button" class="wishlist-delete-btn close_button" data-product-id="{{ $product->id }}" title="{{ __('messages.Remove from wishlist') }}">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>

                                <div class="product-header product-box">
                                    {{-- Condition Badge --}}
                                    @if($showBadge && $conditionLabel)
                                        <div class="label-tag {{ $conditionClass }}">
                                            <span>{{ $conditionLabel }}</span>
                                        </div>
                                    @endif
                                    <div class="product-image">
                                        <a href="{{ route('productDetail', $translation->slug ?? $product->id) }}">
                                            <img src="{{ $product->image }}" class="img-fluid blur-up lazyload" alt="{{ $translation->title ?? '' }}">
                                        </a>
                                        <ul class="product-option">
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.View') }}">
                                                <a href="javascript:void(0)" class="view-product-btn" data-bs-toggle="modal" data-bs-target="#view" data-product-id="{{ $product->id }}">
                                                    <i data-feather="eye"></i>
                                                </a>
                                            </li>
                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.Remove from wishlist') }}">
                                                <a href="javascript:void(0)" class="add-to-wishlist wishlist-button close_button" data-product-id="{{ $product->id }}">
                                                    <i data-feather="heart" class="fill"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="product-detail">
                                        <span class="span-name">{{ $categoryTranslation->title ?? '' }}</span>
                                        <a href="{{ route('productDetail', $translation->slug ?? $product->id) }}">
                                            <h5 class="name">{{ $translation->title ?? '' }}</h5>
                                        </a>
                                        @if($variant)
                                            @if($variant->price_before_discount && $variant->discount_percentage > 0)
                                                <h5 class="price">
                                                    <span class="theme-color">{{ __('messages.currency') }} {{ number_format($variant->price, 2) }}</span>
                                                    <del>{{ __('messages.currency') }} {{ number_format($variant->price_before_discount ?? $variant->price, 2) }}</del>
                                                </h5>
                                            @else
                                                <h5 class="price">
                                                    <span class="theme-color">{{ __('messages.currency') }} {{ number_format($variant->price, 2) }}</span>
                                                </h5>
                                            @endif
                                        @endif
                                        <div class="add-to-cart-box bg-white mt-2">
                                            <button class="btn btn-add-cart addcart-button"
                                                    data-product-id="{{ $product->id }}"
                                                    data-variant-id="{{ $variant->id ?? '' }}"
                                                    data-condition="{{ $product->condition }}">{{ __('messages.Add') }}
                                                <span class="add-icon bg-light-gray">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                            </button>
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

