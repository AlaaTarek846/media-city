@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Blog Details'))

@section('body')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{ __('messages.User Dashboard') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('web.home') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">{{ __('messages.User Dashboard') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- User Dashboard Section Start -->
    <section class="user-dashboard-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 col-lg-4">
                    <div class="dashboard-left-sidebar">
                        <div class="close-button d-flex d-lg-none">
                            <button class="close-sidebar">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="profile-box">
                            <div class="cover-image">
                                <img src="/website/images/inner-page/cover-img.jpg" class="img-fluid blur-up lazyload"
                                     alt="">
                            </div>

                            <div class="profile-contain">
                                <div class="profile-image">
                                    <div class="position-relative">

                                    </div>
                                </div>

                                <div class="profile-name">
                                    <h3>{{ $user->name ?? __('messages.User') }}</h3>
                                    <h6 class="text-content">{{ $user->email ?? '' }}</h6>
                                    @if($user && $user->mobile)
                                        <h6 class="text-content mt-1">{{ $user->mobile }}</h6>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-dashboard-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-dashboard" type="button" role="tab"
                                        aria-controls="pills-dashboard" aria-selected="true"><i data-feather="home"></i>
                                    {{ __('messages.Dashboard') }}</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                                        aria-selected="false"><i data-feather="shopping-bag"></i>{{ __('messages.Order') }}</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-address" type="button" role="tab"
                                        aria-controls="pills-address" aria-selected="false"><i data-feather="map-pin"></i>
                                    {{ __('messages.Address') }}</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false"><i data-feather="user"></i>
                                    {{ __('messages.Profile') }}</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <form action="{{ route('web.logout') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent" style="color: inherit;">
                                        <i data-feather="log-out"></i>{{ __('messages.Logout') }}
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                        Menu</button>
                    <div class="dashboard-right-sidebar">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel"
                                 aria-labelledby="pills-dashboard-tab">
                                <div class="dashboard-home">
                                    <div class="title">
                                        <h2>{{ __('messages.My Dashboard') }}</h2>
                                        <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="dashboard-user-name">
                                        <h6 class="text-content">{{ __('messages.Hello') }}, <b class="text-title">{{ $user->name ?? __('messages.User') }}</b></h6>
                                        <p class="text-content">{{ __('messages.From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.') }}</p>
                                    </div>

                                    <div class="total-box">
                                        <div class="row g-sm-4 g-3">
                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain">
                                                    <img src="/website/images/svg/order.svg"
                                                         class="img-1 blur-up lazyload" alt="">
                                                    <img src="/website/images/svg/order.svg" class="blur-up lazyload"
                                                         alt="">
                                                    <div class="totle-detail">
                                                        <h5>{{ __('messages.Total Order') }}</h5>
                                                        <h3>{{ $user->orders()->count() ?? 0 }}</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain">
                                                    <img src="/website/images/svg/pending.svg"
                                                         class="img-1 blur-up lazyload" alt="">
                                                    <img src="/website/images/svg/pending.svg" class="blur-up lazyload"
                                                         alt="">
                                                    <div class="totle-detail">
                                                        <h5>{{ __('messages.Total Pending Order') }}</h5>
                                                        <h3>{{ $user->orders()->where('order_status_id', 1)->count() ?? 0 }}</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain">
                                                    <img src="/website/images/svg/wishlist.svg"
                                                         class="img-1 blur-up lazyload" alt="">
                                                    <img src="/website/images/svg/wishlist.svg"
                                                         class="blur-up lazyload" alt="">
                                                    <div class="totle-detail">
                                                        <h5>{{ __('messages.Total Wishlist') }}</h5>
                                                        <h3>{{ $user->favorites()->count() ?? 0 }}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-order" role="tabpanel"
                                 aria-labelledby="pills-order-tab">
                                <div class="dashboard-order">
                                    <div class="title">
                                        <h2>{{ __('messages.My Orders History') }}</h2>
                                        <span class="title-leaf title-leaf-gray">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="order-contain" id="orders-container">
                                        @if(isset($orders) && $orders->count() > 0)
                                            @foreach($orders as $order)
                                                @php
                                                    // Safely get status translation
                                                    $statusName = '';
                                                    $statusId = $order->order_status_id;

                                                    if ($order->orderStatus) {
                                                        // Try to get translation using current_translation accessor
                                                        try {
                                                            $statusTranslation = $order->orderStatus->current_translation;
                                                            if ($statusTranslation && isset($statusTranslation->title)) {
                                                                $statusName = $statusTranslation->title;
                                                            } else {
                                                                // Fallback to translation relationship
                                                                $statusTranslation = $order->orderStatus->translation;
                                                                if ($statusTranslation && isset($statusTranslation->title)) {
                                                                    $statusName = $statusTranslation->title;
                                                                } else {
                                                                    // Fallback to first translation
                                                                    $firstTranslation = $order->orderStatus->translations->first();
                                                                    if ($firstTranslation && isset($firstTranslation->title)) {
                                                                        $statusName = $firstTranslation->title;
                                                                    }
                                                                }
                                                            }
                                                        } catch (\Exception $e) {
                                                            // If all fails, use fallback translations based on status ID
                                                            $statusName = '';
                                                        }
                                                    }

                                                    // Fallback translations if status name is still empty
                                                    if (empty($statusName)) {
                                                        switch ($statusId) {
                                                            case 1:
                                                                $statusName = __('messages.New Order');
                                                                break;
                                                            case 2:
                                                                $statusName = __('messages.Preparing Order');
                                                                break;
                                                            case 3:
                                                                $statusName = __('messages.On The Way');
                                                                break;
                                                            case 4:
                                                                $statusName = __('messages.delivered');
                                                                break;
                                                            case 5:
                                                                $statusName = __('messages.canceled');
                                                                break;
                                                            default:
                                                                $statusName = __('messages.Order Status');
                                                                break;
                                                        }
                                                    }

                                                    $isPending = $statusId == 1; // 1 = New Order (Pending)

                                                    // Determine order type (rent or buy)
                                                    $hasRentItems = $order->orderItems->whereNotNull('start_date')->whereNotNull('count_day')->count() > 0;
                                                    $orderType = $hasRentItems ? 'rent' : 'buy';

                                                    // Get status badge class
                                                    $statusBadgeClass = 'badge bg-secondary';
                                                    if ($statusId == 1) $statusBadgeClass = 'badge bg-warning text-dark'; // Pending/New Order
                                                    elseif ($statusId == 2) $statusBadgeClass = 'badge bg-info'; // Preparing Order
                                                    elseif ($statusId == 3) $statusBadgeClass = 'badge bg-primary'; // On The Way
                                                    elseif ($statusId == 4) $statusBadgeClass = 'badge bg-success'; // Delivered
                                                    elseif ($statusId == 5) $statusBadgeClass = 'badge bg-danger'; // Canceled
                                                    else $statusBadgeClass = 'badge bg-secondary'; // Other statuses
                                                @endphp

                                                <div class="order-box dashboard-bg-box" data-order-id="{{ $order->id }}">
                                                    <div class="order-container">
                                                        <div class="order-icon">
                                                            <i data-feather="box"></i>
                                                        </div>

                                                        <div class="order-detail">
                                                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                                                                <h4 class="mb-0">
                                                                    {{ __('messages.Order Number') }}: <strong>{{ $order->order_number }}</strong>
                                                                </h4>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    @if(!empty($statusName))
                                                                        <span class="{{ $statusBadgeClass }} px-3 py-1" style="font-size: 13px; font-weight: 600; display: inline-flex; align-items: center;">
                                                                            <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>{{ $statusName }}
                                                                        </span>
                                                                    @else
                                                                        <span class="{{ $statusBadgeClass }} px-3 py-1" style="font-size: 13px; font-weight: 600; display: inline-flex; align-items: center;">
                                                                            <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>{{ __('messages.Order Status') }}
                                                                        </span>
                                                                    @endif
                                                                    @if($orderType == 'rent')
                                                                        <span class="badge bg-warning text-dark px-3 py-1" style="font-size: 13px; font-weight: 600;">{{ __('messages.Rent') }}</span>
                                                                    @else
                                                                        <span class="badge bg-success px-3 py-1" style="font-size: 13px; font-weight: 600;">{{ __('messages.Buy') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="order-info mb-2">
                                                                <p class="text-content mb-1">
                                                                    <i class="fa-solid fa-calendar me-1"></i>
                                                                    <strong>{{ __('messages.Order Date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
                                                                </p>
                                                                <p class="text-content mb-0">
                                                                    <i class="fa-solid fa-money-bill me-1"></i>
                                                                    <strong>{{ __('messages.Total') }}:</strong>
                                                                    <span class="text-primary fw-bold">{{ $setting->translation->title ?? 'EGP' }} {{ number_format($order->total, 2) }}</span>
                                                                </p>
                                                            </div>
                                                            @if($isPending)
                                                                <button class="btn btn-sm btn-danger mt-2 cancel-order-btn" data-order-id="{{ $order->id }}">
                                                                    <i class="fa-solid fa-times me-1"></i>{{ __('messages.Cancel Order') }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="product-order-detail">
                                                        @foreach($order->orderItems as $orderItem)
                                                            @php
                                                                $product = $orderItem->product;
                                                                $productTitle = '';
                                                                $productImage = '/website/images/placeholder.jpg';

                                                                if ($product) {
                                                                    $productTranslation = $product->current_translation ?? $product->translation ?? null;
                                                                    if (!$productTranslation && $product->translations) {
                                                                        $productTranslation = $product->translations->first();
                                                                    }
                                                                    $productTitle = $productTranslation ? $productTranslation->title : '';
                                                                    $productImage = $product->image ?? '/website/images/placeholder.jpg';
                                                                }

                                                                $isRentItem = !is_null($orderItem->start_date) && !is_null($orderItem->count_day);
                                                            @endphp

                                                            <div class="d-flex align-items-start mb-3 pb-3" style="border-bottom: 1px solid #ececec;">
                                                                @if($product)
                                                                    <a href="{{ route('productDetail', $product->slug) }}" class="order-image me-3">
                                                                        <img src="{{ $productImage }}" style="height: 100px; width: 100px; object-fit: cover;" alt="{{ $productTitle ?: __('messages.Product') }}" class="rounded">
                                                                    </a>

                                                                    <div class="order-wrap flex-grow-1">
                                                                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                                                            <a href="{{ route('productDetail', $product->id) }}">
                                                                                <h5 class="mb-0">{{ $productTitle ?: __('messages.Product') }}</h5>
                                                                            </a>
                                                                            @if($isRentItem)
                                                                                <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 12px; font-weight: 600;">
                                                                                    {{ __('messages.Rent') }}
                                                                                    <span class="ms-1">({{ $orderItem->count_day ?? 0 }} {{ $orderItem->count_day == 1 ? __('messages.Day') : __('messages.Days') }})</span>
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-success px-2 py-1" style="font-size: 12px; font-weight: 600;">{{ __('messages.Buy') }}</span>
                                                                            @endif
                                                                        </div>
                                                                @else
                                                                    <div class="order-image me-3">
                                                                        <img src="{{ $productImage }}" style="height: 100px; width: 100px; object-fit: cover;" alt="{{ __('messages.Product') }}" class="rounded">
                                                                    </div>

                                                                    <div class="order-wrap flex-grow-1">
                                                                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                                                            <h5 class="mb-0">{{ __('messages.Product') }}</h5>
                                                                            @if($isRentItem)
                                                                                <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 12px; font-weight: 600;">
                                                                                    {{ __('messages.Rent') }}
                                                                                    <span class="ms-1">({{ $orderItem->count_day ?? 0 }} {{ $orderItem->count_day == 1 ? __('messages.Day') : __('messages.Days') }})</span>
                                                                                </span>
                                                                            @else
                                                                                <span class="badge bg-success px-2 py-1" style="font-size: 12px; font-weight: 600;">{{ __('messages.Buy') }}</span>
                                                                            @endif
                                                                        </div>
                                                                @endif
                                                                    <ul class="product-size list-unstyled mb-0">
                                                                        <li class="mb-2">
                                                                            <div class="size-box d-flex align-items-center">
                                                                                <h6 class="text-content mb-0 me-2">{{ __('messages.Price') }}:</h6>
                                                                                <h5 class="mb-0">{{ $setting->translation->title ?? 'EGP' }} {{ number_format($orderItem->price, 2) }}</h5>
                                                                            </div>
                                                                        </li>
                                                                        @if($isRentItem)
                                                                            <li class="mb-2">
                                                                                <div class="size-box d-flex align-items-center">
                                                                                    <h6 class="text-content mb-0 me-2">{{ __('messages.Start Date') }}:</h6>
                                                                                    <h6 class="mb-0">{{ $orderItem->start_date ? \Carbon\Carbon::parse($orderItem->start_date)->format('Y-m-d') : '-' }}</h6>
                                                                                </div>
                                                                            </li>
                                                                            <li class="mb-2">
                                                                                <div class="size-box d-flex align-items-center">
                                                                                    <h6 class="text-content mb-0 me-2">{{ __('messages.Count Days') }}:</h6>
                                                                                    <h6 class="mb-0">{{ $orderItem->count_day ?? 0 }} {{ __('messages.Days') }}</h6>
                                                                                </div>
                                                                            </li>
                                                                        @else
                                                                            <li class="mb-2">
                                                                                <div class="size-box d-flex align-items-center">
                                                                                    <h6 class="text-content mb-0 me-2">{{ __('messages.Quantity') }}:</h6>
                                                                                    <h6 class="mb-0">{{ $orderItem->quantity ?? 1 }}</h6>
                                                                                </div>
                                                                            </li>
                                                                        @endif
                                                                        <li>
                                                                            <div class="size-box d-flex align-items-center">
                                                                                <h6 class="text-content mb-0 me-2">{{ __('messages.Total') }}:</h6>
                                                                                <h5 class="mb-0 text-primary">{{ $setting->translation->title ?? 'EGP' }} {{ number_format($orderItem->total, 2) }}</h5>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center py-5">
                                                <i class="fa-solid fa-box-open" style="font-size: 4rem; color: #ddd;"></i>
                                                <p class="text-muted mt-3">{{ __('messages.No orders found') }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-address" role="tabpanel"
                                 aria-labelledby="pills-address-tab">
                                <div class="dashboard-address">
                                    <div class="title title-flex">
                                        <div>
                                            <h2>{{ __('messages.My Address Book') }}</h2>
                                            <span class="title-leaf">
                                                <svg class="icon-width bg-gray">
                                                    <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                                </svg>
                                            </span>
                                        </div>

                                        <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
                                                id="addNewAddressBtn" data-bs-toggle="modal" data-bs-target="#add-address">
                                            <i data-feather="plus" class="me-2"></i> {{ __('messages.Add New Address') }}
                                        </button>
                                    </div>

                                    <!-- Loading indicator -->
                                    <div id="addressesLoading" class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">{{ __('messages.Loading') }}...</span>
                                        </div>
                                    </div>

                                    <!-- Empty state -->
                                    <div id="addressesEmpty" class="text-center py-5 d-none">
                                        <p class="text-muted">{{ __('messages.No addresses found') }}</p>
                                    </div>

                                    <!-- Addresses container -->
                                    <div class="row g-sm-4 g-3" id="addressesContainer">
                                        <!-- Addresses will be loaded here via AJAX -->
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-profile" role="tabpanel"
                                 aria-labelledby="pills-profile-tab">
                                <div class="dashboard-profile">
                                    <div class="title">
                                        <h2>{{ __('messages.My Profile') }}</h2>
                                        <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="profile-detail dashboard-bg-box">
                                        <div class="dashboard-title">
                                            <h3>{{ __('messages.Profile Name') }}</h3>
                                        </div>
                                        <div class="profile-name-detail">
                                            <div class="d-sm-flex align-items-center d-block">
                                                <h3>{{ $user->name ?? __('messages.User') }}</h3>
                                                <div class="product-rating profile-rating">
                                                    <ul class="rating">
                                                        <li>
                                                            <i data-feather="star" class="fill"></i>
                                                        </li>
                                                        <li>
                                                            <i data-feather="star" class="fill"></i>
                                                        </li>
                                                        <li>
                                                            <i data-feather="star" class="fill"></i>
                                                        </li>
                                                        <li>
                                                            <i data-feather="star"></i>
                                                        </li>
                                                        <li>
                                                            <i data-feather="star"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                               data-bs-target="#editProfile">{{ __('messages.Edit') }}</a>
                                        </div>

                                        <div class="location-profile">
                                            <ul>
                                                @if($user->mobile)
                                                <li>
                                                    <div class="location-box">
                                                        <i data-feather="phone"></i>
                                                        <h6>{{ $user->mobile }}</h6>
                                                    </div>
                                                </li>
                                                @endif

                                                <li>
                                                    <div class="location-box">
                                                        <i data-feather="mail"></i>
                                                        <h6>{{ $user->email ?? '' }}</h6>
                                                    </div>
                                                </li>

                                                @if($user->whatsapp)
                                                <li>
                                                    <div class="location-box">
                                                        <i data-feather="message-circle"></i>
                                                        <h6>{{ $user->whatsapp }}</h6>
                                                    </div>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>

                                        <div class="profile-description">
                                            <p>{{ __('messages.User Type') }}: <strong>{{ __('messages.' . ucfirst($user->user_type ?? 'person')) }}</strong></p>
                                            @if($user->how_did_you_hear_about_us)
                                            <p class="mt-2">{{ __('messages.How did you hear about us?') }}: <strong>{{ $user->how_did_you_hear_about_us }}</strong></p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="profile-about dashboard-bg-box">
                                        <div class="row">
                                            <div class="col-xxl-7">
                                                <div class="dashboard-title mb-3">
                                                    <h3>{{ __('messages.Profile Information') }}</h3>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        @if($user->mobile)
                                                        <tr>
                                                            <td>{{ __('messages.Mobile Number') }}:</td>
                                                            <td>
                                                                <a href="tel:{{ $user->mobile }}">{{ $user->mobile }}</a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @if($user->whatsapp)
                                                        <tr>
                                                            <td>{{ __('messages.WhatsApp Number') }}:</td>
                                                            <td>
                                                                <a href="https://wa.me/{{ $user->whatsapp }}" target="_blank">{{ $user->whatsapp }}</a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @php
                                                            $primaryAddress = $user->addresses()->where('is_primary', true)->first();
                                                        @endphp
                                                        @if($primaryAddress)
                                                        <tr>
                                                            <td>{{ __('messages.Primary Address') }}:</td>
                                                            <td>{{ $primaryAddress->address ?? '' }}</td>
                                                        </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="dashboard-title mb-3">
                                                    <h3>{{ __('messages.Login Details') }}</h3>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <td>{{ __('messages.Email') }}:</td>
                                                            <td>
                                                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ __('messages.Password') }}:</td>
                                                            <td>
                                                                <a href="javascript:void(0)">●●●●●●
                                                                    <span data-bs-toggle="modal"
                                                                          data-bs-target="#editPassword" class="ms-2">{{ __('messages.Edit') }}</span></a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-xxl-5">
                                                <div class="profile-image">
{{--                                                    <img src="/website/images/inner-page/dashboard-profile.png"--}}
{{--                                                         class="img-fluid blur-up lazyload" alt="{{ __('messages.Profile Picture') }}">--}}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- User Dashboard Section End -->

    <!-- Add address modal box start -->
    <div class="modal fade theme-modal" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.Add a new address') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeAddressModal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Success/Error Messages Container -->
                    <div id="addAddressMessage" class="alert d-none mb-3" role="alert"></div>

                    <form id="addAddressForm" novalidate>
                        <input type="hidden" id="addressId" name="address_id" value="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="addressName" name="name" placeholder="{{ __('messages.Recipient Name') }}">
                                    <label for="addressName">{{ __('messages.Recipient Name') }}</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="addressTitle" name="title" placeholder="{{ __('messages.Address Title') }}" required maxlength="255">
                                    <label for="addressTitle">{{ __('messages.Address Title') }} <span class="text-danger">*</span> <small>({{ __('messages.e.g. Home, Office') }})</small></label>
                                    <div class="invalid-feedback">{{ __('messages.Please enter an address title') }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="addressArea" name="area_id" required>
                                        <option value="" selected disabled>{{ __('messages.Select Area') }}</option>
                                        @if(isset($areas))
                                            @foreach($areas as $area)
                                                <option value="{{ $area->id }}">{{  $area->current_translation?->title ?? '' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="addressArea">{{ __('messages.Area') }} <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">{{ __('messages.Please select an area') }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check ps-0 m-0 remember-box">
                                    <input class="checkbox_animated check-box" type="checkbox" id="isPrimary" name="is_primary" value="1">
                                    <label class="form-check-label" for="isPrimary">{{ __('messages.Set as primary address') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <textarea class="form-control" placeholder="{{ __('messages.Enter full address') }}" id="addressText" name="address" style="height: 100px" required maxlength="500"></textarea>
                                    <label for="addressText">{{ __('messages.Full Address') }} <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">{{ __('messages.Please enter the full address') }}</div>
                                </div>
                            </div>

                            <!-- Leaflet Map Section -->
                            <div class="col-12">
                                <label class="form-label">{{ __('messages.Select location on map') }} <span class="text-danger">*</span></label>

                                <!-- Search input for Leaflet Geocoder -->
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="mapSearch" placeholder="{{ __('messages.Search for a location') }}" autocomplete="off">
                                    </div>
                                    <small class="text-muted">{{ __('messages.Type to search for a location or click on the map') }}</small>
                                </div>

                                <div id="addressMap" style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 8px;"></div>
                                <small class="text-muted mt-2 d-block">{{ __('messages.Click on the map to select your location') }}</small>
                                <div id="mapLocationError" class="text-danger small mt-1 d-none">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i> {{ __('messages.Please select a location on the map') }}
                                </div>
                            </div>

                            <!-- Hidden inputs for lat/lng -->
                            <input type="hidden" id="addressLat" name="lat" value="" required>
                            <input type="hidden" id="addressLng" name="lng" value="" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">{{ __('messages.Close') }}</button>
                    <button type="button" class="btn theme-bg-color btn-md text-white" id="saveAddressBtn">{{ __('messages.Save Address') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add address modal box end -->

    <!-- Edit Profile Start -->
    <div class="modal fade theme-modal" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel2"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">{{ __('messages.Edit Profile') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Success/Error Messages Container -->
                    <div id="editProfileMessage" class="alert d-none mb-3" role="alert"></div>

                    <form id="editProfileForm" enctype="multipart/form-data" novalidate>
                        <div class="row g-4">
                            <!-- Basic Information -->
                            <div class="col-12">
                                <h5 class="mb-3">{{ __('messages.Basic Information') }}</h5>
                            </div>

                            <div class="col-xxl-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="pname" name="name" value="{{ $user->name ?? '' }}" required maxlength="255">
                                    <label for="pname">{{ __('messages.Full name') }} <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">{{ __('messages.Please enter your full name') }}</div>
                                </div>
                            </div>

                            <div class="col-xxl-6">
                                <div class="form-floating theme-form-floating">
                                    <input class="form-control" type="tel" value="{{ $user->mobile ?? '' }}" name="mobile" id="mobile"
                                           maxlength="20">
                                    <label for="mobile">{{ __('messages.Mobile number') }}</label>
                                </div>
                            </div>

                            <div class="col-xxl-6">
                                <div class="form-floating theme-form-floating">
                                    <input class="form-control" type="tel" value="{{ $user->whatsapp ?? '' }}" name="whatsapp" id="whatsapp"
                                           maxlength="20">
                                    <label for="whatsapp">{{ __('messages.WhatsApp number') }}</label>
                                </div>
                            </div>

                            <div class="col-xxl-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="url" class="form-control" id="facebookLink" name="link"
                                           value="{{ $user->link }}"
                                           placeholder="{{ __('messages.Social Media Links')  }}">
                                    <label for="facebookLink">{{ __('messages.Social Media Links')  }}</label>
                                </div>
                            </div>

                            <!-- Documents Section - Person/Studio -->
                            <div class="col-12 mt-3 person-studio-documents" style="display: {{ ($user->user_type == 'person' || $user->user_type == 'studio') ? 'block' : 'none' }};">
                                <h5 class="mb-3">{{ __('messages.National ID Documents') }}</h5>
                            </div>

                            <div class="col-xxl-6 person-studio-documents" style="display: {{ ($user->user_type == 'person' || $user->user_type == 'studio') ? 'block' : 'none' }};">
                                <div class="form-floating theme-form-floating">
                                    <input type="file" class="form-control" id="idCardFront" name="id_card_front" accept="image/jpeg,image/jpg,image/png">
                                    <label for="idCardFront">{{ __('messages.National ID Front') }}</label>
                                    @if($user->user_type == 'person' && isset($user->personProfile) && $user->personProfile && $user->personProfile->id_card_front)
                                        <small class="text-muted d-block mt-1">
                                            <a href="{{ $user->personProfile->id_card_front }}" target="_blank">{{ __('messages.View current image') }}</a>
                                        </small>
                                    @elseif($user->user_type == 'studio' && isset($user->studioProfile) && $user->studioProfile && $user->studioProfile->id_card_front)
                                        <small class="text-muted d-block mt-1">
                                            <a href="{{ $user->studioProfile->id_card_front }}" target="_blank">{{ __('messages.View current image') }}</a>
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xxl-6 person-studio-documents" style="display: {{ ($user->user_type == 'person' || $user->user_type == 'studio') ? 'block' : 'none' }};">
                                <div class="form-floating theme-form-floating">
                                    <input type="file" class="form-control" id="idCardBack" name="id_card_back" accept="image/jpeg,image/jpg,image/png">
                                    <label for="idCardBack">{{ __('messages.National ID Back') }}</label>
                                    @if($user->user_type == 'person' && isset($user->personProfile) && $user->personProfile && $user->personProfile->id_card_back)
                                        <small class="text-muted d-block mt-1">
                                            <a href="{{ $user->personProfile->id_card_back }}" target="_blank">{{ __('messages.View current image') }}</a>
                                        </small>
                                    @elseif($user->user_type == 'studio' && isset($user->studioProfile) && $user->studioProfile && $user->studioProfile->id_card_back)
                                        <small class="text-muted d-block mt-1">
                                            <a href="{{ $user->studioProfile->id_card_back }}" target="_blank">{{ __('messages.View current image') }}</a>
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Documents Section - Company -->
                            <div class="col-12 mt-3 company-documents" style="display: {{ $user->user_type == 'company' ? 'block' : 'none' }};">
                                <h5 class="mb-3">{{ __('messages.Company Documents') }}</h5>
                            </div>

                            <div class="col-xxl-6 company-documents" style="display: {{ $user->user_type == 'company' ? 'block' : 'none' }};">
                                <div class="form-floating theme-form-floating">
                                    <input type="file" class="form-control" id="commercialRegister" name="commercial_register_image" accept="image/jpeg,image/jpg,image/png">
                                    <label for="commercialRegister">{{ __('messages.Commercial Register') }}</label>
                                    @if($user->user_type == 'company' && isset($user->companyProfile) && $user->companyProfile && $user->companyProfile->commercial_register_image)
                                        <small class="text-muted d-block mt-1">
                                            <a href="{{ $user->companyProfile->commercial_register_image }}" target="_blank">{{ __('messages.View current image') }}</a>
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xxl-6 company-documents" style="display: {{ $user->user_type == 'company' ? 'block' : 'none' }};">
                                <div class="form-floating theme-form-floating">
                                    <input type="file" class="form-control" id="taxCard" name="tax_card_image" accept="image/jpeg,image/jpg,image/png">
                                    <label for="taxCard">{{ __('messages.Tax Card') }}</label>
                                    @if($user->user_type == 'company' && isset($user->companyProfile) && $user->companyProfile && $user->companyProfile->tax_card_image)
                                        <small class="text-muted d-block mt-1">
                                            <a href="{{ $user->companyProfile->tax_card_image }}" target="_blank">{{ __('messages.View current image') }}</a>
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                            data-bs-dismiss="modal">{{ __('messages.Close') }}</button>
                    <button type="button" id="saveProfileBtn"
                            class="btn theme-bg-color btn-md fw-bold text-light">{{ __('messages.Save changes') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile End -->

    <!-- Edit Password Modal Start -->
    <div class="modal fade theme-modal" id="editPassword" tabindex="-1" aria-labelledby="editPasswordLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasswordLabel">{{ __('messages.Change Password') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Success/Error Messages Container -->
                    <div id="changePasswordMessage" class="alert d-none mb-3" role="alert"></div>

                    <form id="changePasswordForm" novalidate>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="{{ __('messages.Current Password') }}" required>
                                    <label for="currentPassword">{{ __('messages.Current Password') }} <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">{{ __('messages.Please enter your current password') }}</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="password" class="form-control" id="newPassword" name="password" placeholder="{{ __('messages.New Password') }}" required minlength="8" maxlength="50">
                                    <label for="newPassword">{{ __('messages.New Password') }} <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">{{ __('messages.Please enter a new password (minimum 8 characters)') }}</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" placeholder="{{ __('messages.Confirm Password') }}" required minlength="8" maxlength="50">
                                    <label for="confirmPassword">{{ __('messages.Confirm Password') }} <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">{{ __('messages.Please confirm your new password') }}</div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">{{ __('messages.Close') }}</button>
                    <button type="button" class="btn theme-bg-color btn-md text-white" id="savePasswordBtn">{{ __('messages.Change Password') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Password Modal End -->

@endsection

@push('headScript')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <!-- Leaflet Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <!-- Leaflet Geocoder JS -->
    <script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>
    <script>
        (function() {
            var map;
            var marker;
            var geocoder;
            var defaultLat = 30.0444; // Default location (Cairo)
            var defaultLng = 31.2357;
            var searchTimeout;

            // Initialize map when modal is shown
            $('#add-address').on('shown.bs.modal', function() {
                if (!map) {
                    initMap();
                    initGeocoder();
                } else {
                    // Invalidate size to fix map display
                    setTimeout(function() {
                        if (map) {
                            map.invalidateSize();
                        }
                    }, 300);
                }
            });

            /**
             * Initialize Leaflet Map
             * Sets up map with default location and click handler
             */
            function initMap() {
                var mapElement = document.getElementById('addressMap');
                if (!mapElement) return;

                // Check if Leaflet is loaded
                if (typeof L === 'undefined') {
                    mapElement.innerHTML = '<div class="alert alert-warning p-4 text-center">' +
                        '<i class="fa-solid fa-exclamation-triangle me-2"></i>' +
                        '<strong>{{ __("messages.Error") }}:</strong> ' +
                        '{{ __("messages.Leaflet library is not loaded") }}' +
                        '</div>';
                    return;
                }

                // Create map centered on default location [lat, lng] for Leaflet
                map = L.map('addressMap', {
                    center: [defaultLat, defaultLng], // [lat, lng] for Leaflet
                    zoom: 12
                });

                // Add OpenStreetMap tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                // Add click listener to map
                map.on('click', function(e) {
                    placeMarker([e.latlng.lat, e.latlng.lng]);
                });

                // Try to get user's current location
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            var userLocation = [position.coords.latitude, position.coords.longitude]; // [lat, lng]
                            map.setView(userLocation, 15);
                            placeMarker(userLocation);
                        },
                        function() {
                            // If geolocation fails, use default location
                            placeMarker([defaultLat, defaultLng]);
                        }
                    );
                } else {
                    // Browser doesn't support geolocation
                    placeMarker([defaultLat, defaultLng]);
                }

                // Invalidate size when modal is fully shown
                setTimeout(function() {
                    if (map) {
                        map.invalidateSize();
                    }
                }, 300);
            }

            /**
             * Initialize Leaflet Geocoder for search
             * Allows users to search for locations using Nominatim (OpenStreetMap)
             */
            function initGeocoder() {
                var searchInput = document.getElementById('mapSearch');
                if (!searchInput || !map) return;

                // Create search button if it doesn't exist
                var searchContainer = $(searchInput).parent();
                var searchBtn = searchContainer.find('.search-btn');
                if (searchBtn.length === 0) {
                    searchBtn = $('<button type="button" class="btn btn-primary ms-2 search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>');
                    searchContainer.append(searchBtn);
                }

                // Search function using Nominatim API
                function performSearch(query) {
                    if (!query || query.trim() === '') {
                        return;
                    }

                    // Disable search button during search
                    searchBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');

                    // Use Nominatim API directly
                    var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&limit=5&countrycodes=ae,sa,eg&accept-language={{ app()->getLocale() === "ar" ? "ar" : "en" }}';

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'User-Agent': 'MediaCity Application'
                        },
                        success: function(results) {
                            if (results && results.length > 0) {
                                var result = results[0];
                                var lat = parseFloat(result.lat);
                                var lng = parseFloat(result.lon);

                                // Place marker on selected location
                                placeMarker([lat, lng]);

                                // Update address field if empty
                                if (!$('#addressText').val()) {
                                    $('#addressText').val(result.display_name);
                                }

                                // Center map on result
                                map.setView([lat, lng], 15);
                            } else {
                                alert('{{ __("messages.No results found") }}');
                            }
                        },
                        error: function() {
                            alert('{{ __("messages.Error searching for location") }}');
                        },
                        complete: function() {
                            // Re-enable search button
                            searchBtn.prop('disabled', false).html('<i class="fa-solid fa-magnifying-glass"></i>');
                        }
                    });
                }

                // Remove existing event listeners to avoid duplicates
                searchBtn.off('click');
                $(searchInput).off('keypress');

                // Search on button click
                searchBtn.on('click', function() {
                    performSearch($(searchInput).val());
                });

                // Search on Enter key
                $(searchInput).on('keypress', function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        performSearch($(this).val());
                    }
                });
            }

            /**
             * Place marker on map and update lat/lng inputs
             *
             * @param {Array} coordinates - [lat, lng] array for Leaflet
             */
            function placeMarker(coordinates) {
                if (!map || !coordinates || coordinates.length < 2) return;

                var lat = coordinates[0];
                var lng = coordinates[1];

                // Remove existing marker
                if (marker) {
                    map.removeLayer(marker);
                }

                // Create custom icon
                var customIcon = L.divIcon({
                    className: 'leaflet-custom-marker',
                    html: '<div style="width: 30px; height: 30px; border-radius: 50%; background-color: #3b82f6; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"></div>',
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });

                // Create new marker
                marker = L.marker([lat, lng], {
                    icon: customIcon,
                    draggable: true
                }).addTo(map);

                // Update hidden inputs
                document.getElementById('addressLat').value = lat;
                document.getElementById('addressLng').value = lng;

                // Add drag listener to update coordinates when marker is moved
                marker.on('dragend', function(e) {
                    var position = marker.getLatLng();
                    document.getElementById('addressLat').value = position.lat;
                    document.getElementById('addressLng').value = position.lng;
                });

                // Center map on marker
                map.setView([lat, lng], map.getZoom());
            }

            /**
             * Handle form submission via AJAX
             */
            $('#saveAddressBtn').on('click', function(e) {
                e.preventDefault();

                var form = document.getElementById('addAddressForm');
                var messageDiv = document.getElementById('addAddressMessage');
                var submitBtn = $(this);
                var originalBtnText = submitBtn.html();

                // Hide previous messages
                if (messageDiv) {
                    $(messageDiv).addClass('d-none').removeClass('alert-success alert-danger');
                }

                // Custom validation for map location
                var lat = $('#addressLat').val();
                var lng = $('#addressLng').val();
                var mapError = $('#mapLocationError');

                if (!lat || !lng || lat === '' || lng === '') {
                    mapError.removeClass('d-none');
                    mapError[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    return;
                } else {
                    mapError.addClass('d-none');
                }

                // Validate form
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    // Scroll to first invalid field
                    var firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        firstInvalid.focus();
                    }
                    return;
                }

                // Prepare form data
                var addressId = $('#addressId').val();
                var formData = {
                    name: $('#addressName').val(),
                    title: $('#addressTitle').val(),
                    address: $('#addressText').val(),
                    area_id: $('#addressArea').val(),
                    lat: $('#addressLat').val(),
                    lng: $('#addressLng').val(),
                    is_primary: $('#isPrimary').is(':checked') ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                };

                // Determine URL and method based on whether it's update or create
                var url = '/api/web/add-address';
                var method = 'POST';
                if (addressId) {
                    url = '/api/web/edit-address/' + addressId;
                    method = 'PUT';
                }

                // Disable submit button
                submitBtn.prop('disabled', true).html('{{ __("messages.Sending") }}...');

                // Submit via AJAX
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        // Show success message
                        if (messageDiv) {
                            var successMsg = addressId ? '{{ __("messages.Address updated successfully") }}' : '{{ __("messages.Address added successfully") }}';
                            $(messageDiv)
                                .removeClass('d-none alert-danger')
                                .addClass('alert-success')
                                .html('<strong>{{ __("messages.Success") }}!</strong> ' + (data.message || successMsg));
                        }

                        // Reset form
                        form.reset();
                        form.classList.remove('was-validated');
                        $('#addressId').val('');
                        $('#addressLat').val('');
                        $('#addressLng').val('');

                        // Remove marker
                        if (marker) {
                            map.removeLayer(marker);
                            marker = null;
                        }

                        loadAddresses()

                        // Close modal after 1.5 seconds
                        setTimeout(function() {
                            $('#add-address').modal('hide');
                        }, 1500);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        var errorMessage = '{{ __("messages.An error occurred. Please try again.") }}';

                        // Try to get error message from response
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = '<ul class="mb-0 ps-3">';
                            $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                if (Array.isArray(errorArray)) {
                                    $.each(errorArray, function(index, error) {
                                        errors += '<li>' + error + '</li>';
                                    });
                                } else {
                                    errors += '<li>' + errorArray + '</li>';
                                }
                            });
                            errors += '</ul>';
                            errorMessage = errors;
                        }

                        // Show error message with better styling
                        if (messageDiv) {
                            $(messageDiv)
                                .removeClass('d-none alert-success')
                                .addClass('alert-danger')
                                .html('<div class="d-flex align-items-start">' +
                                    '<i class="fa-solid fa-exclamation-circle me-2 mt-1"></i>' +
                                    '<div><strong>{{ __("messages.Error") }}!</strong><br>' + errorMessage + '</div>' +
                                    '</div>');
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }

                        // Highlight invalid fields
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                var field = $('[name="' + key + '"]');
                                if (field.length) {
                                    field.addClass('is-invalid');
                                    // Remove invalid class on input
                                    field.on('input change', function() {
                                        $(this).removeClass('is-invalid');
                                    });
                                }
                            });
                        }
                    },
                    complete: function() {
                        // Re-enable submit button
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            // Reset form when modal is hidden
            $('#add-address').on('hidden.bs.modal', function() {
                var form = document.getElementById('addAddressForm');
                if (form) {
                    form.reset();
                    form.classList.remove('was-validated');
                    $('#addressId').val('');
                    $('#addressLat').val('');
                    $('#addressLng').val('');
                    $('#mapSearch').val('');

                    // Remove all validation classes
                    $(form).find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                }
                // Update modal title
                $('#exampleModalLabel').text('{{ __("messages.Add a new address") }}');
                $('#saveAddressBtn').text('{{ __("messages.Save Address") }}');
                var messageDiv = document.getElementById('addAddressMessage');
                if (messageDiv) {
                    $(messageDiv).addClass('d-none').removeClass('alert-success alert-danger');
                }
                // Hide map location error
                $('#mapLocationError').addClass('d-none');
                // Remove marker
                if (marker) {
                    map.removeLayer(marker);
                    marker = null;
                }
                // Clear search input
                var searchInput = document.getElementById('mapSearch');
                if (searchInput) {
                    searchInput.value = '';
                }
                // Remove search button if exists
                var searchContainer = $('#mapSearch').parent();
                var searchBtn = searchContainer.find('.search-btn');
                if (searchBtn.length > 0) {
                    searchBtn.remove();
                }
                // Reset map (keep it but clear marker)
                if (map) {
                    map.setView([defaultLat, defaultLng], 12);
                }
            });

            /**
             * Load addresses from API and display them
             */
            function loadAddresses() {
                $('#addressesLoading').removeClass('d-none');
                $('#addressesEmpty').addClass('d-none');
                $('#addressesContainer').empty();

                $.ajax({
                    url: '/api/web/user-addresses',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#addressesLoading').addClass('d-none');
                        renderAddresses(response.data);
                        if(response.data.length == 0) {
                            $('#addressesEmpty').removeClass('d-none');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading addresses:', error);
                        $('#addressesLoading').addClass('d-none');
                        $('#addressesEmpty').removeClass('d-none');
                    }
                });
            }

            /**
             * Render addresses in the container
             */
            function renderAddresses(addresses) {
                var container = $('#addressesContainer');
                container.empty();

                $.each(addresses, function(index, address) {
                    var areaName = address.area && address.area.translation ? address.area.translation.title : (address.area ? address.area.title : '');
                    var isPrimary = address.is_primary ? 'checked' : '';
                    var primaryClass = address.is_primary ? 'primary-address' : '';

                    var addressHtml = '<div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">' +
                        '<div class="address-box ' + primaryClass + '">' +
                        '<div>' +
                        '<div class="form-check">' +
                        '<input class="form-check-input" type="radio" name="primaryAddress" ' + isPrimary + ' disabled>' +
                        '</div>' +
                        '<div class="label">' +
                        '<label>' + (address.title || '{{ __("messages.Address") }}') + '</label>'  +
                        '</div>' +
                        '<div class="table-responsive address-table">' +
                        '<table class="table">' +
                        '<tbody>';

                    if (address.name) {
                        addressHtml += '<tr><td colspan="2">' + address.name + '</td></tr>';
                    }

                    addressHtml += '<tr>' +
                        '<td>{{ __("messages.Address") }}:</td>' +
                        '<td><p>' + (address.address || '') + '</p></td>' +
                        '</tr>';

                    if (areaName) {
                        addressHtml += '<tr>' +
                            '<td>{{ __("messages.Area") }}:</td>' +
                            '<td>' + areaName + '</td>' +
                            '</tr>';
                    }

                    addressHtml += '</tbody>' +
                        '</table>' +
                        '</div>' +
                        '</div>' +
                        '<div class="button-group">' +
                        '<button class="btn btn-sm add-button w-100 edit-address-btn" data-address-id="' + address.id + '">' +
                        '<i data-feather="edit"></i> {{ __("messages.Edit") }}</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';


                    {{--   + '<button class="btn btn-sm add-button w-100 remove-address-btn" data-address-id="' + address.id + '">' +--}}
                    {{--'<i data-feather="trash-2"></i> {{ __("messages.Remove") }}</button>'--}}

                    container.append(addressHtml);
                });

                // Re-initialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }

            /**
             * Edit address - load address data into modal
             */
            function editAddress(addressId) {
                $.ajax({
                    url: '/api/web/user-addresses',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var address = response.data.find(function(addr) {
                            return addr.id == addressId;
                        });

                        if (address) {
                            // Fill form with address data
                            $('#addressId').val(address.id);
                            $('#addressName').val(address.name || '');
                            $('#addressTitle').val(address.title || '');
                            $('#addressText').val(address.address || '');
                            $('#addressArea').val(address.area_id || '');
                            $('#isPrimary').prop('checked', address.is_primary || false);
                            $('#addressLat').val(address.lat || '');
                            $('#addressLng').val(address.lng || '');

                            // Update modal title
                            $('#exampleModalLabel').text('{{ __("messages.Edit Address") }}');
                            $('#saveAddressBtn').text('{{ __("messages.Update Address") }}');

                            // Place marker on map if lat/lng exist
                            if (address.lat && address.lng) {
                                if (map) {
                                    placeMarker([parseFloat(address.lat), parseFloat(address.lng)]);
                                } else {
                                    // If map not initialized, wait for modal to show
                                    $('#add-address').one('shown.bs.modal', function() {
                                        setTimeout(function() {
                                            if (map) {
                                                placeMarker([parseFloat(address.lat), parseFloat(address.lng)]);
                                            }
                                        }, 500);
                                    });
                                }
                            }

                            // Open modal
                            $('#add-address').modal('show');
                        }
                        loadAddresses()
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading address:', error);
                        alert('{{ __("messages.Error loading address") }}');
                    }
                });
            }

            /**
             * Remove address
             * Prevents deletion if it's the only address
             */
            function removeAddress(addressId) {
                // First, check how many addresses exist
                $.ajax({
                    url: '/api/web/user-addresses',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var addresses = response.data || [];

                        // Check if this is the only address
                        if (addresses.length <= 1) {
                            alert('{{ __("messages.Cannot delete the only address. Please add another address first.") }}');
                            return;
                        }

                        // Confirm deletion
                        if (!confirm('{{ __("messages.Are you sure you want to remove this address?") }}')) {
                            return;
                        }

                        // Proceed with deletion
                        $.ajax({
                            url: '/api/web/remove-address/' + addressId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(response) {
                                alert(response.message || '{{ __("messages.Address removed successfully") }}');
                                loadAddresses();
                            },
                            error: function(xhr, status, error) {
                                console.error('Error removing address:', error);
                                var errorMsg = '{{ __("messages.Error removing address") }}';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                alert(errorMsg);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading addresses:', error);
                        alert('{{ __("messages.Error loading addresses") }}');
                    }
                });
            }

            // Handle edit button click
            $(document).on('click', '.edit-address-btn', function() {
                var addressId = $(this).data('address-id');
                editAddress(addressId);
            });

            // Handle remove button click
            $(document).on('click', '.remove-address-btn', function() {
                var addressId = $(this).data('address-id');
                removeAddress(addressId);
            });

            loadAddresses();

            /**
             * Handle edit profile form submission
             */
            $('#saveProfileBtn').on('click', function(e) {
                e.preventDefault();

                var form = document.getElementById('editProfileForm');
                var messageDiv = document.getElementById('editProfileMessage');
                var submitBtn = $(this);
                var originalBtnText = submitBtn.html();

                // Hide previous messages
                if (messageDiv) {
                    $(messageDiv).addClass('d-none').removeClass('alert-success alert-danger');
                }

                // Validate form
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    // Scroll to first invalid field
                    var firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        firstInvalid.focus();
                    }
                    return;
                }

                // Prepare form data with files
                var formData = new FormData(form);
                formData.append('_token', '{{ csrf_token() }}');

                // Disable submit button
                submitBtn.prop('disabled', true).html('{{ __("messages.Saving") }}...');

                // Submit via AJAX
                $.ajax({
                    url: '/api/web/updateProfile',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        // Show success message
                        if (messageDiv) {
                            $(messageDiv)
                                .removeClass('d-none alert-danger')
                                .addClass('alert-success')
                                .html('<div class="d-flex align-items-start">' +
                                    '<i class="fa-solid fa-check-circle me-2 mt-1"></i>' +
                                    '<div><strong>{{ __("messages.Success") }}!</strong><br>' + (data.message || '{{ __("messages.Profile updated successfully") }}') + '</div>' +
                                    '</div>');
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }

                        // Reload page after 2 seconds to show updated data
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        var errorMessage = '{{ __("messages.An error occurred. Please try again.") }}';

                        // Try to get error message from response
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = '<ul class="mb-0 ps-3">';
                            $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                if (Array.isArray(errorArray)) {
                                    $.each(errorArray, function(index, error) {
                                        errors += '<li>' + error + '</li>';
                                    });
                                } else {
                                    errors += '<li>' + errorArray + '</li>';
                                }
                            });
                            errors += '</ul>';
                            errorMessage = errors;
                        }

                        // Show error message
                        if (messageDiv) {
                            $(messageDiv)
                                .removeClass('d-none alert-success')
                                .addClass('alert-danger')
                                .html('<div class="d-flex align-items-start">' +
                                    '<i class="fa-solid fa-exclamation-circle me-2 mt-1"></i>' +
                                    '<div><strong>{{ __("messages.Error") }}!</strong><br>' + errorMessage + '</div>' +
                                    '</div>');
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }

                        // Highlight invalid fields
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                var field = $('[name="' + key + '"]');
                                if (field.length) {
                                    field.addClass('is-invalid');
                                    // Remove invalid class on input
                                    field.on('input change', function() {
                                        $(this).removeClass('is-invalid');
                                    });
                                }
                            });
                        }
                    },
                    complete: function() {
                        // Re-enable submit button
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            // Reset form when profile modal is hidden
            $('#editProfile').on('hidden.bs.modal', function() {
                var form = document.getElementById('editProfileForm');
                if (form) {
                    form.classList.remove('was-validated');
                    $(form).find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                }
                var messageDiv = document.getElementById('editProfileMessage');
                if (messageDiv) {
                    $(messageDiv).addClass('d-none').removeClass('alert-success alert-danger');
                }
            });

            /**
             * Handle change password form submission
             */
            $('#savePasswordBtn').on('click', function(e) {
                e.preventDefault();

                var form = document.getElementById('changePasswordForm');
                var messageDiv = document.getElementById('changePasswordMessage');
                var submitBtn = $(this);
                var originalBtnText = submitBtn.html();

                // Hide previous messages
                if (messageDiv) {
                    $(messageDiv).addClass('d-none').removeClass('alert-success alert-danger');
                }

                // Validate form
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    // Scroll to first invalid field
                    var firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        firstInvalid.focus();
                    }
                    return;
                }

                // Check if passwords match
                var newPassword = $('#newPassword').val();
                var confirmPassword = $('#confirmPassword').val();
                if (newPassword !== confirmPassword) {
                    if (messageDiv) {
                        $(messageDiv)
                            .removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .html('<div class="d-flex align-items-start">' +
                                '<i class="fa-solid fa-exclamation-circle me-2 mt-1"></i>' +
                                '<div><strong>{{ __("messages.Error") }}!</strong><br>{{ __("messages.Password confirmation does not match") }}</div>' +
                                '</div>');
                        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                    $('#confirmPassword').addClass('is-invalid');
                    return;
                }

                // Prepare form data
                var formData = {
                    current_password: $('#currentPassword').val(),
                    password: newPassword,
                    password_confirmation: confirmPassword,
                    _token: '{{ csrf_token() }}'
                };

                // Disable submit button
                submitBtn.prop('disabled', true).html('{{ __("messages.Sending") }}...');

                // Submit via AJAX
                $.ajax({
                    url: '/api/web/change-password',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        // Show success message
                        if (messageDiv) {
                            $(messageDiv)
                                .removeClass('d-none alert-danger')
                                .addClass('alert-success')
                                .html('<div class="d-flex align-items-start">' +
                                    '<i class="fa-solid fa-check-circle me-2 mt-1"></i>' +
                                    '<div><strong>{{ __("messages.Success") }}!</strong><br>' + (data.message || '{{ __("messages.Password changed successfully") }}') + '</div>' +
                                    '</div>');
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }

                        // Reset form
                        form.reset();
                        form.classList.remove('was-validated');
                        $(form).find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');

                        // Close modal after 2 seconds
                        setTimeout(function() {
                            $('#editPassword').modal('hide');
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        var errorMessage = '{{ __("messages.An error occurred. Please try again.") }}';

                        // Try to get error message from response
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = '<ul class="mb-0 ps-3">';
                            $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                if (Array.isArray(errorArray)) {
                                    $.each(errorArray, function(index, error) {
                                        errors += '<li>' + error + '</li>';
                                    });
                                } else {
                                    errors += '<li>' + errorArray + '</li>';
                                }
                            });
                            errors += '</ul>';
                            errorMessage = errors;
                        }

                        // Show error message
                        if (messageDiv) {
                            $(messageDiv)
                                .removeClass('d-none alert-success')
                                .addClass('alert-danger')
                                .html('<div class="d-flex align-items-start">' +
                                    '<i class="fa-solid fa-exclamation-circle me-2 mt-1"></i>' +
                                    '<div><strong>{{ __("messages.Error") }}!</strong><br>' + errorMessage + '</div>' +
                                    '</div>');
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }

                        // Highlight invalid fields
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                var field = $('[name="' + key + '"]');
                                if (field.length) {
                                    field.addClass('is-invalid');
                                    // Remove invalid class on input
                                    field.on('input change', function() {
                                        $(this).removeClass('is-invalid');
                                    });
                                }
                            });
                        }
                    },
                    complete: function() {
                        // Re-enable submit button
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            // Reset form when password modal is hidden
            $('#editPassword').on('hidden.bs.modal', function() {
                var form = document.getElementById('changePasswordForm');
                if (form) {
                    form.reset();
                    form.classList.remove('was-validated');
                    $(form).find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                }
                var messageDiv = document.getElementById('changePasswordMessage');
                if (messageDiv) {
                    $(messageDiv).addClass('d-none').removeClass('alert-success alert-danger');
                }
            });

        })();

        /**
         * Handle cancel order button click
         */
        $(document).on('click', '.cancel-order-btn', function(e) {
            e.preventDefault();
            var orderId = $(this).data('order-id');
            var $btn = $(this);
            var $orderBox = $btn.closest('.order-box');

            // Show confirmation dialog
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("messages.Are you sure?") }}',
                    text: '{{ __("messages.Are you sure you want to cancel this order?") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __("messages.Yes, cancel it") }}',
                    cancelButtonText: '{{ __("messages.No, keep it") }}'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        cancelOrder(orderId, $orderBox);
                    }
                });
            } else {
                if (confirm('{{ __("messages.Are you sure you want to cancel this order?") }}')) {
                    cancelOrder(orderId, $orderBox);
                }
            }
        });

        /**
         * Cancel order via AJAX
         */
        function cancelOrder(orderId, $orderBox) {
            var $btn = $orderBox.find('.cancel-order-btn');
            var originalBtnText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i>{{ __("messages.Processing") }}...');

            $.ajax({
                url: '/api/web/order/update-status/' + orderId,
                type: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    order_status_id: 5 // 5 = Canceled
                },
                success: function(response) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: '{{ __("messages.Success") }}',
                            text: response.message || '{{ __("messages.Order canceled successfully") }}',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        alert(response.message || '{{ __("messages.Order canceled successfully") }}');
                    }

                    // Reload page to show updated status
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    console.error('Error canceling order:', error);
                    var errorMsg = '{{ __("messages.Error canceling order") }}';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("messages.Error") }}',
                            text: errorMsg
                        });
                    } else {
                        alert(errorMsg);
                    }

                    $btn.prop('disabled', false).html(originalBtnText);
                }
            });
        }
    </script>
@endpush
