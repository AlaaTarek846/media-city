
 <!--start header-->
  <header class="top-header py-2">
    <div class="top-strip d-flex align-items-center gap-4 container px-3">
      <div class="strip-menu-left d-none d-lg-flex">
        <ul class="nav align-items-center gap-2">
          <li class="nav-item">
          @if(auth('user')->user())
            <a class="nav-link py-1" href="/profile">@lang('messages.Shipping')</a>
            @else
            <a class="nav-link py-1" href="/login">@lang('messages.Shipping')</a>
         @endif
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link py-1" href="javascript:;">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link py-1" href="javascript:;">Returns Policy</a>
          </li> --}}
          <li class="nav-item">
            @if(auth('user')->user())
                <a class="nav-link py-1" href="/profile">@lang('messages.Track Order')</a>
            @else
                <a class="nav-link py-1" href="/login">@lang('messages.Track Order')</a>
            @endif
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link py-1" href="javascript:;" data-bs-toggle="modal" data-bs-target="#searchShipmentCode">@lang('messages.Search by shipment code')</a>
          </li> --}}
        </ul>
      </div>
      <div class="strip-social-links ms-lg-auto flex-lg-grow-0 flex-grow-1">
        <ul class="nav align-items-center gap-2">
        @if ($joinUs->facebook)
          <li class="nav-item">
            <a class="nav-link" href="{{$joinUs->facebook}}" target="_blank"><i class="bi bi-facebook"></i></a>
          </li>
           @endif
          @if ($joinUs->twitter)
          <li class="nav-item">
            <a class="nav-link" href="{{$joinUs->twitter}}" target="_blank"><i class="bi bi-twitter-x"></i></a>
          </li>
          @endif
        @if ($joinUs->linkedin)
          <li class="nav-item">
            <a class="nav-link" href="{{$joinUs->linkedin}}" target="_blank"><i class="bi bi-linkedin"></i></a>
          </li>
           @endif
          @if ($joinUs->youtube)
          <li class="nav-item">
            <a class="nav-link" href="{{$joinUs->youtube}}" target="_blank"><i class="bi bi-youtube"></i></a>
          </li>
          @endif
        </ul>
      </div>
      <div class="dropdown language">
        <a class="btn btn-sm btn-language btn-outline-light border-0 d-flex align-items-center gap-2 px-2 dropdown-toggle dropdown-toggle-nocaret"
          href="javascript:;" data-bs-toggle="dropdown">
          <span>{{app()->getLocale() == 'ar' ? __('messages.Arabic') :__('messages.English')}}</span><span><i class="bi bi-chevron-down"></i></span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="/change-language/{{app()->getLocale() == 'ar' ? 'en' : 'ar'}}">{{app()->getLocale() == 'en' ? __('messages.Arabic') :__('messages.English')}}</a></li>
        </ul>
      </div>
    </div>
  </header>
  <!--end header-->

<!--start nav-->
  <nav class="navbar navbar-expand-xl border-bottom py-3">
    <div class="container px-3">
      <a class="navbar-brand d-none d-xl-flex" href="/home">
        <img src="/website/images/gallery/logo.png" class="logo-img" alt="" style="width: 75px !important; height: 60px !important;">
      </a>
      <button type="button" class="d-xl-none btn-menu-close" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasNavbar">
        <i class="bi bi-list"></i>
      </button>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
        <div class="offcanvas-header">
          <img src="/website/images/gallery/logo.png" class="logo-img2" alt="">
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="nav-search p-3 pt-0 border-bottom d-flex d-xl-none">
          <form class="position-relative w-100">
            <input type="text" class="form-control nav-search-control ps-5 border-0 py-2" placeholder="what are you looking for ?">
            <span class="position-absolute top-50 start-0 translate-middle-y"><i class="bi bi-search fs-6 ms-3"></i></span>
         </form>
        </div>
        <div class="offcanvas-body p-0">
          <ul class="navbar-nav mx-auto gap-0 gap-xl-2">
            <li class="nav-item">
              <a class="nav-link" href="/">
                <span class="parent-menu-name">@lang("messages.homePage")</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/shop">
                <span class="parent-menu-name">@lang('messages.Shop')</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/blog">
                <span class="parent-menu-name">@lang('messages.Blog')</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/about-us">
                <span class="parent-menu-name">@lang('messages.About Us')</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contact">
                <span class="parent-menu-name">@lang('messages.Contact')</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="right-links nav gap-2 d-flex">
        {{-- <a class="nav-link" href="javascript:;" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="bi bi-search"></i></a> --}}
        <a class="nav-link" href="{{ auth('user')->user() ? '/profile' : '/login' }}"><i class="bi bi-person-circle"></i></a>
        <a class="nav-link position-relative" href="{{ auth('user')->user() ? '/wishlist' : '/login' }}">
            <i class="bi bi-heart"></i>
            <span class="notify-badge" id="favorite-count"></span>
        </a>
        <a class="nav-link position-relative" data-bs-toggle="offcanvas" href="#offcanvasCart"><i class="bi bi-basket2"></i><span class="notify-badge">{{ $carts ? count($carts) : 0 }}</span></a>
      </div>
    </div>
  </nav>
  <!--end nav-->


