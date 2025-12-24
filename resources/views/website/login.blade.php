@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.login'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.login')])

    <login ></login>

@endsection
