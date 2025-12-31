@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Shop'))
@push("headStyle")

@endpush
@section('body')
    <!-- Poster Section Start -->
    <section>
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="slider-1 slider-animate product-wrapper no-arrow">
                        <div>
                            <div class="banner-contain-2 hover-effect">
                                <img src="{{asset('website/images/veg-3/home-bg.png')}}" class="bg-img rounded-3 blur-up lazyload" alt="">
                                <div
                                    class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                    <div>
                                        <h2> {{ $selectedCategory->translation->title ?? ($selectedDepartment->translation->title ?? __('messages.Shop')) }}</h2>
                                        <h3>{{ __('messages.Save upto 50%') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Poster Section End -->

    <!-- Shop Section Start -->
    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-custome-3">
                    <div class="left-box wow fadeInUp">
                        <div class="shop-left-sidebar">
                            <div class="back-button">
                                <h3><i class="fa-solid fa-arrow-left"></i> {{ __('messages.Back') }}</h3>
                            </div>

                            <div class="accordion custome-accordion" id="accordionExample">
                                {{-- Search Filter --}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSearch">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseSearch" aria-expanded="true"
                                                aria-controls="collapseSearch">
                                            <span>{{ __('messages.Search') }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSearch" class="accordion-collapse collapse show"
                                         aria-labelledby="headingSearch">
                                        <div class="accordion-body">
                                            <div class="form-floating theme-form-floating-2 search-box">
                                                <input type="search" class="form-control" id="filter-search"
                                                       placeholder="{{ __('messages.Search') }}..">
                                                <label for="filter-search">{{ __('messages.Search') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Categories Filter --}}
                                @if(!request('category'))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                            <span>{{ __('messages.categories') }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                         aria-labelledby="headingOne">
                                        <div class="accordion-body">
                                            <ul class="category-list custom-padding custom-height" id="categories-filter">
                                                @foreach($categories as $category)
                                                    @php
                                                        $categoryTranslation = $category->translation ?? $category->translations->first();
                                                    @endphp
                                                    @if($categoryTranslation)
                                                        <li>
                                                            <div class="form-check ps-0 m-0 category-list-box">
                                                                <input class="checkbox_animated filter-category"
                                                                       type="checkbox"
                                                                       id="category-{{ $category->id }}"
                                                                       value="{{ $category->id }}">
                                                                <label class="form-check-label" for="category-{{ $category->id }}">
                                                                    <span class="name">{{ $categoryTranslation->title }}</span>
                                                                    <span class="number">({{ $category->products_count ?? 0 }})</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{-- Condition Filter (New/Used/Rent) - Only for Buying Department --}}
                                <div class="accordion-item" id="condition-filter-section" style="display: none;">
                                    <h2 class="accordion-header" id="headingCondition">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseCondition" aria-expanded="false"
                                                aria-controls="collapseCondition">
                                            <span>{{ __('messages.Condition') }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapseCondition" class="accordion-collapse collapse"
                                         aria-labelledby="headingCondition">
                                        <div class="accordion-body">
                                            <ul class="category-list custom-padding custom-height">
                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated filter-condition"
                                                               type="radio"
                                                               name="condition"
                                                               id="condition-all"
                                                               value="" checked>
                                                        <label class="form-check-label" for="condition-all">
                                                            <span class="name">{{ __('messages.All') }}</span>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated filter-condition"
                                                               type="radio"
                                                               name="condition"
                                                               id="condition-new"
                                                               value="new">
                                                        <label class="form-check-label" for="condition-new">
                                                            <span class="name">{{ __('messages.New') }}</span>
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check ps-0 m-0 category-list-box">
                                                        <input class="checkbox_animated filter-condition"
                                                               type="radio"
                                                               name="condition"
                                                               id="condition-used"
                                                               value="used">
                                                        <label class="form-check-label" for="condition-used">
                                                            <span class="name">{{ __('messages.Used') }}</span>
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                {{-- Brands Filter --}}
                                @if(isset($brands) && $brands->count() > 0)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingBrands">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseBrands" aria-expanded="false"
                                                aria-controls="collapseBrands">
                                            <span>{{ __('messages.Brands') }}</span>
                                        </button>
                                    </h2>
                                    <div id="collapseBrands" class="accordion-collapse collapse"
                                         aria-labelledby="headingBrands">
                                        <div class="accordion-body">
                                            <ul class="category-list custom-padding custom-height" id="brands-filter">
                                                @foreach($brands as $brand)
                                                    @php
                                                        $brandTranslation = $brand->translation ?? $brand->translations->first();
                                                    @endphp
                                                    @if($brandTranslation)
                                                        <li>
                                                            <div class="form-check ps-0 m-0 category-list-box">
                                                                <input class="checkbox_animated filter-brand"
                                                                       type="checkbox"
                                                                       id="brand-{{ $brand->id }}"
                                                                       value="{{ $brand->id }}">
                                                                <label class="form-check-label" for="brand-{{ $brand->id }}">
                                                                    <span class="name">{{ $brandTranslation->title }}</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-custome-9">
                    <div class="show-button">
                        <div class="filter-button-group mt-0">
                            <div class="filter-button d-inline-block d-lg-none">
                                <a><i class="fa-solid fa-filter"></i> {{ __('messages.Filter Menu') }}</a>
                            </div>
                        </div>

                        <div class="top-filter-menu">
                            <div class="category-dropdown">
                                <h5 class="text-content">{{ __('messages.Sort By') }} :</h5>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown">
                                        <span id="sort-text">{{ __('messages.Most Popular') }}</span> <i class="fa-solid fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item sort-item" href="javascript:void(0)" data-sort="latest">{{ __('messages.Latest') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item sort-item" href="javascript:void(0)" data-sort="price_low">{{ __('messages.Low - High Price') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item sort-item" href="javascript:void(0)" data-sort="price_high">{{ __('messages.High - Low Price') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item sort-item" href="javascript:void(0)" data-sort="name_asc">{{ __('messages.A - Z Order') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item sort-item" href="javascript:void(0)" data-sort="name_desc">{{ __('messages.Z - A Order') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Loading Spinner --}}
                    <div id="products-loading" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">{{ __('messages.Loading') }}...</span>
                        </div>
                    </div>

                    {{-- Products Container --}}
                    <div
                        class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section"
                        id="products-container"
                    >
                        {{-- Products will be loaded via AJAX --}}
                    </div>

                    {{-- No Products Message --}}
                    <div id="no-products" class="text-center py-5" style="display: none;">
                        <p class="text-muted">{{ __('messages.No products found') }}</p>
                    </div>

                    {{-- Pagination --}}
                    <nav class="custome-pagination" id="pagination-container">
                        {{-- Pagination will be loaded via AJAX --}}
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
@endsection

@push('headScript')
<script>
(function() {
    // Wait for jQuery to be loaded
    if (typeof jQuery === 'undefined') {
        setTimeout(arguments.callee, 100);
        return;
    }

    var $ = jQuery;

    // Get current URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const pathParts = window.location.pathname.split('/').filter(p => p);
    const departmentSlug = pathParts[pathParts.indexOf('shop') + 1] || null;
    const categorySlug = pathParts[pathParts.indexOf('shop') + 2] || null;

    // Filter state
    let filters = {
        department: departmentSlug,
        category: categorySlug,
        categories: [],
        brands: [],
        condition: '',
        search: `{{ request('search') }}` ?? '',
        sort_by: 'latest',
        page: 1
    };

    // Initialize price range slider (removed)

    // Load products function
    function loadProducts(page = 1) {
        filters.page = page;

        // Show loading
        $('#products-loading').show();
        $('#products-container').html('');
        $('#no-products').hide();

        // Build query parameters
        var params = {};
        if (filters.department) params.department = filters.department;
        if (filters.category) params.category = filters.category;
        if (filters.categories.length) params.categories = filters.categories;
        if (filters.brands.length) params.brands = filters.brands;
        if (filters.condition) params.condition = filters.condition;
        if (filters.search) params.search = filters.search;
        if (filters.sort_by) params.sort_by = filters.sort_by;
        params.page = filters.page;

        // Make AJAX request using jQuery
        $.ajax({
            url: '/api/web/shop-products',
            type: 'GET',
            data: params,
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(data) {
                $('#products-loading').hide();

                if (data.data.products && data.data.products.length > 0) {
                    renderProducts(data.data.products);
                    renderPagination(data.data.pagination);
                    $('#no-products').hide();

                    // Check if we should show condition filter (only for Buying department)
                    var firstProduct = data.data.products[0];
                    if (firstProduct.department && firstProduct.department.id === 2) {
                        $('#condition-filter-section').show();
                    } else {
                        $('#condition-filter-section').hide();
                        // Reset condition filter if not in Buying department
                        if (filters.condition && filters.condition !== '') {
                            filters.condition = '';
                            $('.filter-condition').prop('checked', false);
                            $('#condition-all').prop('checked', true);
                        }
                    }
                    initGuestWishlistIcons1();
                } else {
                    $('#products-container').html('');
                    $('#no-products').show();
                    $('#pagination-container').html('');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading products:', error);
                $('#products-loading').hide();
                $('#no-products').show();
                $('#products-container').html('');
                $('#pagination-container').html('');
            }
        });
    }

    // Render products
    function renderProducts(products) {
        var container = $('#products-container');
        container.html('');

        if (!products || products.length === 0) {
            $('#no-products').show();
            return;
        }

        var productsHtml = '';
        products.forEach(function(product) {
            var conditionLabel = getConditionLabel(product.condition);
            var conditionClass = getConditionClass(product.condition);
            var priceHtml = formatPrice(product.price, product.discount_price, product.discount_percentage);
            var productUrl = '/product-detail/' + product.slug;
            var categoryName = (product.category && product.category.name) ? product.category.name : '';
            var productTitle = product.title || '';
            var productImage = product.image || '';

            // Show condition badge:
            // - For Buying department (id = 2): show new/used badge
            // - For Renting department (id = 1): show rent badge if condition is rent
            var conditionBadge = '';
            if (product.department) {
                if (product.department.id === 2) {
                    // Buying department: show new/used badge
                    conditionBadge = '<div class="label-tag ' + conditionClass + '">' +
                        '<span>' + conditionLabel + '</span>' +
                    '</div>';
                } else if (product.department.id === 1 && product.condition === 'rent') {
                    // Renting department: show rent badge
                    conditionBadge = '<div class="label-tag ' + conditionClass + '">' +
                        '<span>' + conditionLabel + '</span>' +
                    '</div>';
                }
            }

            var productHtml = '<div>' +
                '<div class="product-box-3 h-100 wow fadeInUp">' +
                    '<div class="product-header product-box">' +
                        conditionBadge +
                        '<div class="product-image">' +
                            '<a href="' + productUrl + '">' +
                                '<img src="' + productImage + '" class="img-fluid blur-up lazyload" alt="' + productTitle + '">' +
                            '</a>' +
                            '<ul class="product-option">' +
                                '<li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.View') }}">' +
                                    '<a href="javascript:void(0)" class="view-product-btn" data-bs-toggle="modal" data-bs-target="#view" data-product-id="' + product.id + '">' +
                                        '<i data-feather="eye"></i>' +
                                    '</a>' +
                                '</li>' +
                                '<li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('messages.Wishlist') }}">' +
                                    '<a href="javascript:void(0)" class="add-to-wishlist" data-product-id="' + product.id + '">' +
                                        '<i data-feather="heart"></i>' +
                                    '</a>' +
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                    '<div class="product-footer">' +
                        '<div class="product-detail">' +
                            '<span class="span-name">' + categoryName + '</span>' +
                            '<a href="' + productUrl + '">' +
                                '<h5 class="name">' + productTitle + '</h5>' +
                            '</a>' +
                            priceHtml +
                            '<div class="add-to-cart-box bg-white mt-2">' +
                                '<button class="btn btn-add-cart addcart-button">{{ __('messages.Add') }}' +
                                    '<span class="add-icon bg-light-gray">' +
                                        '<i class="fa-solid fa-plus"></i>' +
                                    '</span>' +
                                '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';

            productsHtml += productHtml;
        });

        container.html(productsHtml);

        // Reinitialize feather icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        // Reinitialize tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(container.find('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    // Render pagination
    function renderPagination(pagination) {
        var container = $('#pagination-container');
        if (!pagination || pagination.last_page <= 1) {
            container.html('');
            return;
        }

        // Get current locale
        var isRTL = '{{ app()->getLocale() }}' === 'ar';

        var paginationHtml = '<ul class="pagination justify-content-center">';

        // Previous button - adjust arrow direction based on locale
        var prevDisabled = (pagination.current_page === 1) ? 'disabled' : '';
        var prevArrow = isRTL ? 'fa-angles-right' : 'fa-angles-left';
        paginationHtml += '<li class="page-item ' + prevDisabled + '">' +
            '<a class="page-link pagination-link" href="javascript:void(0)" data-page="' + (pagination.current_page - 1) + '">' +
                '<i class="fa-solid ' + prevArrow + '"></i>' +
            '</a>' +
        '</li>';

        // Page numbers
        for (var i = 1; i <= pagination.last_page; i++) {
            if (i === 1 || i === pagination.last_page || (i >= pagination.current_page - 2 && i <= pagination.current_page + 2)) {
                var activeClass = (i === pagination.current_page) ? 'active' : '';
                paginationHtml += '<li class="page-item ' + activeClass + '">' +
                    '<a class="page-link pagination-link" href="javascript:void(0)" data-page="' + i + '">' + i + '</a>' +
                '</li>';
            } else if (i === pagination.current_page - 3 || i === pagination.current_page + 3) {
                paginationHtml += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }

        // Next button - adjust arrow direction based on locale
        var nextDisabled = (pagination.current_page === pagination.last_page) ? 'disabled' : '';
        var nextArrow = isRTL ? 'fa-angles-left' : 'fa-angles-right';
        paginationHtml += '<li class="page-item ' + nextDisabled + '">' +
            '<a class="page-link pagination-link" href="javascript:void(0)" data-page="' + (pagination.current_page + 1) + '">' +
                '<i class="fa-solid ' + nextArrow + '"></i>' +
            '</a>' +
        '</li>';

        paginationHtml += '</ul>';
        container.html(paginationHtml);

        // Attach click handlers using jQuery
        container.find('.pagination-link').on('click', function(e) {
            e.preventDefault();
            var page = parseInt($(this).attr('data-page'));
            if (page > 0 && page <= pagination.last_page) {
                loadProducts(page);
                $('html, body').animate({ scrollTop: 0 }, 'smooth');
            }
        });
    }

    // Helper functions
    function getConditionLabel(condition) {
        const labels = {
            'new': '{{ __("messages.New") }}',
            'used': '{{ __("messages.Used") }}'
        };
        return labels[condition] || condition;
    }

    function getConditionClass(condition) {
        const classes = {
            'rent': 'bg-warning',
            'new': 'bg-success',
            'used': 'bg-info'
        };
        return classes[condition] || '';
    }

    function formatPrice(price, discountPrice, discountPercentage) {
        // Convert to numbers to ensure toFixed works
        var priceNum = parseFloat(price) || 0;
        var discountPriceNum = parseFloat(discountPrice) || 0;
        var discountPercentageNum = parseFloat(discountPercentage) || 0;

        if (discountPriceNum > 0 && discountPercentageNum > 0) {
            return '<h5 class="price">' +
                '<span class="theme-color">EGP ' + discountPriceNum.toFixed(2) + '</span>' +
                '<del>EGP ' + priceNum.toFixed(2) + '</del>' +
            '</h5>';
        }
        return '<h5 class="price"><span class="theme-color">EGP ' + priceNum.toFixed(2) + '</span></h5>';
    }

    // Filter event handlers using jQuery
    $(document).on('change', '.filter-category', function() {
        if ($(this).is(':checked')) {
            if (filters.categories.indexOf($(this).val()) === -1) {
                filters.categories.push($(this).val());
            }
        } else {
            filters.categories = filters.categories.filter(function(c) {
                return c !== $(this).val();
            }.bind(this));
        }
        loadProducts(1);
    });

    $(document).on('change', '.filter-brand', function() {
        if ($(this).is(':checked')) {
            if (filters.brands.indexOf($(this).val()) === -1) {
                filters.brands.push($(this).val());
            }
        } else {
            filters.brands = filters.brands.filter(function(b) {
                return b !== $(this).val();
            }.bind(this));
        }
        loadProducts(1);
    });

    $(document).on('change', '.filter-condition', function() {
        filters.condition = $(this).val();
        loadProducts(1);
    });

    var searchTimeout;
    $('#filter-search').on('input', function() {
        clearTimeout(searchTimeout);
        var self = this;
        searchTimeout = setTimeout(function() {
            filters.search = $(self).val();
            loadProducts(1);
        }, 500);
    });

    $(document).on('click', '.sort-item', function() {
        filters.sort_by = $(this).attr('data-sort');
        $('#sort-text').text($(this).text());
        loadProducts(1);
    });

    var isAuth1 = {{ auth('user')->check() ? 'true' : 'false' }};
    var wishlistStorageKey1 = 'wishlist_products';
    function getWishlistFromStorage1() {
        try {
            var wishlist = localStorage.getItem(wishlistStorageKey1);
            return wishlist ? JSON.parse(wishlist) : [];
        } catch (e) {
            console.error('Error reading wishlist from localStorage:', e);
            return [];
        }
    }
    function updateHeartIcon1($button, isFavorite) {
        var $icon = $button.find('.feather-heart');
        if (isFavorite) {
            $icon.addClass('fill').css({
                'color': '#e74c3c',
                'fill': '#e74c3c',
                'stroke': '#e74c3c'
            });
            $button.addClass('active wishlist-active');
        } else {
            $icon.removeClass('fill').css({
                'color': '',
                'fill': 'none',
                'stroke': ''
            });
            $button.removeClass('active wishlist-active');
        }
    }
    function initGuestWishlistIcons1() {
        if (isAuth1) {
            return;
        }

        var wishlist = getWishlistFromStorage1();
        wishlist.forEach(function(productId) {
            $('.add-to-wishlist[data-product-id="' + productId + '"]').each(function() {
                updateHeartIcon1($(this), true);
            });
        });
    }

    // Initial load
    $(document).ready(function() {
        loadProducts(1);
    });
})();
</script>
@endpush
