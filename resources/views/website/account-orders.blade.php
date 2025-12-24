@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.My Orders'))
@section('body')

@include('website.layouts.breadcrump', ['currentPage' => __('messages.My Orders')])
<main class="main-content">
    <section class="py-5 my-account-section">
        <div class="container px-3">
            <div class="row g-lg-4">
                @include('website.layouts.profile-sidebar', ['active'=>'order'])
                <div class="col-12 col-lg-9">

                    <div class="my-orders border rounded-3 p-3">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>@lang('messages.Order#')</th>
                                        <th>@lang('messages.Date')</th>
                                        <th>@lang('messages.Status')</th>
                                        <th>@lang('messages.Total')</th>
                                        <th>@lang('messages.theProducts')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)

                                    <tr>
                                        <td>{{$order->order_number}}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="d-flex align-items-center gap-2">
                                            @if($order->order_status_id == 1)
                                                <i class="bi bi-circle-fill text-primary font-12"></i>
                                            @elseif ($order->order_status_id == 2)
                                                <i class="bi bi-circle-fill text-success font-12"></i>
                                            @elseif ($order->order_status_id == 3)
                                                <i class="bi bi-circle-fill text-danger font-12"></i>
                                            @endif
                                            {{ $order->orderStatus?->current_translation?->title }}
                                            </span>
                                        </td>
                                        <td>{{ $order->total }} {{ $setting->current_translation?->title }}</td>
                                        <td>
                                            @foreach ($order->orderItems as $item)
                                            <div class="d-flex align-items-center gap-3" >
                                                <img src="{{ $item->product?->image }}" width="50" height="50" class="rounded-circle" alt="">
                                                <div>
                                                    <p class="mb-0 fw-semibold">{{ $item->product?->current_translation?->title }} {{$item->productVariant?->attribute_values ? '( '. $item->productVariant?->attribute_values .' ) ' : ''}}</p>
                                                    <p class="mb-0" style="direction: ltr !important; text-align: center;">@lang('messages.Qty') x {{ $item->quantity }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!--end row-->
        </div>
    </section>
</main>

@endsection
