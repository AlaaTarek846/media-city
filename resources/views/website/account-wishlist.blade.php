@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Wishlist'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')

@include('website.layouts.breadcrump', ['currentPage' => __('messages.Wishlist')])
<main class="main-content">
  <section class="py-5 my-account-section">
      <div class="container px-3">
        <div class="row g-lg-4">
         @include('website.layouts.profile-sidebar', ['active'=>'Wishlist'])
          <div class="col-12 col-lg-9">

            <account-wishlist
                :favorites="{{ $favorites }}"
                :user="{{ auth('user')->user() }}"
                :setting="{{ $setting }}"
            ></account-wishlist>

          </div>
        </div><!--end row-->
      </div>
    </section>
</main>

@endsection
