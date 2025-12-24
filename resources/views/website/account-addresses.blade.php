@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Addresses'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')

@include('website.layouts.breadcrump', ['currentPage' => __('messages.Addresses')])
<main class="main-content">
  <section class="py-5 my-account-section">
      <div class="container px-3">
        <div class="row g-lg-4">
         @include('website.layouts.profile-sidebar', ['active'=>'Addresses'])
          <div class="col-12 col-lg-9">

            <account-addresses></account-addresses>

          </div>
        </div><!--end row-->
      </div>
    </section>
</main>

@endsection
