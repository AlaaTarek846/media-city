<!-- Header Start -->
<header class="header-2">
    <div class="header-top">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 d-xxl-block d-none">
                    <div class="top-left-header">
                        <i class="iconly-Location icli text-white"></i>
                        <span class="text-white">1418 Riverwood Drive, CA 96052, US</span>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-9 d-lg-block d-none">
                    <div class="header-offer">
                        <div class="notification-slider">
                            <div>
                                <div class="timer-notification">
                                    <h6><strong class="me-1">Welcome to Fastkart!</strong>Wrap new offers/gift
                                        every signle day on Weekends.<strong class="ms-1">New Coupon Code: Fast024
                                        </strong>
                                    </h6>
                                </div>
                            </div>

                            <div>
                                <div class="timer-notification">
                                    <h6>Something you love is now on sale!
                                        <a href="{{route('shop')}}" class="text-white">Buy Now
                                            !</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <ul class="about-list right-nav-about">
                        <li class="right-nav-list">
                            <div class="dropdown theme-form-select">
                                <button class="btn dropdown-toggle" type="button" id="select-language"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ app()->getLocale() == 'ar' ? asset('website/images/country/Arabia.png') : asset('website/images/country/united-states.png')}}"
                                         class="img-fluid blur-up lazyload" alt="">
                                    <span>{{ app()->getLocale() == 'en' ? __('messages.English') : __('messages.Arabic') }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="select-language">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('change.language',app()->getLocale() == 'ar'? 'en' : 'ar') }}" id="english">
                                            <img src="{{ app()->getLocale() == 'en' ? asset('website/images/country/Arabia.png') : asset('website/images/country/united-states.png')}}"
                                                 class="img-fluid blur-up lazyload" alt="">
                                            <span>{{ app()->getLocale() == 'ar' ? __('messages.English') : __('messages.Arabic') }} </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="top-nav top-header sticky-header sticky-header-3">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="navbar-top">
                        <button class="navbar-toggler d-xl-none d-block p-0 me-3" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                <span class="navbar-toggler-icon">
                                    <i class="iconly-Category icli theme-color"></i>
                                </span>
                        </button>
                        <a href="{{route('web.home')}}" class="web-logo nav-logo">
                            <img src="{{asset('website/images/logo/3.png')}}" class="img-fluid blur-up lazyload" alt="">
                        </a>

                        <div class="search-full">
                            <div class="input-group">
                                    <span class="input-group-text">
                                        <i data-feather="search" class="font-light"></i>
                                    </span>
                                <input type="text" class="form-control search-type" placeholder="Search here..">
                                <span class="input-group-text close-search">
                                        <i data-feather="x" class="font-light"></i>
                                    </span>
                            </div>
                        </div>

                        <div class="middle-box">
                            <div class="center-box">
                                <div class="searchbar-box order-xl-1 d-none d-xl-block">
                                    <input type="search" class="form-control" id="exampleFormControlInput1"
                                           placeholder="search for product, delivered to your door...">
                                    <button class="btn search-button">
                                        <i class="iconly-Search icli"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="rightside-box">
                            <div class="search-full">
                                <div class="input-group">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-search font-light">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </span>
                                    <input type="text" class="form-control search-type" placeholder="Search here..">
                                    <span class="input-group-text close-search">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-x font-light">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </span>
                                </div>
                            </div>
                            <ul class="right-side-menu">
                                <li class="right-side">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <div class="search-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-search">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side">
                                    <a href="{{route('contact')}}" class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-phone-call">
                                                <path
                                                    d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="delivery-detail">
                                            <h6>24/7 Delivery</h6>
                                            <h5>+91 888 104 2340</h5>
                                        </div>
                                    </a>
                                </li>
                                <li class="right-side">
                                    <a href="{{route('wishlist')}}" class="btn p-0 position-relative header-wishlist">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-heart">
                                            <path
                                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                            </path>
                                        </svg>
                                    </a>
                                </li>
                                <li class="right-side">
                                    <div class="onhover-dropdown header-badge">
                                        <button type="button" class="btn p-0 position-relative header-wishlist">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-shopping-cart">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path
                                                    d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                                </path>
                                            </svg>
                                            <span class="position-absolute top-0 start-100 translate-middle badge">2
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                        </button>

                                        <div class="onhover-div">
                                            <ul class="cart-list">
                                                <li class="product-box-contain">
                                                    <div class="drop-cart">
                                                        <a href="{{route('productDetail',1)}}" class="drop-image">
                                                            <img src="{{asset('website/images/veg-3/home/18.jpg')}}"
                                                                 class="blur-up lazyloaded" alt="">
                                                        </a>

                                                        <div class="drop-contain">
                                                            <a href="{{route('productDetail',1)}}">
                                                                <h5>Fantasy Crunchy Choco Chip Cookies</h5>
                                                            </a>
                                                            <h6><span>1 x</span> EGP80.58</h6>
                                                            <button class="close-button close_button">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li class="product-box-contain">
                                                    <div class="drop-cart">
                                                        <a href="{{route('productDetail',1)}}" class="drop-image">
                                                            <img src="{{asset('website/images/veg-3/home/19.jpg')}}"
                                                                 class="blur-up lazyloaded" alt="">
                                                        </a>

                                                        <div class="drop-contain">
                                                            <a href="{{route('productDetail',1)}}">
                                                                <h5>Peanut Butter Bite Premium Butter Cookies 600 g
                                                                </h5>
                                                            </a>
                                                            <h6><span>1 x</span> EGP25.68</h6>
                                                            <button class="close-button close_button">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div class="price-box">
                                                <h5>Total :</h5>
                                                <h4 class="theme-color fw-bold">EGP106.58</h4>
                                            </div>

                                            <div class="button-group">
                                                <a href="cart.html" class="btn btn-sm cart-button">View Cart</a>
                                                <a href="checkout.html" class="btn btn-sm cart-button theme-bg-color
                                                    text-white">Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-user">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                        <div class="delivery-detail">
                                            <h6>Hello,</h6>
                                            <h5>My Account</h5>
                                        </div>
                                    </div>

                                    <div class="onhover-div onhover-div-login">
                                        <ul class="user-box-name">
                                            <li class="product-box-contain">
                                                <i></i>
                                                <a href="{{url('login')}}">Log In</a>
                                            </li>

                                            <li class="product-box-contain">
                                                <a href="{{url('register')}}">Register</a>
                                            </li>

                                            <li class="product-box-contain">
                                                <a href="{{url('forgot')}}">Forgot Password</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="main-nav">
                    <div class="header-nav-left">
                        <button class="dropdown-category dropdown-category-2">
                            <i class="iconly-Category icli"></i>
                            <span>New arrival</span>
                        </button>

                        <div class="category-dropdown">
                            <div class="category-title">
                                <h5>New arrival</h5>
                                <button type="button" class="btn p-0 close-button text-content">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <ul class="category-list">
                                <li class="onhover-category-list">
                                    <a href="{{route('shop')}}" class="category-name">
                                        <img src="{{asset('website/svg/1/Cinema-camera.png')}}" alt="">
                                        <h6>Cameras</h6>
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>

                                    <div class="onhover-category-box">
                                        <div class="list-1">
                                            <div class="category-title-box">
                                                <h5>Cameras</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="{{route('shop')}}">Cinema Camera</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">DCLR & Mirrorless</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Action Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('blog')}}">Blogs</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Beans & Okra</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Cabbage & Cauliflower</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Specialty</a>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="list-2">
                                            <div class="category-title-box">
                                                <h5>ALEXA 35</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    ALEXA 35 is the smallest fully
                                                    featured ARRI production camera ever, packing the feature
                                                    s and processing power of a larger ALEXA into a Mini-sized body
                                                    that can record native 4K at up to 120 fps. Fast and easy
                                                    operation
                                                    is assured through numerous usability improvements and a simple
                                                    menu structure that will be intuitively
                                                    familiar to crews. ALEXA 35 is the best A-camera, B-camera, and
                                                    action camera on the market, all rolled into one.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <li class="onhover-category-list">
                                    <a href="{{route('shop')}}" class="category-name">
                                        <img src="{{asset('website/svg/1/lenses.png')}}" alt="">
                                        <h6>Lenses</h6>
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>

                                    <div class="onhover-category-box w-100">
                                        <div class="list-1">
                                            <div class="category-title-box">
                                                <h5>Energy & Soft Drinks</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="{{route('shop')}}">Soda & Cocktail Mix</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Soda & Cocktail Mix</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Sports & Energy Drinks</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Non Alcoholic Drinks</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Packaged Water</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Spring Water</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Flavoured Water</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="onhover-category-list">
                                    <a href="{{route('shop')}}" class="category-name">
                                        <img src="{{asset('website/svg/1/mic.png')}}" alt="">
                                        <h6>Sound</h6>
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>

                                    <div class="onhover-category-box">
                                        <div class="list-1">
                                            <div class="category-title-box">
                                                <h5>Cameras</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="{{route('shop')}}">Cinema Camera</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">DCLR & Mirrorless</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Action Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('blog')}}">Blogs</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Beans & Okra</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Cabbage & Cauliflower</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Specialty</a>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="list-2">
                                            <div class="category-title-box">
                                                <h5>ALEXA 35</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    ALEXA 35 is the smallest fully
                                                    featured ARRI production camera ever, packing the feature
                                                    s and processing power of a larger ALEXA into a Mini-sized body
                                                    that can record native 4K at up to 120 fps. Fast and easy
                                                    operation
                                                    is assured through numerous usability improvements and a simple
                                                    menu structure that will be intuitively
                                                    familiar to crews. ALEXA 35 is the best A-camera, B-camera, and
                                                    action camera on the market, all rolled into one.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <li class="onhover-category-list">
                                    <a href="{{route('shop')}}" class="category-name">
                                        <img src="{{asset('website/svg/1/tripod.png')}}" alt="">
                                        <h6>Camera Accessories</h6>
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>

                                    <div class="onhover-category-box">
                                        <div class="list-1">
                                            <div class="category-title-box">
                                                <h5>Cameras</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="{{route('shop')}}">Cinema Camera</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">DCLR & Mirrorless</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Action Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('blog')}}">Blogs</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Beans & Okra</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Cabbage & Cauliflower</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Specialty</a>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="list-2">
                                            <div class="category-title-box">
                                                <h5>ALEXA 35</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    ALEXA 35 is the smallest fully
                                                    featured ARRI production camera ever, packing the feature
                                                    s and processing power of a larger ALEXA into a Mini-sized body
                                                    that can record native 4K at up to 120 fps. Fast and easy
                                                    operation
                                                    is assured through numerous usability improvements and a simple
                                                    menu structure that will be intuitively
                                                    familiar to crews. ALEXA 35 is the best A-camera, B-camera, and
                                                    action camera on the market, all rolled into one.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <li class="onhover-category-list">
                                    <a href="{{route('shop')}}" class="category-name">
                                        <img src="{{asset('website/svg/1/illumination.png')}}" alt="">
                                        <h6>Lighting</h6>
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>

                                    <div class="onhover-category-box">
                                        <div class="list-1">
                                            <div class="category-title-box">
                                                <h5>Cameras</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="{{route('shop')}}">Cinema Camera</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">DCLR & Mirrorless</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Action Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('blog')}}">Blogs</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Beans & Okra</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Cabbage & Cauliflower</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Specialty</a>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="list-2">
                                            <div class="category-title-box">
                                                <h5>ALEXA 35</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    ALEXA 35 is the smallest fully
                                                    featured ARRI production camera ever, packing the feature
                                                    s and processing power of a larger ALEXA into a Mini-sized body
                                                    that can record native 4K at up to 120 fps. Fast and easy
                                                    operation
                                                    is assured through numerous usability improvements and a simple
                                                    menu structure that will be intuitively
                                                    familiar to crews. ALEXA 35 is the best A-camera, B-camera, and
                                                    action camera on the market, all rolled into one.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>

                                <li class="onhover-category-list">
                                    <a href="{{route('shop')}}" class="category-name">
                                        <img src="{{asset('website/svg/1/illumination.png')}}" alt="">
                                        <h6>Lighting Accessories</h6>
                                        <i class="fa-solid fa-angle-right"></i>
                                    </a>

                                    <div class="onhover-category-box">
                                        <div class="list-1">
                                            <div class="category-title-box">
                                                <h5>Cameras</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="{{route('shop')}}">Cinema Camera</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">DCLR & Mirrorless</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Action Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('blog')}}">Blogs</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Beans & Okra</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Cabbage & Cauliflower</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('shop')}}">Specialty</a>
                                                </li>
                                            </ul>
                                        </div>


                                        <div class="list-2">
                                            <div class="category-title-box">
                                                <h5>ALEXA 35</h5>
                                            </div>
                                            <ul>
                                                <li>
                                                    ALEXA 35 is the smallest fully
                                                    featured ARRI production camera ever, packing the feature
                                                    s and processing power of a larger ALEXA into a Mini-sized body
                                                    that can record native 4K at up to 120 fps. Fast and easy
                                                    operation
                                                    is assured through numerous usability improvements and a simple
                                                    menu structure that will be intuitively
                                                    familiar to crews. ALEXA 35 is the best A-camera, B-camera, and
                                                    action camera on the market, all rolled into one.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                        <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                            <div class="offcanvas-header navbar-shadow">
                                <h5>Menu</h5>
                                <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav">
                                    <!-- <li class="nav-item">
                                        <a class="nav-link ps-xl-2 ps-0" href="javascript:void(0)">Home</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="nav-link ps-xl-2 ps-0" href="{{route('renting')}}">Our Items</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ps-xl-2 ps-0" href="{{route('best-seller')}}">Best Seller </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ps-xl-2 ps-0" href="{{route('about-us')}}">About Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ps-xl-2 ps-0" href="{{route('blog')}}">Blogs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ps-xl-2 ps-0" href="{{route('contact')}}">Contact Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ps-xl-2 ps-0" href="user-dashboard.html">User
                                            Dashboard</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="right-nav">
                        <div class="nav-number">
                            <img src="{{asset('website/images/icon/music.png')}}" class="img-fluid blur-up lazyload" alt="">
                            <span>(123) 456 7890</span>
                        </div>
                        <a href="javascript:void(0)" class="btn theme-bg-color ms-3 fire-button"
                           data-bs-toggle="modal" data-bs-target="#deal-box">
                            <div class="fire">
                                <img src="{{asset('website/images/icon/hot-sale.png')}}" class="img-fluid" alt="">
                            </div>
                            <span>Hot Deals</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->

<!-- mobile fix menu start -->
<div class="mobile-menu d-md-none d-block mobile-cart">
    <ul>
        <li class="active">
            <a href="{{route('web.home')}}">
                <i class="iconly-Home icli"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="mobile-category">
            <a href="javascript:void(0)">
                <i class="iconly-Category icli js-link"></i>
                <span>Category</span>
            </a>
        </li>

        <li>
            <a href="search.html" class="search-box">
                <i class="iconly-Search icli"></i>
                <span>Search</span>
            </a>
        </li>

        <li>
            <a href="{{route('wishlist')}}" class="notifi-wishlist">
                <i class="iconly-Heart icli"></i>
                <span>My Wish</span>
            </a>
        </li>

        <li>
            <a href="cart.html">
                <i class="iconly-Bag-2 icli fly-cate"></i>
                <span>Cart</span>
            </a>
        </li>
    </ul>
</div>
<!-- mobile fix menu end -->
