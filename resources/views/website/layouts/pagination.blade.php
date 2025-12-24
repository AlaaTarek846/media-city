<div class="row">
    <div class="col-sm-12 my-5 container">
        <div class="default-pagination text-center">
            <ul style="max-width: 550px">
                <!-- Previous Button -->
                @if ($model->onFirstPage())
                    <li class="disabled"><a href="javascript::void()"><i class="fa fa-angle-left"></i>@lang('messages.Previous')</a></li>
                @else
                    <li><a href="{{ $model->previousPageUrl() }}"><i class="fa fa-angle-left"></i>@lang('messages.Previous')</a></li>
                @endif

                <!-- Page Numbers -->
                @php
                    $currentPage = $model->currentPage();
                    $lastPage = $model->lastPage();
                    $range = 5; // Number of pages to show before and after current page
                    $start = max(1, $currentPage - $range);
                    $end = min($lastPage, $currentPage + $range);
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    <li class="{{ $page == $currentPage ? 'active' : '' }}">
                        <a href="{{ $model->url($page) }}">{{ $page }}</a>
                    </li>
                @endfor

                <!-- Next Button -->
                @if ($model->hasMorePages())
                    <li><a href="{{ $model->nextPageUrl() }}">@lang('messages.Next') <i class="fa fa-angle-right"></i></a></li>
                @else
                    <li class="disabled"><a href="javascript::void()">@lang('messages.Next') <i class="fa fa-angle-right"></i></a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
