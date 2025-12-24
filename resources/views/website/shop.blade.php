@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Shop'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.Shop')])

	 <!--start shop-->
     <main class="main-content">
        <!--start shop-->
        <section class="py-5 shop-page-section">
            <div class="container px-3">
                <div class="row g-lg-4">
                <div class="col-12 col-lg-3 order-2">
                    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter"
                    class="btn btn-dark d-lg-none btn-filter-mobile rounded-bottom-0 d-flex align-items-center gap-2 px-4"><i
                        class="bi bi-funnel"></i><span>@lang('messages.Filter')</span></button>
                    <nav class="navbar navbar-expand-lg p-0">
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasFilter"
                        aria-labelledby="offcanvasFilterLabel">
                        <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasFilterLabel">@lang('messages.Filter')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                        <div class="shop-filters">
                            <form method="GET" action="/shop">
                                <div class="card rounded-3 mb-4 border">
                                    <div class="card-body p-4">
                                        <div class="stock-filter">

                                            <h5 class="mb-3">@lang('messages.categories')</h5>
                                            @foreach ($categories as $category)
                                                <div class="form-check mb-2 align-items-center">
                                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="flexCheckCategory{{ $category->id }}"
                                                        {{ in_array($category->id, request()->input('categories', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckCategory{{ $category->id }}">{{ $category->current_translation?->title }} ({{ $category->products_count }})</label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-3 mb-4 border">
                                    <div class="card-body p-4">
                                        <div class="price-filter">
                                            <div id="slider-range"></div>
                                            <div class="d-flex align-items-center justify-content-center gap-3">
                                                <input class="form-control" name="min_price" type="number" min="0" max="{{ $maxPrice - 100 }}"
                                                    oninput="validity.valid||(value={{ $minPrice }});" id="min_price"
                                                    value="{{ request()->input('min_price', $minPrice) }}">
                                                <input class="form-control" name="max_price" type="number" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                                    oninput="validity.valid||(value={{ $maxPrice }});" id="max_price"
                                                    value="{{ request()->input('max_price', $maxPrice) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($attributes as $attribute)
                                <div class="card rounded-3 mb-4 border">
                                    <div class="card-body p-4">
                                        <div class="size-filter">
                                            <h5 class="mb-3">{{ $attribute['name'] }}</h5>
                                            <div class="product-size-list d-flex align-items-center flex-wrap gap-3">
                                                @foreach ($attribute['options'] as $option)
                                                    <div class="product-size-list-item">
                                                        <input type="radio" class="btn-check" name="attribute[{{ $attribute['id'] }}]" value="{{ $option }}" id="size-option-{{ $attribute['name'] }}-{{ $option }}"
                                                            {{ request()->input('attribute.' . $attribute['id']) == $option ? 'checked' : '' }}>
                                                        <label class="btn btn-outline-dark btn-product-size" for="size-option-{{ $attribute['name'] }}-{{ $option }}">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="card rounded-3 mb-4 border">
                                    <div class="card-body p-4">
                                        <div class="stock-filter">

                                            <h5 class="mb-3">@lang('messages.Brands')</h5>
                                            @foreach ($brands as $brand)
                                                <div class="form-check mb-2 align-items-center">
                                                    <input class="form-check-input" type="checkbox" name="brands[]" value="{{ $brand->id }}" id="flexCheckBrand{{ $brand->id }}"
                                                        {{ in_array($brand->id, request()->input('brands', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckBrand{{ $brand->id }}">{{ $brand->current_translation?->title }} ({{ $brand->products_count }})</label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-3 mb-4 border">
                                    <div class="card-body p-4">
                                        <div class="stock-filter">

                                            <button type="submit" class="btn btn-outline-dark px-4">@lang('messages.Filter')</button>

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div><!--end filters-->
                        </div>
                    </div>
                    </nav>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="shop-products">
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 gap-sm-0 mb-4">
                        <div>
                            <p class="mb-0">@lang('messages.Found') <span class="fw-semibold">{{ $products->total() }}</span> @lang('messages.items')</p>
                        </div>

                    </div>
                    <shop-product :filters="{{ $productData }}" :user="{{ auth('user')->user() }}" :setting="{{ $setting }}"></shop-product>


                    <!--pagination-->
                    <div class="page-pagination">
                        <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $products->previousPageUrl() ?? 'javascript:;' }}" aria-label="Previous">
                                    <i class="bi bi-chevron-double-left"></i>
                                </a>
                            </li>

                            {{-- Pagination Elements --}}
                            @foreach ($products->links()->elements[0] as $page => $url)
                                @if ($page == $products->currentPage())
                                    <li class="page-item active"><a class="page-link" href="javascript:;">{{ $page }}</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $products->nextPageUrl() ?? 'javascript:;' }}" aria-label="Next">
                                    <i class="bi bi-chevron-double-right"></i>
                                </a>
                            </li>
                        </ul>
                        </nav>
                    </div>
                    <!--end pagination-->

                    </div>
                </div>
                </div><!--end row-->
            </div>
        </section>
        <!--end shop-->
    </main>
    <!--end shop-->


@push('scripts')

<script src="/website/js/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" defer></script>
{{-- <script src="/website/js/price_range_script.js" defer></script> --}}

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Hide submit button initially (if exists)
    $('#price-range-submit').hide();

    // Update slider when input changes
    $("#min_price, #max_price").on('change', function() {
        $('#price-range-submit').show();

        let min_price_range = parseInt($("#min_price").val()) || 0;
        let max_price_range = parseInt($("#max_price").val()) || 10000;

        if (min_price_range > max_price_range) {
            $('#max_price').val(min_price_range);
            max_price_range = min_price_range;
        }

        $("#slider-range").slider("values", [min_price_range, max_price_range]);
    });

    // Update slider when typing/pasting
    $("#min_price, #max_price").on("paste keyup", function() {
        $('#price-range-submit').show();

        let min_price_range = parseInt($("#min_price").val()) || 0;
        let max_price_range = parseInt($("#max_price").val()) || 10000;

        if (min_price_range === max_price_range) {
            max_price_range = min_price_range + 100;
            $("#max_price").val(max_price_range);
        }

        $("#slider-range").slider("values", [min_price_range, max_price_range]);
    });

    // Initialize slider
    $("#slider-range").slider({
        range: true,
        orientation: "horizontal",
        min: {{ $minPrice }},
        max: parseInt({{ $maxPrice }}),
        values: [{{ request()->input('min_price', $minPrice) }}, parseInt({{ request()->input('max_price', $maxPrice) }})],
        step: 100,
        slide: function(event, ui) {
            if (ui.values[0] === ui.values[1]) {
                return false;
            }
            $("#min_price").val(ui.values[0]);
            $("#max_price").val(ui.values[1]);
        }
    });

    // Set initial input values
    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));

    // Example click handler (replace with your logic)
    $("#slider-range, #price-range-submit").click(function() {
        let min_price = $('#min_price').val();
        let max_price = $('#max_price').val();
        $("#searchResults").text("Here List of products will be shown which are cost between " + min_price + " and " + max_price + ".");
    });
});
</script>

@endpush



@endsection


