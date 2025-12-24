@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.profile'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')

@include('website.layouts.breadcrump', ['currentPage' => __('messages.profile')])
<main class="main-content">
  <section class="py-5 my-account-section">
      <div class="container px-3">
        <div class="row g-lg-4">
         @include('website.layouts.profile-sidebar', ['active'=>'profile'])
          <div class="col-12 col-lg-9">

            <profile :user="{{ auth('user')->user() }}"></profile>

          </div>
        </div><!--end row-->
      </div>
    </section>
</main>

@endsection
