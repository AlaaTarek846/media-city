<!--start breadcrumb-->
<div class="col-12 col-lg-3">
    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" class="btn btn-dark d-lg-none btn-filter-mobile rounded-bottom-0 d-flex align-items-center gap-2 px-4"><i class="bi bi-funnel"></i><span>@lang('messages.Account')</span></button>
    <nav class="navbar navbar-expand-lg p-0">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasFilterLabel">@lang('messages.My account')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="my-account-menu w-100 border rounded-3 p-3">
                    <div class="list-group list-group-flush">
                        <a href="/account-orders" class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-0 rounded-3 {{ $active == 'order' ? 'active' : '' }}"><span><i class="bi bi-bag-check"></i></span>@lang('messages.My Orders')</a>

                        <a href="/account-wishlist" class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-0 rounded-3 {{ $active == 'Wishlist' ? 'active' : '' }}"><span><i class="bi bi-heart"></i></span>@lang('messages.Wishlist')</a>

                        <a href="/profile" class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-0 rounded-3 {{ $active == 'profile' ? 'active' : '' }}"><span><i class="bi bi-person-square"></i></span>@lang('messages.My Profile')</a>

                        <a href="/account-addresses" class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-0 rounded-3 {{ $active == 'Addresses' ? 'active' : '' }}"><span><i class="bi bi-geo-alt"></i></span>@lang('messages.Addresses')</a>

                        <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-0 rounded-3">

                            <form id="logout-form" action="{{ route('web.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <span><i class="bi bi-box-arrow-left"></i></span>@lang("messages.Logout")
                        </a>
                    </div>
                </div>
                <!--end filters-->
            </div>
        </div>
    </nav>
</div>
<!--end breadcrumb-->
