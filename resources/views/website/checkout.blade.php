@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Checkout'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.Checkout')])

	   <!--start shop-->
    <checkout :cart="{{ $cartItems }}" :user="{{ auth('user')->user() }}" :setting="{{$setting}}"> </checkout>


@endsection