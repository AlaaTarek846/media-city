@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.contactPage'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')

@include('website.layouts.breadcrump', ['currentPage' => __('messages.Contact')])

  <main class="main-content">

    <section class="py-5">
      <div class="container px-3">
        <div class="row g-4 g-lg-5">
           <div class="col-12 col-lg-8">
              <div class="contact-map border rounded-3 p-3 overflow-x-auto">
                <iframe src="{{$contactUs->location}}" width="800" class="rounded-3" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
           </div>
           <div class="col-12 col-lg-4">
            <div class="contact-details">
              <h4 class="mb-4">@lang('messages.Information')</h4>
              <div class="contact-number">
                <p class="mb-1 fw-semibold">@lang('messages.Phone Numbers'):</p>
                <a href="tel:{{$contactUs->phone}}" class="mb-0">{{$contactUs->phone}}</a>
              </div>
              <div class="border-top my-3"></div>
              <div class="contact-number mt-3">
                <p class="mb-1 fw-semibold">@lang('messages.Email Address'):</p>
                <a href="mailto:{{$contactUs->email}}" class="mb-0">{{$contactUs->email}}</a>
              </div>
              <div class="border-top my-3"></div>
              <div class="contact-number mt-3">
                <p class="mb-1 fw-semibold">@lang('messages.Address'):</p>
                <p class="mb-0">{{$contactUs->current_translation?->title}}</p>
              </div>
              <div class="border-top my-3"></div>
              <div class="contact-number mt-3">
                <p class="mb-1 fw-semibold">@lang('messages.Open Time'):</p>
                <p class="mb-0">{{$contactUs->current_translation?->description}}</p>
              </div>
            </div>
           </div>
        </div><!--end row-->

        <contact-form></contact-form>


      </div>
    </section>

  </main>
@endsection
