<div class="order-contain" id="orders-container">
    @if(isset($orders) && $orders->count() > 0)
        @foreach($orders as $order)
            @php
                // Safely get status translation
                $statusName = '';
                $statusId = $order->order_status_id;

                if ($order->orderStatus) {
                    // Try to get translation using current_translation accessor
                    try {
                        $statusTranslation = $order->orderStatus->current_translation;
                        if ($statusTranslation && isset($statusTranslation->title)) {
                            $statusName = $statusTranslation->title;
                        } else {
                            // Fallback to translation relationship
                            $statusTranslation = $order->orderStatus->translation;
                            if ($statusTranslation && isset($statusTranslation->title)) {
                                $statusName = $statusTranslation->title;
                            } else {
                                // Fallback to first translation
                                $firstTranslation = $order->orderStatus->translations->first();
                                if ($firstTranslation && isset($firstTranslation->title)) {
                                    $statusName = $firstTranslation->title;
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        // If all fails, use fallback translations based on status ID
                        $statusName = '';
                    }
                }

                // Fallback translations if status name is still empty
                if (empty($statusName)) {
                    switch ($statusId) {
                        case 1:
                            $statusName = __('messages.New Order');
                            break;
                        case 2:
                            $statusName = __('messages.Preparing Order');
                            break;
                        case 3:
                            $statusName = __('messages.On The Way');
                            break;
                        case 4:
                            $statusName = __('messages.delivered');
                            break;
                        case 5:
                            $statusName = __('messages.canceled');
                            break;
                        default:
                            $statusName = __('messages.Order Status');
                            break;
                    }
                }

                $isPending = $statusId == 1; // 1 = New Order (Pending)

                // Determine order type (rent or buy)
                $hasRentItems = $order->orderItems->whereNotNull('start_date')->whereNotNull('count_day')->count() > 0;
                $orderType = $hasRentItems ? 'rent' : 'buy';

                // Get status badge class
                $statusBadgeClass = 'badge bg-secondary';
                if ($statusId == 1) $statusBadgeClass = 'badge bg-warning text-dark'; // Pending/New Order
                elseif ($statusId == 2) $statusBadgeClass = 'badge bg-info'; // Preparing Order
                elseif ($statusId == 3) $statusBadgeClass = 'badge bg-primary'; // On The Way
                elseif ($statusId == 4) $statusBadgeClass = 'badge bg-success'; // Delivered
                elseif ($statusId == 5) $statusBadgeClass = 'badge bg-danger'; // Canceled
                else $statusBadgeClass = 'badge bg-secondary'; // Other statuses
            @endphp

            <div class="order-box dashboard-bg-box order-box-clickable" data-order-id="{{ $order->id }}" style="width: 100%; cursor: pointer; transition: all 0.3s ease;" data-bs-toggle="modal" data-bs-target="#orderDetailsModal">
                <div class="order-container">
                    <div class="order-icon">
                        <i data-feather="box"></i>
                    </div>

                    <div class="order-detail">
                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
                            <h4 class="mb-0">
                                {{ __('messages.Order Number') }}: <strong>{{ $order->order_number }}</strong>
                            </h4>
                            <div class="d-flex align-items-center gap-2 mx-2">
                                @if(!empty($statusName))
                                    <span class="{{ $statusBadgeClass }} px-3 py-1" style="font-size: 13px; font-weight: 600; display: inline-flex; align-items: center;">
                                        {{ $statusName }}
                                    </span>
                                @else
                                    <span class="{{ $statusBadgeClass }} px-3 py-1" style="font-size: 13px; font-weight: 600; display: inline-flex; align-items: center;">
                                        {{ __('messages.Order Status') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="order-info mb-2">
                            <p class="text-content mb-1">
                                <i class="fa-solid fa-calendar me-1"></i>
                                <strong>{{ __('messages.Order Date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
                            </p>
                            <p class="text-content mb-0">
                                <i class="fa-solid fa-money-bill me-1"></i>
                                <strong>{{ __('messages.Total') }}:</strong>
                                <span class="text-primary fw-bold">{{ $setting->translation->title ?? 'EGP' }} {{ number_format($order->total, 2) }}</span>
                            </p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small">
                                <i class="fa-solid fa-eye me-1"></i>{{ __('messages.Click to view details') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <i class="fa-solid fa-box-open" style="font-size: 4rem; color: #ddd;"></i>
            <p class="text-muted mt-3">{{ __('messages.No orders found') }}</p>
        </div>
    @endif
</div>

{{-- Pagination --}}
@if($orders->hasPages())
    <nav class="custome-pagination mt-4">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if($orders->onFirstPage())
                @if (app()->getLocale() == 'ar')
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0)" tabindex="-1">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0)" tabindex="-1">
                            <i class="fa-solid fa-angles-left"></i>
                        </a>
                    </li>
                @endif
            @else
                @if (app()->getLocale() == 'ar')
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->previousPageUrl() }}">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $orders->previousPageUrl() }}">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>
                @endif
            @endif

            {{-- Pagination Elements --}}
            @php
                $currentPage = $orders->currentPage();
                $lastPage = $orders->lastPage();
                $range = 2; // Number of pages to show before and after current page
                $start = max(1, $currentPage - $range);
                $end = min($lastPage, $currentPage + $range);
            @endphp

            @for($page = $start; $page <= $end; $page++)
                <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $orders->url($page) }}">{{ $page }}</a>
                </li>
            @endfor

            {{-- Next Page Link --}}
            @if($orders->hasMorePages())
                @if (app()->getLocale() == 'ar')
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->nextPageUrl() }}">
                            <i class="fa-solid fa-angles-left"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->nextPageUrl() }}">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>
                @endif
            @else
                @if (app()->getLocale() == 'ar')
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0)">
                            <i class="fa-solid fa-angles-left"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0)">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </nav>
@endif
