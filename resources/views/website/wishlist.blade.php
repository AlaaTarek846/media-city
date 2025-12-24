@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.wishlist'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.wishlist')])

	   <!--start shop-->
    <wishlist
        :favorites="{{ $favorites }}"
        :user="{{ auth('user')->user() }}"
        :setting="{{ $setting }}"
    ></wishlist>


@endsection