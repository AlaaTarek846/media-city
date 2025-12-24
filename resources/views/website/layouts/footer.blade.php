
   <!--footer widgets-->
   <section class="footer-widgets py-5 border-top">
      <div class="container px-3">
        <div class="row g-4">
           <div class="col-12 col-lg-4">
               <div class="footer-widget-1">
                  <div class="">
                    <img src="assets/images/gallery/logo.png" width="130" alt="">
                  </div>
                  <div>
                    <address>
                      <strong>@lang('messages.Address')</strong>
                      {{ $contactUs->current_translation?->title }}
                    </address>
                  </div>
                  <p><a href="/contact" target="_blank" class="btn btn-sm btn-outline-dark px-4">@lang('messages.Get Direction')<i class="bi bi-arrow-up-right ms-2"></i></a></p>
                  <p><span><i class="bi bi-envelope me-2"></i></span>{{ $contactUs->email }}</p>
                  <p><span><i class="bi bi-telephone me-2"></i></span>{{ $contactUs->phone }}</p>
                  <p><span><i class="bi bi-globe me-2"></i></span>{{ request()->getHost() }}</p>
                  <div class="social-link d-flex align-items-center gap-2">
                    @if ($joinUs->facebook)
                    <a href="{{$joinUs->facebook}}" target="_blank" class="btn btn-outline-dark"><i class="bi bi-facebook"></i></a>
                     @endif
                    @if ($joinUs->twitter)
                    <a href="{{$joinUs->twitter}}" target="_blank" class="btn btn-outline-dark"><i class="bi bi-twitter-x"></i></a>
                    @endif
                    @if ($joinUs->instagram)
                    <a href="{{$joinUs->instagram}}" target="_blank" class="btn btn-outline-dark"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if ($joinUs->youtube)
                    <a href="{{$joinUs->youtube}}" target="_blank" class="btn btn-outline-dark"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if ($joinUs->linkedin)
                    <a href="{{$joinUs->linkedin}}" target="_blank" class="btn btn-outline-dark"><i class="bi bi-linkedin"></i></a>
                    @endif
                  </div>
               </div>
           </div>
           <div class="col-12 col-lg-3">
              <div class="d-flex align-items-start justify-content-between gap-4">
                <div class="">
                  <h5 class="mb-3">@lang('messages.Top Categories')</h5>
                  <ul class="list-unstyled d-flex flex-column gap-2">
                      @foreach($topCategories as $category)
                      <li><a href="{{ 'shop?category_id='.$category->id }}" class="footer-link">{{ $category->current_translation?->title }}</a></li>
                      @endforeach
                  </ul>
                 </div>
                  <div class="footer-widget-3">
                    <h5 class="mb-3">@lang('messages.Account')</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                       <li><a href="{{ auth('user')->user() ? '/account-orders' : '/login'}}" class="footer-link">@lang('messages.Order tracking')</a></li>
                       <li><a href="{{ auth('user')->user() ? '/account-wishlist' : '/login'}}" class="footer-link">@lang('messages.Wishlist')</a></li>
                       <li><a href="{{ auth('user')->user() ? '/profile' : '/login'}}" class="footer-link">@lang('messages.Your account')</a></li>
                       <li><a href="{{ auth('user')->user() ? '/account-addresses' : '/login'}}" class="footer-link">@lang('messages.Delivery info')</a></li>
                    </ul>
                  </div>
              </div>
            </div>
            <div class="col-12 col-lg-4 offset-lg-1">
              <div class="footer-widget-4">
                <h5 class="mb-3">@lang('messages.Newsletter')</h5>
                <p class="news-letter-caption">@lang('messages.Subscribe to our newsletter and enjoy 10% off your first order')</p>
				 <form method="post" action="/newsletter">
                 @csrf
					<div class="input-group input-group-lg mt-3">
                        <input type="text" class="form-control border-dark" name="name" placeholder="{{__('messages.Enter your Name')}}" required>
					  <input type="email" class="form-control border-dark" name="email" placeholder="@lang('messages.Enter your email')" required>
					  <button class="btn btn-dark" type="submit"><i class="bi bi-arrow-up-right"></i></button>
					</div>
				 </form>
              </div>
            </div>
        </div><!--end row-->
    </div>
  </section>
  <!--end footer widgets-->


  <!--start footer strip-->
  <footer class="footer-strip py-4 border-top">
      <div class="container px-3">
        <div class="row g-4">
          <div class="col-12 col-lg-auto">
            <p class="mb-0 font-12">&copy; {{now()->year}} All Rights Reserved | Made with <i class="fa fa-heart-o"></i> by <a target="_blank" href="https://innovations-eg.com/" >Innovation Agency.</a></p>
          </div>
          {{-- <div class="col-12 col-lg-auto">
            <div class="d-flex align-items-center gap-3">
              <a href="javascript:;" class="font-12 text-secondary">Privacy</a>
              <a href="javascript:;" class="font-12 text-secondary">Affiliates</a>
              <a href="javascript:;" class="font-12 text-secondary">Terms of use</a>
            </div>
         </div> --}}
       </div><!--end row-->
      </div>
  </footer>
 <!--end footer strip-->


 <!--back to top button-->
    <a href="javaScript:;" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
 <!--end back to top button-->


  <!--start off canvas cart-->
  <div class="offcanvas offcanvas-end offcanvas-cart p-2" tabindex="-1" id="offcanvasCart" >
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title">@lang('messages.Shopping cart')</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
       <div class="cart-product-list d-flex flex-column">
       @foreach ( $carts as $item )
        <div class="cart-product-list-item d-flex align-items-center gap-3">
            <div class="flex-shrink-0">
              <a href="javascript:;">
                <img src="{{ $item->product?->image }}" width="100" class="cart-product-img rounded-3" alt="">
             </a>
            </div>
             <div class="cart-product-info flex-grow-1">
               <p class="mb-1 cart-product-name">{{ $item->product?->current_translation?->title }} {{ $item->productVariant?->attribute_values ? "( " .$item->productVariant?->attribute_values ." )" : '' }} </p>
               <h5 class="mb-0 cart-product-price">{{ $item->price }} {{ $setting?->current_translation?->title }}</h5>
               <div class="d-flex align-items-center justify-content-between mt-2">
                 <p class="mb-0 font-14 cart-product-qty">@lang('messages.Qty') {{ $item->quantity }}</p>
                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline cart-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="cart-product-btn-delete btn btn-outline-dark border btn-sm rounded-3 swal-cart-delete-btn">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
             </div>
          </div>
          <hr class="border-bottom border-1 border">
       @endforeach


       </div>
    </div>
    <div class="cart-product-checout p-3 border-top">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <p class="mb-0">@lang('messages.Subtotal')</p>
        <h5 class="mb-0"> {{ $carts ? $carts->sum(fn($item) => $item->price * $item->quantity) : 0 }} {{ $setting?->current_translation?->title }}</h5>
      </div>
       <div class="d-flex align-items-center gap-3">
           <a href="{{ auth('user')->user() ? '/shopping-cart' : '/login' }}" class="btn btn-light border px-4 py-2 flex-fill">@lang('messages.View Cart')</a>
           <a href="{{ auth('user')->user() ? '/checkout' : '/login' }}" class="btn btn-dark px-4 py-2 border border-dark flex-fill">@lang('messages.Checkout')</a>
       </div>
    </div>
  </div>
  <!--end off canvas cart-->


@include('website.components.search-shipment-code')


    <!-- start search sodal -->
    {{-- <div class="modal fade search-modal" id="searchModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content p-lg-2 p-0">
          <div class="p-4">
            <div class="d-flex align-items-center justify-content-between">
              <h1 class="modal-title fs-5 mb-0">Search</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
             <form class="position-relative mt-3">
                <input type="text" class="form-control form-control-lg form-control-search pe-5 border-2" placeholder="Search the products">
                <span class="position-absolute top-50 end-0 translate-middle-y"><i class="bi bi-search fs-6 me-3"></i></span>
             </form>
             <div class="search-keywords mt-4">
              <h5 class="mb-3">Top searches keywords</h5>
              <div class="d-flex align-items-center flex-nowrap gap-2 overflow-x-auto">
                <button type="button" class="btn border border-2 px-4 rounded-5 flex-shrink-0">shirts</button>
                <button type="button" class="btn border border-2 px-4 rounded-5 flex-shrink-0">jeans</button>
                <button type="button" class="btn border border-2 px-4 rounded-5 flex-shrink-0">shoes</button>
                <button type="button" class="btn border border-2 px-4 rounded-5 flex-shrink-0">women fashion</button>
                <button type="button" class="btn border border-2 px-4 rounded-5 flex-shrink-0">men shirts</button>
                <button type="button" class="btn border border-2 px-4 rounded-5 flex-shrink-0">laptops</button>
                <button type="button" class="btn border border-2 px-4 rounded-5 flex-shrink-0">sneakers</button>
                <button type="button" class="btn border border-2 px-4 rounded-5 flex-shrink-0">dressess</button>
              </div>
            </div>
           </div>
          <div class="modal-body p-4">
            <div class="recently-viewed">
              <h5 class="mb-3">Recently viewed products</h5>
              <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 border p-3 rounded-3">
                   <a href="javascript:;">
                       <img src="assets/images/gallery/categories/01.png" class="rounded-3" width="100" alt="">
                   </a>
                    <div class="flex-grow-1">
                      <h4 class="mb-1">$149</h4>
                       <p class="mb-0">Light Gray Formal Shirt</p>
                       <div class="ratings fs-6 text-warning">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                    </div>
                    <div class="d-grid gap-2">
                       <a href="javascript:;" class="btn btn-dark border border-dark px-4">Buy Now</a>
                       <a href="javascript:;" class="btn btn-light border px-4">Go To shop</a>
                    </div>
                 </div>
                 <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 border p-3 rounded-3">
                  <a href="javascript:;">
                      <img src="assets/images/gallery/categories/02.png" class="rounded-3" width="100" alt="">
                  </a>
                   <div class="flex-grow-1">
                     <h4 class="mb-1">$479</h4>
                      <p class="mb-0">Light Gray Formal Shirt</p>
                      <div class="ratings fs-6 text-warning">
                       <i class="bi bi-star-fill"></i>
                       <i class="bi bi-star-fill"></i>
                       <i class="bi bi-star-fill"></i>
                       <i class="bi bi-star-fill"></i>
                       <i class="bi bi-star-fill"></i>
                     </div>
                   </div>
                   <div class="d-grid gap-2">
                      <a href="javascript:;" class="btn btn-dark border border-dark px-4">Buy Now</a>
                      <a href="javascript:;" class="btn btn-light border px-4">Go To shop</a>
                   </div>
                </div>
                <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 border p-3 rounded-3">
                  <a href="javascript:;">
                      <img src="assets/images/gallery/categories/03.png" class="rounded-3" width="100" alt="">
                  </a>
                   <div class="flex-grow-1">
                     <h4 class="mb-1">$359</h4>
                      <p class="mb-0">Light Gray Formal Shirt</p>
                      <div class="ratings fs-6 text-warning">
                       <i class="bi bi-star-fill"></i>
                       <i class="bi bi-star-fill"></i>
                       <i class="bi bi-star-fill"></i>
                       <i class="bi bi-star-fill"></i>
                       <i class="bi bi-star-fill"></i>
                     </div>
                   </div>
                   <div class="d-grid gap-2">
                      <a href="javascript:;" class="btn btn-dark border border-dark px-4">Buy Now</a>
                      <a href="javascript:;" class="btn btn-light border px-4">Go To shop</a>
                   </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
    <!-- end search modal -->

<script src="/website/js/sweetalert2.min.js"></script>

@if(session()->has("success"))
    <script>
        window.Swal.fire({
            icon: 'success',
            title: '{{session()->get("success")}}',
            showConfirmButton: false,
            timer: 4000
        });
    </script>
@endif
@if (session()->has("error"))
    <script>
        window.Swal.fire({
            icon: 'error',
            title: '{{session()->get("error")}}',
            showConfirmButton: false,
            timer: 4000
        });
    </script>

@endif

 @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.swal-cart-delete-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let form = btn.closest('form');
                window.Swal.fire({
                    title: "@lang('messages.Are you sure?')",
                    text: "@lang('messages.Are you sure you want to remove this item?')",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: "@lang('messages.Yes, remove it!')",
                    cancelButtonText: "@lang('messages.No, keep it')"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });

    let favorite_count = {{ $favorite_count ?? 0 }};
    window.updateFavoriteCount = function() {
        const el = document.getElementById('favorite-count');
        if (el) {
            el.textContent = favorite_count;
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        window.updateFavoriteCount();
    });
    </script>
    @endpush

@stack("scripts")

