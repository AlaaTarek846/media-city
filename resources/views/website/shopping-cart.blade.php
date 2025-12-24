@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Shopping Cart'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.Shopping Cart')])

	   <!--start shop-->
    <shopping-cart :cart="{{ $cartItems }}" :user="{{ auth('user')->user() }}" :setting="{{$setting}}"> </shopping-cart>


@endsection