@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.register_new_account'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.register_new_account')])

    <register ></register>

@endsection

