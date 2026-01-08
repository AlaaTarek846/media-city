
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">

@include('website.layouts.headStyle')

@push('headStyle')
<style>
    /* Wishlist Heart Icon Styles */
    .add-to-wishlist i[data-feather="heart"].fill,
    .add-to-wishlist.active i[data-feather="heart"] {
        color: #e74c3c !important;
        fill: #e74c3c !important;
        stroke: #e74c3c !important;
    }
    .add-to-wishlist:hover i[data-feather="heart"] {
        color: #e74c3c;
        transition: all 0.3s ease;
    }
    .add-to-wishlist.active {
        color: #e74c3c;
    }

    /* SweetAlert2 RTL Support */
    @if (app()->getLocale() == 'ar')
    .swal2-popup.swal2-toast.swal2-rtl,
    .swal2-popup.swal2-toast.swal2-rtl .swal2-title,
    .swal2-popup.swal2-toast.swal2-rtl .swal2-html-container {
        direction: rtl !important;
        text-align: right !important;
    }
    @else
    .swal2-popup.swal2-toast .swal2-title,
    .swal2-popup.swal2-toast .swal2-html-container {
        direction: ltr !important;
        text-align: left !important;
    }
    @endif
</style>
@endpush

<body class="theme-color-2 bg-effect">

<!-- Loader Start -->
{{--<div class="fullpage-loader">--}}
{{--    <span></span>--}}
{{--    <span></span>--}}
{{--    <span></span>--}}
{{--    <span></span>--}}
{{--    <span></span>--}}
{{--    <span></span>--}}
{{--</div>--}}
<!-- Loader End -->

@include('website.layouts.header')

@yield('body')

@include('website.layouts.footer')



<!-- latest jquery-->
<script src="{{asset('website/js/jquery-3.6.0.min.js')}}"></script>

<!-- jquery ui-->
<script src="{{asset('website/js/jquery-ui.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('website/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('website/js/bootstrap/popper.min.js')}}"></script>

<!-- feather icon js-->
<script src="{{asset('website/js/feather/feather.min.js')}}"></script>
<script src="{{asset('website/js/feather/feather-icon.js')}}"></script>

<!-- Lazyload Js -->
<script src="{{asset('website/js/lazysizes.min.js')}}"></script>

<!-- Slick js-->
<script src="{{asset('website/js/slick/slick.js')}}"></script>
<script src="{{asset('website/js/bootstrap/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('website/js/slick/custom_slick.js')}}"></script>

<!-- Auto Height Js -->
<script src="{{asset('website/js/auto-height.js')}}"></script>

<!-- Quantity Js -->
<script src="{{asset('website/js/quantity.js')}}"></script>

<!-- Timer Js -->
<script src="{{asset('website/js/timer1.js')}}"></script>
<script src="{{asset('website/js/timer2.js')}}"></script>
<script src="{{asset('website/js/timer3.js')}}"></script>
<script src="{{asset('website/js/timer4.js')}}"></script>

<!-- Fly Cart Js -->
<script src="{{asset('website/js/fly-cart.js')}}"></script>

<!-- WOW js -->
<script src="{{asset('website/js/wow.min.js')}}"></script>
<script src="{{asset('website/js/custom-wow.js')}}"></script>

<!-- script js -->
<script src="{{asset('website/js/script.js')}}"></script>

@stack("headScript")

{{-- Quick View Modal JavaScript --}}
<script>
    (function() {
        // Wait for jQuery to be loaded
        if (typeof jQuery === 'undefined') {
            setTimeout(arguments.callee, 100);
            return;
        }

        var $ = jQuery;
        var isRTL = '{{ app()->getLocale() }}' === 'ar';

        // Handle view product button click
        $(document).on('click', '.view-product-btn', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');

            if (!productId) {
                console.error('Product ID not found');
                return;
            }

            // Clear previous content first
            $('#modal-product-content').html('').hide();
            $('#carousel-inner').html('');
            $('#carousel-indicators').html('');

            // Show loading, hide content
            $('#modal-loading').show();
            $('#modal-product-content').hide();

            // Get or create modal instance
            var modalElement = document.getElementById('view');
            var modal = bootstrap.Modal.getInstance(modalElement);
            if (!modal) {
                modal = new bootstrap.Modal(modalElement);
            }

            // Open modal
            modal.show();

            // Load product data via AJAX
            $.ajax({
                url: '/api/web/product-modal/' + productId,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    // Check response status
                    if (response.status === 200 && response.data) {
                        var product = response.data;
                        renderProductModal(product);
                    } else if (response.data) {
                        // Fallback: check if data exists even without status
                        var product = response.data;
                        renderProductModal(product);
                    } else {
                        showModalError('{{ __("messages.Product not found") }}');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading product:', error);
                    console.error('Response:', xhr.responseJSON);
                    showModalError('{{ __("messages.Error loading product") }}');
                }
            });
        });

        /**
         * Render product data in modal
         */
        function renderProductModal(product) {
            // Hide loading first
            $('#modal-loading').hide();

            // Clear and rebuild content structure
            var contentHtml = '<div class="row g-sm-4 g-2">' +
                '<div class="col-lg-6">' +
                    '<div id="product-images-slider" class="carousel slide" data-bs-ride="carousel" ' +
                    (isRTL ? 'dir="rtl"' : '') + '>' +
                        '<div class="carousel-indicators" id="carousel-indicators"></div>' +
                        '<div class="carousel-inner" id="carousel-inner"></div>' +
                        (isRTL ?
                            '<button class="carousel-control-prev" type="button" data-bs-target="#product-images-slider" data-bs-slide="next">' +
                                '<span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
                                '<span class="visually-hidden">{{ __("messages.Previous") }}</span>' +
                            '</button>' +
                            '<button class="carousel-control-next" type="button" data-bs-target="#product-images-slider" data-bs-slide="prev">' +
                                '<span class="carousel-control-next-icon" aria-hidden="true"></span>' +
                                '<span class="visually-hidden">{{ __("messages.Next") }}</span>' +
                            '</button>'
                        :
                            '<button class="carousel-control-prev" type="button" data-bs-target="#product-images-slider" data-bs-slide="prev">' +
                                '<span class="carousel-control-prev-icon" aria-hidden="true"></span>' +
                                '<span class="visually-hidden">{{ __("messages.Previous") }}</span>' +
                            '</button>' +
                            '<button class="carousel-control-next" type="button" data-bs-target="#product-images-slider" data-bs-slide="next">' +
                                '<span class="carousel-control-next-icon" aria-hidden="true"></span>' +
                                '<span class="visually-hidden">{{ __("messages.Next") }}</span>' +
                            '</button>'
                        ) +
                    '</div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                    '<div class="right-sidebar-modal">' +
                        '<h4 class="title-name" id="modal-product-title"></h4>' +
                        '<div id="modal-product-price"></div>' +
                        '<div class="product-rating" id="modal-product-rating"></div>' +
                        '<div class="product-detail" id="modal-product-description"></div>' +
                        '<ul class="brand-list" id="modal-product-info"></ul>' +
                        // Rent fields (only for rent products)
                        '<div id="modal-rent-fields" style="display: none;" class="rent-fields-wrapper-modal mb-3">' +
                            '<div class="rent-header-modal mb-3">' +
                                '<h5 class="rent-title-modal">' +
                                    '<i class="fa-solid fa-calendar-days me-2"></i>' +
                                    '{{ __("messages.Rental Period") }}' +
                                '</h5>' +
                                '<p class="text-content mb-0" style="font-size: 0.9rem;">{{ __("messages.Please select your rental period") }}</p>' +
                            '</div>' +
                            '<div class="rent-fields-content-modal">' +
                                '<div class="row g-3">' +
                                    '<div class="col-md-6">' +
                                        '<div class="form-group-rent-modal">' +
                                            '<label for="modal-start-date" class="form-label rent-label-modal">' +
                                                '<i class="fa-solid fa-calendar-check me-2"></i>' +
                                                '{{ __("messages.Start Date") }} <span class="text-danger">*</span>' +
                                            '</label>' +
                                            '<div class="input-wrapper-rent-modal">' +
                                                '<input type="date" class="form-control rent-input-modal" id="modal-start-date" name="start_date" required>' +
                                                '<i class="fa-solid fa-calendar input-icon-modal"></i>' +
                                            '</div>' +
                                            '<div class="invalid-feedback">{{ __("messages.Start date is required") }}</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-md-6">' +
                                        '<div class="form-group-rent-modal">' +
                                            '<label for="modal-count-day" class="form-label rent-label-modal">' +
                                                '<i class="fa-solid fa-calendar-day me-2"></i>' +
                                                '{{ __("messages.Count Days") }} <span class="text-danger">*</span>' +
                                            '</label>' +
                                            '<div class="input-wrapper-rent-modal">' +
                                                '<input type="number" class="form-control rent-input-modal" id="modal-count-day" name="count_day" min="1" required>' +
                                                '<i class="fa-solid fa-hashtag input-icon-modal"></i>' +
                                            '</div>' +
                                            '<div class="invalid-feedback">{{ __("messages.Count days is required") }}</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="col-12">' +
                                        '<div class="form-group-rent-modal">' +
                                            '<label for="modal-note" class="form-label rent-label-modal">' +
                                                '<i class="fa-solid fa-note-sticky me-2"></i>' +
                                                '{{ __("messages.Note") }} <span class="text-muted">({{ __("messages.Optional") }})</span>' +
                                            '</label>' +
                                            '<div class="input-wrapper-rent-modal">' +
                                                '<textarea class="form-control rent-input-modal" id="modal-note" name="note" rows="3" placeholder="{{ __("messages.Note (Optional)") }}"></textarea>' +
                                                '<i class="fa-solid fa-comment input-icon-modal textarea-icon-modal"></i>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="modal-button">' +
                            '<button class="btn btn-md add-cart-button icon" id="modal-add-to-cart-btn">' +
                                '{{ __("messages.Add") }} {{ __("messages.To Cart") }}' +
                            '</button>' +
                            '<a href="#" class="btn theme-bg-color view-button icon text-white fw-bold btn-md" id="modal-view-details-btn">' +
                                '{{ __("messages.View More Details") }}' +
                            '</a>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';

            $('#modal-product-content').html(contentHtml).show();

            // Set product title
            $('#modal-product-title').text(product.title || '');

            // Set product price
            var priceHtml = '';
            if (product.discount_price && product.discount_percentage > 0) {
                priceHtml = '<h4 class="price">' +
                    '<span class="theme-color">EGP ' + parseFloat(product.discount_price).toFixed(2) + '</span>' +
                    '<del>EGP ' + parseFloat(product.price_before_discount).toFixed(2) + '</del>' +
                    '</h4>';
            } else {
                priceHtml = '<h4 class="price"><span class="theme-color">EGP ' + parseFloat(product.price).toFixed(2) + '</span></h4>';
            }
            $('#modal-product-price').html(priceHtml);

            // Set product rating
            var ratingHtml = '<ul class="rating">';
            var rating = Math.round(product.rating || 0);
            for (var i = 1; i <= 5; i++) {
                if (i <= rating) {
                    ratingHtml += '<li><i data-feather="star" class="fill"></i></li>';
                } else {
                    ratingHtml += '<li><i data-feather="star"></i></li>';
                }
            }
            ratingHtml += '</ul>';
            if (product.review_count > 0) {
                ratingHtml += '<span class="ms-2 text-danger">' + product.review_count + ' {{ __("messages.reviews") }}</span>';
            }
            $('#modal-product-rating').html(ratingHtml);

            // Set product description
            var descriptionHtml = '<h4>{{ __("messages.Product Details") }} :</h4>';
            if (product.description) {
                descriptionHtml += '<p>' + product.description + '</p>';
            } else {
                descriptionHtml += '<p>{{ __("messages.No description available") }}</p>';
            }
            $('#modal-product-description').html(descriptionHtml);

            // Set product info (Brand, SKU, Category)
            var infoHtml = '';
            if (product.brand && product.brand.name) {
                infoHtml += '<li>' +
                    '<div class="brand-box">' +
                    '<h5>{{ __("messages.Brand Name") }}:</h5>' +
                    '<h6>' + product.brand.name + '</h6>' +
                    '</div>' +
                    '</li>';
            }
            if (product.sku) {
                infoHtml += '<li>' +
                    '<div class="brand-box">' +
                    '<h5>{{ __("messages.Product Code") }}:</h5>' +
                    '<h6>' + product.sku + '</h6>' +
                    '</div>' +
                    '</li>';
            }
            if (product.category && product.category.name) {
                infoHtml += '<li>' +
                    '<div class="brand-box">' +
                    '<h5>{{ __("messages.Category") }}:</h5>' +
                    '<h6>' + product.category.name + '</h6>' +
                    '</div>' +
                    '</li>';
            }
            $('#modal-product-info').html(infoHtml);

            // Set view details button URL
            if (product.detail_url) {
                $('#modal-view-details-btn').attr('href', product.detail_url);
            }

            // Show/hide rent fields based on product condition
            var isRent = product.condition === 'rent';
            if (isRent) {
                $('#modal-rent-fields').show();
                // Set minimum date to today
                var today = new Date().toISOString().split('T')[0];
                $('#modal-start-date').attr('min', today);
            } else {
                $('#modal-rent-fields').hide();
            }

            // Set add to cart button
            $('#modal-add-to-cart-btn')
                .attr('data-product-id', product.id)
                .attr('data-variant-id', product.variant_id || '')
                .attr('data-condition', product.condition || 'new')
                .addClass('addcart-button');

            // Render product images slider
            renderProductImagesSlider(product.images || []);

            // Reinitialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        /**
         * Render product images in carousel slider
         */
        function renderProductImagesSlider(images) {
            var carouselInner = $('#carousel-inner');
            var carouselIndicators = $('#carousel-indicators');

            carouselInner.html('');
            carouselIndicators.html('');

            if (!images || images.length === 0) {
                // No images - show placeholder
                carouselInner.html(
                    '<div class="carousel-item active">' +
                    '<img src="{{ asset("website/images/veg-3/home/17.jpg") }}" class="d-block w-100 img-fluid blur-up lazyload" alt="">' +
                    '</div>'
                );
                return;
            }

            // Build carousel items and indicators
            images.forEach(function(image, index) {
                var isActive = index === 0 ? 'active' : '';

                // Indicator
                var indicator = '<button type="button" data-bs-target="#product-images-slider" data-bs-slide-to="' + index + '" ' +
                    'class="' + isActive + '" aria-current="' + (isActive ? 'true' : 'false') + '" aria-label="Slide ' + (index + 1) + '"></button>';
                carouselIndicators.append(indicator);

                // Carousel item
                var carouselItem = '<div class="carousel-item ' + isActive + '">' +
                    '<img src="' + image.url + '" class="d-block w-100 img-fluid blur-up lazyload" alt="' + (image.alt || '') + '">' +
                    '</div>';
                carouselInner.append(carouselItem);
            });

            // Reinitialize carousel if Bootstrap is available
            if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
                var carouselElement = document.getElementById('product-images-slider');
                if (carouselElement) {
                    // Destroy existing carousel instance if any
                    var existingCarousel = bootstrap.Carousel.getInstance(carouselElement);
                    if (existingCarousel) {
                        existingCarousel.dispose();
                    }
                    // Initialize new carousel
                    new bootstrap.Carousel(carouselElement, {
                        interval: false, // Disable auto-slide
                        wrap: true
                    });
                }
            }
        }

        /**
         * Show error message in modal
         */
        function showModalError(message) {
            $('#modal-loading').hide();
            $('#modal-product-content').html(
                '<div class="text-center py-5">' +
                '<p class="text-danger">' + message + '</p>' +
                '</div>'
            ).show();
        }

        // Clear modal content and remove backdrop when modal is hidden
        $('#view').on('hidden.bs.modal', function() {
            $('#modal-loading').hide();
            $('#modal-product-content').hide().html('');
            $('#carousel-inner').html('');
            $('#carousel-indicators').html('');

            // Remove backdrop if it still exists
            $('.modal-backdrop').remove();
            // Remove modal-open class from body
            $('body').removeClass('modal-open');
            // Reset body padding and overflow
            $('body').css({
                'padding-right': '',
                'overflow': ''
            });
        });

        // Also handle when modal starts to hide
        $('#view').on('hide.bs.modal', function() {
            // Ensure backdrop is removed
            setTimeout(function() {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css({
                    'padding-right': '',
                    'overflow': ''
                });
            }, 300);
        });
    })();
</script>

@if(!request()->routeIs('wishlist'))
{{-- Wishlist System JavaScript --}}
<script>
    (function() {
        'use strict';

        var $ = jQuery;
        var isRTL = '{{ app()->getLocale() }}' === 'ar';
        var isAuth = {{ auth('user')->check() ? 'true' : 'false' }};
        var wishlistStorageKey = 'wishlist_products';

        /**
         * Get wishlist from localStorage
         * @returns {Array} Array of product IDs
         */
        function getWishlistFromStorage() {
            try {
                var wishlist = localStorage.getItem(wishlistStorageKey);
                return wishlist ? JSON.parse(wishlist) : [];
            } catch (e) {
                console.error('Error reading wishlist from localStorage:', e);
                return [];
            }
        }

        /**
         * Save wishlist to localStorage
         * @param {Array} productIds - Array of product IDs
         */
        function saveWishlistToStorage(productIds) {
            try {
                localStorage.setItem(wishlistStorageKey, JSON.stringify(productIds));
            } catch (e) {
                console.error('Error saving wishlist to localStorage:', e);
            }
        }

        /**
         * Add product to localStorage wishlist
         * @param {number} productId - Product ID
         * @returns {boolean} true if added, false if already exists
         */
        function addToLocalStorageWishlist(productId) {
            var wishlist = getWishlistFromStorage();
            if (wishlist.indexOf(productId) === -1) {
                wishlist.push(productId);
                saveWishlistToStorage(wishlist);
                return true;
            }
            return false;
        }

        /**
         * Remove product from localStorage wishlist
         * @param {number} productId - Product ID
         */
        function removeFromLocalStorageWishlist(productId) {
            var wishlist = getWishlistFromStorage();
            var index = wishlist.indexOf(productId);
            if (index > -1) {
                wishlist.splice(index, 1);
                saveWishlistToStorage(wishlist);
            }
        }

        /**
         * Check if product is in localStorage wishlist
         * @param {number} productId - Product ID
         * @returns {boolean}
         */
        function isInLocalStorageWishlist(productId) {
            var wishlist = getWishlistFromStorage();
            return wishlist.indexOf(productId) > -1;
        }

        /**
         * Update heart icon state
         * @param {jQuery} $button - Button element
         * @param {boolean} isFavorite - Is product in wishlist
         */
        function updateHeartIcon($button, isFavorite) {
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
            // Reinitialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }

        /**
         * Show beautiful notification using SweetAlert2
         * @param {string} message - Message to show
         * @param {string} type - 'success' or 'error' or 'info' or 'warning'
         */
        function showNotification(message, type) {
            type = type || 'info';

            // Check if SweetAlert2 is available
            if (typeof Swal === 'undefined') {
                // Fallback to simple alert if SweetAlert2 is not loaded
                alert(message);
                return;
            }

            var icon = 'info';
            var title = '';
            var position = isRTL ? 'top-start' : 'top-end';

            // Set icon and title based on type
            switch(type) {
                case 'success':
                    icon = 'success';
                    title = '{{ __("messages.Success") }}';
                    break;
                case 'error':
                    icon = 'error';
                    title = '{{ __("messages.Error") }}';
                    break;
                case 'warning':
                    icon = 'warning';
                    title = '{{ __("messages.Warning") }}';
                    break;
                default:
                    icon = 'info';
                    title = '{{ __("messages.Information") }}';
            }

            // Show SweetAlert2 toast notification with RTL support
            Swal.fire({
                icon: icon,
                title: title,
                text: message,
                toast: true,
                position: position,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);

                    // Set direction on the toast container for RTL support
                    setTimeout(function() {
                        var popup = document.querySelector('.swal2-popup.swal2-toast');
                        if (popup) {
                            if (isRTL) {
                                popup.style.direction = 'rtl';
                                popup.style.textAlign = 'right';
                                var htmlContainer = popup.querySelector('.swal2-html-container');
                                var titleElement = popup.querySelector('.swal2-title');
                                if (htmlContainer) {
                                    htmlContainer.style.direction = 'rtl';
                                    htmlContainer.style.textAlign = 'right';
                                }
                                if (titleElement) {
                                    titleElement.style.direction = 'rtl';
                                    titleElement.style.textAlign = 'right';
                                }
                            } else {
                                popup.style.direction = 'ltr';
                                popup.style.textAlign = 'left';
                                var htmlContainer = popup.querySelector('.swal2-html-container');
                                var titleElement = popup.querySelector('.swal2-title');
                                if (htmlContainer) {
                                    htmlContainer.style.direction = 'ltr';
                                    htmlContainer.style.textAlign = 'left';
                                }
                                if (titleElement) {
                                    titleElement.style.direction = 'ltr';
                                    titleElement.style.textAlign = 'left';
                                }
                            }
                        }
                    }, 10);
                },
                customClass: {
                    popup: isRTL ? 'swal2-rtl' : ''
                }
            });
        }

        /**
         * Add product to wishlist (Auth user)
         * @param {number} productId - Product ID
         * @param {jQuery} $button - Button element
         */
        function addToWishlistAuth(productId, $button) {
            // Show loading state
            $button.prop('disabled', true);
            var originalHtml = $button.html();
            $button.html('<i class="fa fa-spinner fa-spin"></i> {{ __("messages.Loading") }}...');

            $.ajax({
                url: '/api/web/wishlist/add',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    product_id: productId
                },
                success: function(response) {
                    $button.prop('disabled', false);
                    $button.html(originalHtml);
                    if (response.data?.status == 'already_exists') {
                        showNotification(response.message || '{{ __("messages.Product already in wishlist") }}', 'info');
                        updateHeartIcon($button, true);
                    } else if (response.data?.status == 'added') {
                        showNotification(response.message || '{{ __("messages.Product added to wishlist successfully") }}', 'success');
                        updateHeartIcon($button, true);
                    }
                },
                error: function(xhr) {
                    $button.prop('disabled', false);
                    $button.html(originalHtml);

                    var message = xhr.responseJSON?.message || '{{ __("messages.Error adding product to wishlist") }}';
                    showNotification(message, 'error');
                }
            });
        }

        /**
         * Add product to wishlist (Guest user)
         * @param {number} productId - Product ID
         * @param {jQuery} $button - Button element
         */
        function addToWishlistGuest(productId, $button) {
            // Check if already exists
            if (isInLocalStorageWishlist(productId)) {
                showNotification('{{ __("messages.Product already in wishlist") }}', 'info');
                updateHeartIcon($button, true);
                return;
            }

            // Add to localStorage
            addToLocalStorageWishlist(productId);
            showNotification('{{ __("messages.Product added to wishlist successfully") }}', 'success');
            updateHeartIcon($button, true);
        }

        /**
         * Sync wishlist from localStorage to database after login
         */
        function syncWishlistAfterLogin() {
            if (!isAuth) {
                return;
            }

            var wishlist = getWishlistFromStorage();
            if (wishlist.length === 0) {
                return;
            }

            $.ajax({
                url: '/api/web/wishlist/sync',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    product_ids: wishlist
                },
                success: function(response) {
                    // Clear localStorage after successful sync
                    localStorage.removeItem(wishlistStorageKey);

                    // Update all heart icons on page
                    wishlist.forEach(function(productId) {
                        $('.add-to-wishlist[data-product-id="' + productId + '"]').each(function() {
                            updateHeartIcon($(this), true);
                        });
                    });
                },
                error: function(xhr) {
                    console.error('Error syncing wishlist:', xhr);
                }
            });
        }

        /**
         * Check wishlist status for all products on page (Auth only)
         */
        function checkWishlistStatus() {
            if (!isAuth) {
                return;
            }

            var productIds = [];
            $('.add-to-wishlist[data-product-id]').each(function() {
                var productId = $(this).data('product-id');
                if (productId && productIds.indexOf(productId) === -1) {
                    productIds.push(productId);
                }
            });

            if (productIds.length === 0) {
                return;
            }

            // Check each product
            productIds.forEach(function(productId) {
                $.ajax({
                    url: '/api/web/wishlist/check/' + productId,
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        var $button = $('.add-to-wishlist[data-product-id="' + productId + '"]');
                        updateHeartIcon($button, response.data.is_favorite);
                    },
                    error: function(xhr) {
                        console.error('Error checking wishlist status:', xhr);
                    }
                });
            });
        }

        /**
         * Initialize wishlist icons for guest users from localStorage
         */
        function initGuestWishlistIcons() {
            if (isAuth) {
                return;
            }

            var wishlist = getWishlistFromStorage();
            wishlist.forEach(function(productId) {
                $('.add-to-wishlist[data-product-id="' + productId + '"]').each(function() {
                    updateHeartIcon($(this), true);
                });
            });
        }

        /**
         * Handle add to wishlist button click
         */
        $(document).on('click', '.add-to-wishlist', function(e) {
            e.preventDefault();

            var $button = $(this);
            var productId = $button.data('product-id');

            if (!productId) {
                console.error('Product ID not found');
                return;
            }

            if (isAuth) {
                addToWishlistAuth(productId, $button);
            } else {
                addToWishlistGuest(productId, $button);
            }
        });

        /**
         * Initialize wishlist system on page load
         */
        $(document).ready(function() {
            if (isAuth) {
                // Check wishlist status for authenticated users
                checkWishlistStatus();

                // Sync localStorage wishlist after login (if any)
                syncWishlistAfterLogin();

            } else {
               initGuestWishlistIcons();
            }
        });

        /**
         * Listen for login event (triggered after successful login)
         */
        $(document).on('userLoggedIn', function() {
            isAuth = true;
            // Sync wishlist from localStorage to database
            syncWishlistAfterLogin();
        });

        /**
         * Check if user just logged in (from URL parameter)
         */
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('logged') === 'success' && isAuth) {
                // User just logged in, sync wishlist
                syncWishlistAfterLogin();
                // Check wishlist status after a short delay
                setTimeout(function() {
                    checkWishlistStatus();
                }, 500);
            }
        });

    })();
</script>
@endif

@if(request()->routeIs('wishlist'))
<script>
    (function() {
        var isAuth = {{ auth('user')->check() ? 'true' : 'false' }};
        var wishlistStorageKey = 'wishlist_products';

        /**
         * Get wishlist from localStorage
         */
        function getWishlistFromStorage() {
            try {
                var wishlist = localStorage.getItem(wishlistStorageKey);
                return wishlist ? JSON.parse(wishlist) : [];
            } catch (e) {
                console.error('Error reading wishlist from localStorage:', e);
                return [];
            }
        }

        /**
         * Save wishlist to localStorage
         */
        function saveWishlistToStorage(productIds) {
            try {
                localStorage.setItem(wishlistStorageKey, JSON.stringify(productIds));
            } catch (e) {
                console.error('Error saving wishlist to localStorage:', e);
            }
        }

        /**
         * Remove product from localStorage wishlist
         */
        function removeFromLocalStorageWishlist(productId) {
            var wishlist = getWishlistFromStorage();
            var index = wishlist.indexOf(productId);
            if (index > -1) {
                wishlist.splice(index, 1);
                saveWishlistToStorage(wishlist);
            }
        }

        /**
         * Load wishlist products for guest users
         */
        function loadGuestWishlistProducts() {
            if (isAuth) {
                return;
            }

            var wishlist = getWishlistFromStorage();
            if (wishlist.length === 0) {
                // Show empty message
                $('#wishlist-products-container').html(
                    '<div class="col-12">' +
                    '<div class="text-center py-5">' +
                    '<h4>{{ __("messages.Your wishlist is empty") }}</h4>' +
                    '<p class="text-muted">{{ __("messages.Add products to your wishlist to see them here") }}</p>' +
                    '</div>' +
                    '</div>'
                );
                return;
            }

            // Show loading
            $('#wishlist-products-container').html(
                '<div class="col-12 text-center py-5">' +
                '<div class="spinner-border" role="status">' +
                '<span class="visually-hidden">Loading...</span>' +
                '</div>' +
                '</div>'
            );

            // Fetch products by IDs
            $.ajax({
                url: '/api/web/wishlist/products-by-ids',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                data: {
                    product_ids: wishlist
                },
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        renderWishlistProducts(response.data);
                    } else {
                        $('#wishlist-products-container').html(
                            '<div class="col-12">' +
                            '<div class="text-center py-5">' +
                            '<h4>{{ __("messages.Your wishlist is empty") }}</h4>' +
                            '<p class="text-muted">{{ __("messages.Add products to your wishlist to see them here") }}</p>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                },
                error: function(xhr) {
                    console.error('Error loading wishlist products:', xhr);
                    $('#wishlist-products-container').html(
                        '<div class="col-12">' +
                        '<div class="text-center py-5">' +
                        '<h4>{{ __("messages.Error loading wishlist") }}</h4>' +
                        '<p class="text-muted">{{ __("messages.Please try again later") }}</p>' +
                        '</div>' +
                        '</div>'
                    );
                }
            });
        }

        /**
         * Render wishlist products (same style as shop.blade.php)
         */
        function renderWishlistProducts(products) {
            var html = '';

            products.forEach(function(product) {
                var productUrl = '{{ route("productDetail", ":slug") }}'.replace(':slug', product.slug || product.id);
                var priceHtml = '';
                var conditionLabel = '';
                var conditionClass = '';
                var conditionBadge = '';

                // Format price
                if (product.discount_price && product.discount_percentage > 0) {
                    priceHtml = '<span class="theme-color">{{ __("messages.currency") }} ' + parseFloat(product.discount_price).toFixed(2) + '</span>' +
                                '<del>{{ __("messages.currency") }} ' + parseFloat(product.price_before_discount || product.price).toFixed(2) + '</del>';
                } else {
                    priceHtml = '<span class="theme-color">{{ __("messages.currency") }} ' + parseFloat(product.price).toFixed(2) + '</span>';
                }

                // Condition badge logic (same as shop.blade.php)
                if (product.department) {
                    if (product.department.id === 2) {
                        // Buying department: show new/used badge
                        if (product.condition === 'new') {
                            conditionLabel = '{{ __("messages.New") }}';
                            conditionClass = 'bg-success';
                            conditionBadge = '<div class="label-tag ' + conditionClass + '"><span>' + conditionLabel + '</span></div>';
                        } else if (product.condition === 'used') {
                            conditionLabel = '{{ __("messages.Used") }}';
                            conditionClass = 'bg-info';
                            conditionBadge = '<div class="label-tag ' + conditionClass + '"><span>' + conditionLabel + '</span></div>';
                        }
                    } else if (product.department.id === 1 && product.condition === 'rent') {
                        // Renting department: show rent badge
                        conditionLabel = '{{ __("messages.Rent") }}';
                        conditionClass = 'bg-warning';
                        conditionBadge = '<div class="label-tag ' + conditionClass + '"><span>' + conditionLabel + '</span></div>';
                    }
                }

                html += '<div>' +
                    '<div class="product-box-3 h-100 wow fadeInUp" style="position: relative;">' +
                        '<button type="button" class="wishlist-delete-btn close_button" data-product-id="' + product.id + '" title="{{ __("messages.Remove from wishlist") }}">' +
                            '<i class="fa-solid fa-xmark"></i>' +
                        '</button>' +
                        '<div class="product-header product-box">' +
                            conditionBadge +
                            '<div class="product-image">' +
                                '<a href="' + productUrl + '">' +
                                    '<img src="' + product.image + '" class="img-fluid blur-up lazyload" alt="' + (product.title || '') + '">' +
                                '</a>' +
                                '<ul class="product-option">' +
                                    '<li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __("messages.View") }}">' +
                                        '<a href="javascript:void(0)" class="view-product-btn" data-bs-toggle="modal" data-bs-target="#view" data-product-id="' + product.id + '">' +
                                            '<i data-feather="eye"></i>' +
                                        '</a>' +
                                    '</li>' +
                                    '<li data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __("messages.Remove from wishlist") }}">' +
                                        '<a href="javascript:void(0)" class="add-to-wishlist wishlist-button close_button" data-product-id="' + product.id + '">' +
                                            '<i data-feather="heart" class="fill"></i>' +
                                        '</a>' +
                                    '</li>' +
                                '</ul>' +
                            '</div>' +
                        '</div>' +
                        '<div class="product-footer">' +
                            '<div class="product-detail">' +
                                '<span class="span-name">' + (product.category ? product.category.name : '') + '</span>' +
                                '<a href="' + productUrl + '">' +
                                    '<h5 class="name">' + (product.title || '') + '</h5>' +
                                '</a>' +
                                '<h5 class="price">' + priceHtml + '</h5>' +
                                '<div class="add-to-cart-box bg-white mt-2">' +
                                    '<button class="btn btn-add-cart addcart-button" ' +
                                        'data-product-id="' + product.id + '" ' +
                                        'data-variant-id="' + (product.variant_id || '') + '" ' +
                                        'data-condition="' + (product.condition || 'new') + '">{{ __("messages.Add") }}' +
                                        '<span class="add-icon bg-light-gray">' +
                                            '<i class="fa-solid fa-plus"></i>' +
                                        '</span>' +
                                    '</button>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';
            });

            $('#wishlist-products-container').html(html);

            // Reinitialize feather icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            // Reinitialize tooltips
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                var tooltipTriggerList = [].slice.call($('#wishlist-products-container').find('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }

        /**
         * Remove product from wishlist
         */
        function removeFromWishlist(productId, $element) {
            if (isAuth) {
                // Remove from database
                $.ajax({
                    url: '/api/web/delete-favorite/' + productId,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        // Find the product container (works with both old and new structure)
                        var $productContainer = $element.closest('.product-box-contain');

                        // If not found, try to find the parent div containing product-box-3 (new structure)
                        if ($productContainer.length === 0) {
                            $productContainer = $element.closest('div').parent();
                            // Make sure it contains product-box-3
                            if (!$productContainer.find('.product-box-3').length) {
                                $productContainer = $element.closest('.product-box-3').parent();
                            }
                        }

                        // If still not found, find any parent div that's a direct child of wishlist container
                        if ($productContainer.length === 0 || $productContainer.hasClass('product-list-section') || $productContainer.attr('id') === 'wishlist-products-container') {
                            $productContainer = $element.closest('div:has(.product-box-3)');
                        }

                        if ($productContainer.length === 0) {
                            // Fallback: find the closest div that's a direct child of the container
                            $productContainer = $element.closest('#wishlist-products-container > div');
                        }

                        $productContainer.fadeOut('slow', function() {
                            $(this).remove();

                            // Check if wishlist is empty (works with both structures)
                            var remainingProducts = $('#wishlist-products-container .product-box-3, #wishlist-products-container .product-box-contain').length;
                            if (remainingProducts === 0) {
                                $('#wishlist-products-container').html(
                                    '<div class="col-12">' +
                                    '<div class="text-center py-5">' +
                                    '<h4>{{ __("messages.Your wishlist is empty") }}</h4>' +
                                    '<p class="text-muted">{{ __("messages.Add products to your wishlist to see them here") }}</p>' +
                                    '</div>' +
                                    '</div>'
                                );
                            }

                            // Update wishlist icons on page
                            $('.add-to-wishlist[data-product-id="' + productId + '"]').each(function() {
                                updateHeartIcon($(this), false);
                            });
                        });

                        // Show success message
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: '{{ __("messages.Success") }}',
                                text: response.message || '{{ __("messages.Product removed from wishlist") }}',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error removing product from wishlist:', xhr);
                        var message = xhr.responseJSON?.message || '{{ __("messages.Error removing product from wishlist") }}';
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("messages.Error") }}',
                                text: message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            alert(message);
                        }
                    }
                });
            } else {
                // Remove from localStorage
                removeFromLocalStorageWishlist(productId);

                // Find the product container (works with both old and new structure)
                var $productContainer = $element.closest('.product-box-contain');

                // If not found, try to find the parent div containing product-box-3 (new structure)
                if ($productContainer.length === 0) {
                    $productContainer = $element.closest('div').parent();
                    // Make sure it contains product-box-3
                    if (!$productContainer.find('.product-box-3').length) {
                        $productContainer = $element.closest('.product-box-3').parent();
                    }
                }

                // If still not found, find any parent div that's a direct child of wishlist container
                if ($productContainer.length === 0 || $productContainer.hasClass('product-list-section') || $productContainer.attr('id') === 'wishlist-products-container') {
                    $productContainer = $element.closest('div:has(.product-box-3)');
                }

                if ($productContainer.length === 0) {
                    // Fallback: find the closest div that's a direct child of the container
                    $productContainer = $element.closest('#wishlist-products-container > div');
                }

                $productContainer.fadeOut('slow', function() {
                    $(this).remove();

                    // Reload wishlist if empty
                    var wishlist = getWishlistFromStorage();
                    if (wishlist.length === 0) {
                        $('#wishlist-products-container').html(
                            '<div class="col-12">' +
                            '<div class="text-center py-5">' +
                            '<h4>{{ __("messages.Your wishlist is empty") }}</h4>' +
                            '<p class="text-muted">{{ __("messages.Add products to your wishlist to see them here") }}</p>' +
                            '</div>' +
                            '</div>'
                        );
                    } else {
                        // Reload products from localStorage
                        loadGuestWishlistProducts();
                    }

                    // Update wishlist icons on page
                    $('.add-to-wishlist[data-product-id="' + productId + '"]').each(function() {
                        updateHeartIcon($(this), false);
                    });
                });

                // Show success message
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("messages.Success") }}',
                        text: '{{ __("messages.Product removed from wishlist") }}',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        }

        /**
         * Initialize wishlist page
         */
        $(document).ready(function() {
            // Load products for guest users
            if (!isAuth) {
                loadGuestWishlistProducts();
            }

            // Handle remove button click (wishlist page)
            // This handles both the close_button class, wishlist-button in product-option, and wishlist-delete-btn
            $(document).on('click', '.wishlist-button.close_button, .add-to-wishlist.wishlist-button.close_button, .wishlist-delete-btn.close_button, .close_button[data-product-id]', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $button = $(this);
                var productId = $button.data('product-id');

                // Try to find product ID from various sources
                if (!productId) {
                    // Try from closest product-box-contain (old structure)
                    productId = $button.closest('.product-box-contain').data('product-id');
                }
                if (!productId) {
                    // Try from closest element with data-product-id
                    productId = $button.closest('[data-product-id]').data('product-id');
                }
                if (!productId) {
                    // Find product ID from parent container (new structure in wishlist page)
                    var $productBox = $button.closest('.product-box-3');
                    if ($productBox.length) {
                        var $parentDiv = $productBox.closest('div');
                        var $productLink = $parentDiv.find('a[href*="/product/"], a[href*="/product-detail/"]');
                        if ($productLink.length) {
                            var href = $productLink.attr('href');
                            var match = href.match(/\/(\d+)$/);
                            if (match) {
                                productId = parseInt(match[1]);
                            }
                        }
                    }
                }

                if (productId) {
                    removeFromWishlist(productId, $button);
                } else {
                    console.error('Product ID not found for wishlist removal', $button);
                }
            });
        });
    })();
</script>
@endif

{{-- Cart System JavaScript --}}
<script>
    (function() {
        'use strict';

        var $ = jQuery;
        var isRTL = '{{ app()->getLocale() }}' === 'ar';
        var isAuth = {{ auth('user')->check() ? 'true' : 'false' }};
        var isCheckout = {{ request()->routeIs('checkout') ? 'true' : 'false' }};
        var cartStorageKey = 'cart_products';

        /**
         * Get cart from localStorage
         * @returns {Array} Array of cart items
         */
        function getCartFromStorage() {
            try {
                var cart = localStorage.getItem(cartStorageKey);
                return cart ? JSON.parse(cart) : [];
            } catch (e) {
                console.error('Error reading cart from localStorage:', e);
                return [];
            }
        }

        /**
         * Save cart to localStorage
         * @param {Array} cartItems - Array of cart items
         */
        function saveCartToStorage(cartItems) {
            try {
                localStorage.setItem(cartStorageKey, JSON.stringify(cartItems));
            } catch (e) {
                console.error('Error saving cart to localStorage:', e);
            }
        }

        /**
         * Add product to localStorage cart
         * @param {number} productId - Product ID
         * @param {number} variantId - Variant ID (optional)
         * @param {number} quantity - Quantity (default: 1)
         */
        /**
         * Add product to localStorage cart (Guest users)
         * @param {number} productId - Product ID
         * @param {number} variantId - Variant ID (optional)
         * @param {number} quantity - Quantity (default: 1)
         * @param {string} condition - Product condition (buy/rent)
         * @param {object} rentData - Rent data (start_date, count_day, note) - only for rent products
         */
        function addToLocalStorageCart(productId, variantId, quantity, condition, rentData) {
            quantity = quantity || 1;
            condition = condition || 'new';
            rentData = rentData || {};
            var cart = getCartFromStorage();

            // For rent products, check if product already exists (rent products can only be added once)
            if (condition === 'rent') {
                // Check if this rent product already exists in cart
                var existingRentItem = cart.find(function(item) {
                    return item.product_id == productId &&
                           (variantId ? item.variant_id == variantId : !item.variant_id) &&
                           item.type === 'rent';
                });

                if (existingRentItem) {
                    // Rent product already exists, return false to prevent adding
                    return false;
                }

                // Add new rent item
                cart.push({
                    product_id: productId,
                    variant_id: variantId || null,
                    quantity: quantity,
                    type: 'rent',
                    start_date: rentData.start_date,
                    count_day: rentData.count_day,
                    note: rentData.note || null
                });
            } else {
                // For buy products, check if product already exists
                var existingItem = cart.find(function(item) {
                    return item.product_id == productId &&
                           (variantId ? item.variant_id == variantId : !item.variant_id) &&
                           item.type !== 'rent';
                });

                if (existingItem) {
                    // Update quantity
                    existingItem.quantity = (existingItem.quantity || 0) + quantity;
                } else {
                    // Add new item
                    cart.push({
                        product_id: productId,
                        variant_id: variantId || null,
                        quantity: quantity,
                        type: 'buy'
                    });
                }
            }

            saveCartToStorage(cart);
        }

        /**
         * Remove product from localStorage cart
         * @param {number} productId - Product ID
         * @param {number} variantId - Variant ID (optional)
         */
        function removeFromLocalStorageCart(productId, variantId) {
            var cart = getCartFromStorage();
            cart = cart.filter(function(item) {
                if (variantId) {
                    return !(item.product_id == productId && item.variant_id == variantId);
                }
                return item.product_id != productId;
            });
            saveCartToStorage(cart);
        }

        /**
         * Sync cart from localStorage to database after login
         */
        function syncCartAfterLogin() {
            if (!isAuth) {
                return;
            }

            var cart = getCartFromStorage();
            if (cart.length === 0) {
                return;
            }

            $.ajax({
                url: '/api/web/cart/sync',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    products: cart
                },
                success: function(response) {
                    // Clear localStorage after successful sync
                    localStorage.removeItem(cartStorageKey);
                    // Update cart display
                    updateCartDisplay();
                },
                error: function(xhr) {
                    console.error('Error syncing cart:', xhr);
                }
            });
        }

        /**
         * Add product to cart (Auth or Guest)
         * @param {number} productId - Product ID
         * @param {number} variantId - Variant ID (optional)
         * @param {number} quantity - Quantity (default: 1)
         * @param {string} condition - Product condition (buy/rent)
         * @param {object} rentData - Rent data (start_date, count_day, note) - only for rent products
         */
        function addToCart(productId, variantId, quantity, condition, rentData) {
            quantity = quantity || 1;
            condition = condition || 'new';
            rentData = rentData || {};

            // Validate rent fields if product is rent
            if (condition === 'rent') {
                if (!rentData.start_date || !rentData.count_day) {
                    showNotification('{{ __("messages.Start date is required") }} / {{ __("messages.Count days is required") }}', 'error');
                    return;
                }
                if (parseInt(rentData.count_day) < 1) {
                    showNotification('{{ __("messages.Count days must be at least 1") }}', 'error');
                    return;
                }
            }

            if (isAuth) {
                // For rent products, check if already exists in cart before adding
                if (condition === 'rent') {
                    // Check if rent product already exists in cart
                    $.ajax({
                        url: '/api/web/cart/items',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function(response) {
                            if (response.data && response.data.items) {
                                var existingRentItem = response.data.items.find(function(item) {
                                    return item.product_id == productId &&
                                           (variantId ? item.variant_id == variantId : !item.variant_id) &&
                                           item.type === 'rent';
                                });

                                if (existingRentItem) {
                                    showNotification('{{ __("messages.Rent product already in cart") }}', 'error');
                                    return;
                                }
                            }

                            // Product doesn't exist, proceed with adding
                            var data = {
                                product_id: productId,
                                variant_id: variantId || null,
                                quantity: quantity,
                                type: 'rent'
                            };

                            // Add rent fields
                            data.start_date = rentData.start_date;
                            data.count_day = rentData.count_day;
                            data.note = rentData.note || null;

                            $.ajax({
                                url: '/api/web/cart/add-single',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    'Accept': 'application/json'
                                },
                                xhrFields: {
                                    withCredentials: true
                                },
                                data: data,
                                success: function(response) {
                                    showNotification(response.message || '{{ __("messages.Product added to cart successfully") }}', 'success');
                                    updateCartDisplay();
                                },
                                error: function(xhr) {
                                    var message = xhr.responseJSON?.message || '{{ __("messages.Error adding product to cart") }}';
                                    showNotification(message, 'error');
                                }
                            });
                        },
                        error: function(xhr) {
                            console.error('Error checking cart:', xhr);
                            // Proceed with adding anyway
                            var data = {
                                product_id: productId,
                                variant_id: variantId || null,
                                quantity: quantity,
                                type: 'rent'
                            };

                            data.start_date = rentData.start_date;
                            data.count_day = rentData.count_day;
                            data.note = rentData.note || null;

                            $.ajax({
                                url: '/api/web/cart/add-single',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    'Accept': 'application/json'
                                },
                                xhrFields: {
                                    withCredentials: true
                                },
                                data: data,
                                success: function(response) {
                                    showNotification(response.message || '{{ __("messages.Product added to cart successfully") }}', 'success');
                                    updateCartDisplay();
                                },
                                error: function(xhr) {
                                    var message = xhr.responseJSON?.message || '{{ __("messages.Error adding product to cart") }}';
                                    showNotification(message, 'error');
                                }
                            });
                        }
                    });
                } else {
                    // For buy products, add directly
                    var data = {
                        product_id: productId,
                        variant_id: variantId || null,
                        quantity: quantity,
                        type: 'buy'
                    };

                    $.ajax({
                        url: '/api/web/cart/add-single',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        xhrFields: {
                            withCredentials: true
                        },
                        data: data,
                        success: function(response) {
                            showNotification(response.message || '{{ __("messages.Product added to cart successfully") }}', 'success');
                            updateCartDisplay();
                        },
                        error: function(xhr) {
                            var message = xhr.responseJSON?.message || '{{ __("messages.Error adding product to cart") }}';
                            showNotification(message, 'error');
                        }
                    });
                }
            } else {
                // Add to localStorage
                var added = addToLocalStorageCart(productId, variantId, quantity, condition, rentData);
                if (added === false) {
                    // Rent product already exists
                    showNotification('{{ __("messages.Rent product already in cart") }}', 'error');
                } else {
                    showNotification('{{ __("messages.Product added to cart successfully") }}', 'success');
                    updateCartDisplay();
                }
            }
        }

        /**
         * Update cart display in header and footer
         */
        window.updateCartDisplay = function() {
            var isAuth = {{ auth('user')->check() ? 'true' : 'false' }};
            var cartStorageKey = 'cart_products';

            // Helper function to get cart from localStorage
            function getCartFromStorage() {
                try {
                    var cart = localStorage.getItem(cartStorageKey);
                    return cart ? JSON.parse(cart) : [];
                } catch (e) {
                    console.error('Error reading cart from localStorage:', e);
                    return [];
                }
            }

            if (isAuth) {
                // Fetch cart from database
                $.ajax({
                    url: '/api/web/cart/items',
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        if (response.data && response.data.items) {
                            var items = response.data.items || [];
                            var total = response.data.total || 0;
                            var itemsCount = response.data.items_count || 0;

                            if (typeof renderCartHeader === 'function') {
                                renderCartHeader(items, total, itemsCount);
                            }
                            if (typeof renderCartFooter === 'function') {
                                renderCartFooter(items, total, itemsCount);
                            }
                        } else {
                            if (typeof renderCartHeader === 'function') {
                                renderCartHeader([], 0, 0);
                            }
                            if (typeof renderCartFooter === 'function') {
                                renderCartFooter([], 0, 0);
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching cart items:', xhr);
                        // Show empty cart on error
                        if (typeof renderCartHeader === 'function') {
                            renderCartHeader([], 0, 0);
                        }
                        if (typeof renderCartFooter === 'function') {
                            renderCartFooter([], 0, 0);
                        }
                    }
                });
            } else {
                // Get cart from localStorage and fetch product details
                var cart = getCartFromStorage();
                if (cart.length === 0) {
                    if (typeof renderCartHeader === 'function') {
                        renderCartHeader([], 0, 0);
                    }
                    if (typeof renderCartFooter === 'function') {
                        renderCartFooter([], 0, 0);
                    }
                    return;
                }

                // Fetch products by IDs
                var productIds = cart.map(function(item) { return item.product_id; });
                $.ajax({
                    url: '/api/web/wishlist/products-by-ids',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    data: {
                        product_ids: productIds
                    },
                    success: function(response) {
                        if (response.data && response.data.length > 0) {
                            // Map cart items with product details
                            var items = cart.map(function(cartItem) {
                                var product = response.data.find(function(p) {
                                    return p.id == cartItem.product_id;
                                });
                                if (product) {
                                    // Use discount price if available, otherwise use regular price
                                    var itemPrice = product.discount_price && product.discount_percentage > 0
                                        ? product.discount_price
                                        : product.price;

                                    return {
                                        product_id: cartItem.product_id,
                                        variant_id: cartItem.variant_id,
                                        title: product.title,
                                        slug: product.slug,
                                        image: product.image,
                                        quantity: cartItem.quantity || 1,
                                        price: itemPrice,
                                        total: itemPrice * (cartItem.quantity || 1),
                                        unit: product.unit || ''
                                    };
                                }
                                return null;
                            }).filter(function(item) { return item !== null; });

                            var total = items.reduce(function(sum, item) { return sum + (item.total || 0); }, 0);
                            var itemsCount = items.reduce(function(sum, item) { return sum + (item.quantity || 0); }, 0);

                            if (typeof renderCartHeader === 'function') {
                                renderCartHeader(items, total, itemsCount);
                            }
                            if (typeof renderCartFooter === 'function') {
                                renderCartFooter(items, total, itemsCount);
                            }
                        } else {
                            // No products found
                            if (typeof renderCartHeader === 'function') {
                                renderCartHeader([], 0, 0);
                            }
                            if (typeof renderCartFooter === 'function') {
                                renderCartFooter([], 0, 0);
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching cart products:', xhr);
                        // Show empty cart on error
                        if (typeof renderCartHeader === 'function') {
                            renderCartHeader([], 0, 0);
                        }
                        if (typeof renderCartFooter === 'function') {
                            renderCartFooter([], 0, 0);
                        }
                    }
                });
            }
        };

        /**
         * Render cart in header
         */
        function renderCartHeader(items, total, itemsCount) {
            var $cartSection = $('.cart-section-custom');
            if ($cartSection.length === 0) return;

            // Update badge count
            var $badge = $cartSection.find('.badge');
            if (itemsCount > 0) {
                $badge.text(itemsCount).show();
            } else {
                $badge.hide();
            }

            // Update cart list
            var $cartList = $cartSection.find('.cart-list');
            if (items.length === 0) {
                $cartList.html('<li class="text-center py-3"><p class="text-muted mb-0 text-center">{{ __("messages.Your cart is empty") }}</p></li>');
            } else {
                var html = '';
                items.forEach(function(item) {
                    let closeCustom = !isCheckout ? ('<button class="close-button close-cart-item" data-product-id="' + item.product_id + '" data-variant-id="' + (item.variant_id || '') + '">' +
                        '<i class="fa-solid fa-xmark"></i>' +
                        '</button>') : '';

                    var productUrl = '{{ route("productDetail", ":slug") }}'.replace(':slug', item.slug || item.product_id);
                    html += '<li class="product-box-contain" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                        '<div class="drop-cart">' +
                        '<a href="' + productUrl + '" class="drop-image">' +
                        '<img src="' + item.image + '" class="blur-up lazyloaded" alt="' + (item.title || '') + '">' +
                        '</a>' +
                        '<div class="drop-contain">' +
                        '<a href="' + productUrl + '">' +
                        '<h5>' + (item.title || '') + '</h5>' +
                        '</a>' +
                        '<h6><span>' + item.quantity + ' x</span> {{ __("messages.currency") }} ' + parseFloat(item.price).toFixed(2) + '</h6>' +
                        closeCustom +
                        '</div>' +
                        '</div>' +
                        '</li>';
                });
                $cartList.html(html);
            }

            // Update total
            var $priceBox = $cartSection.find('.price-box');
            if ($priceBox.length > 0) {
                $priceBox.find('h4').text('{{ __("messages.currency") }} ' + parseFloat(total).toFixed(2));
            }
        }

        /**
         * Render cart in footer
         */
        function renderCartFooter(items, total, itemsCount) {
            var $itemSection = $('.item-section');
            if ($itemSection.length === 0) return;

            // Update items count
            var $itemsCount = $itemSection.find('.cart-items-count');
            if ($itemsCount.length > 0) {
                if (itemsCount > 0) {
                    $itemsCount.text(itemsCount + ' {{ __("messages.Items") }}');
                } else {
                    $itemsCount.text('0 {{ __("messages.Items") }}');
                }
            }

            // Update items images
            var $itemsImage = $itemSection.find('.items-image');
            if ($itemsImage.length > 0) {
                if (items.length === 0) {
                    $itemsImage.html('<li class="text-center py-2"><p class="text-muted mb-0 small" style="color: rgba(255,255,255,0.8) !important;">{{ __("messages.Your cart is empty") }}</p></li>');
                } else {
                    var html = '';
                    var displayCount = Math.min(items.length, 5);
                    for (var i = 0; i < displayCount; i++) {
                        if (items[i] && items[i].image) {
                            html += '<li><img src="' + items[i].image + '" alt="' + (items[i].title || '') + '" style="width: 15px; height: 15px; object-fit: contain;"></li>';
                        }
                    }
                    if (items.length > 5) {
                        html += '<li style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background-color: #fff; border-radius: 50%; border: 1px solid var(--theme-color); color: var(--theme-color); font-weight: 600; font-size: 13px;">+' + (items.length - 5) + '</li>';
                    }
                    $itemsImage.html(html);
                }
            }

            // Update total button
            var $itemButton = $itemSection.find('.cart-total-price');
            if ($itemButton.length > 0) {
                $itemButton.text('{{ __("messages.currency") }} ' + parseFloat(total).toFixed(2));
            } else {
                // Fallback to .item-button if .cart-total-price doesn't exist
                var $fallbackButton = $itemSection.find('.item-button');
                if ($fallbackButton.length > 0) {
                    $fallbackButton.text('{{ __("messages.currency") }} ' + parseFloat(total).toFixed(2));
                }
            }
        }

        /**
         * Remove item from cart
         */
        function removeFromCart(productId, variantId, cartItemId) {
            if (isAuth) {
                // Remove from database
                if (cartItemId) {
                    $.ajax({
                        url: '/api/web/delete-cart/' + cartItemId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function(response) {
                            showNotification(response.message || '{{ __("messages.Product removed from cart successfully") }}', 'success');
                            updateCartDisplay();
                        },
                        error: function(xhr) {
                            var message = xhr.responseJSON?.message || '{{ __("messages.Error removing product from cart") }}';
                            showNotification(message, 'error');
                        }
                    });
                }
            } else {
                // Remove from localStorage
                removeFromLocalStorageCart(productId, variantId);
                showNotification('{{ __("messages.Product removed from cart successfully") }}', 'success');
                updateCartDisplay();
            }
        }

        /**
         * Show notification
         */
        function showNotification(message, type) {
            type = type || 'info';
            var icon = 'info';
            var title = '';

            switch(type) {
                case 'success':
                    icon = 'success';
                    title = '{{ __("messages.Success") }}';
                    break;
                case 'error':
                    icon = 'error';
                    title = '{{ __("messages.Error") }}';
                    break;
                default:
                    icon = 'info';
                    title = '{{ __("messages.Information") }}';
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: icon,
                    title: title,
                    text: message,
                    toast: true,
                    position: isRTL ? 'top-start' : 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                alert(message);
            }
        }

        /**
         * Handle add to cart button click
         */
        $(document).on('click', '.addcart-button', function(e) {
            e.preventDefault();
            var $button = $(this);
            var $cartBox = $button.closest('.add-to-cart-box');

            // Get product ID
            var productId = $button.data('product-id') ||
                           $button.closest('.product-box-3').find('[data-product-id]').data('product-id') ||
                           $button.closest('.product-box-contain').data('product-id');

            // Get variant ID
            var variantId = $button.data('variant-id') ||
                           $button.closest('.product-box-3').find('[data-variant-id]').data('variant-id') ||
                           null;

            // Get quantity from input
            var $qtyInput = $cartBox.find('.qty-input');
            var quantity = parseInt($qtyInput.val()) || 1;

            // Get product condition
            var condition = $button.data('condition') || 'new';

            // Get rent data if product is rent
            var rentData = {};
            if (condition === 'rent') {
                // Check if we're in modal or product detail page
                var $rentFields = $('#modal-rent-fields');
                if ($rentFields.length && $rentFields.is(':visible')) {
                    // Modal - get data from modal fields
                    rentData.start_date = $('#modal-start-date').val();
                    rentData.count_day = $('#modal-count-day').val();
                    rentData.note = $('#modal-note').val() || null;
                } else {
                    // Check if we're on product detail page
                    var $productRentFields = $('#product-rent-fields');
                    if ($productRentFields.length && $productRentFields.is(':visible') && $button.data('model-custom') == 'page') {
                        // Product detail page
                        rentData.start_date = $('#product-start-date').val();
                        rentData.count_day = $('#product-count-day').val();
                        rentData.note = $('#product-note').val() || null;
                    } else {
                        // Product is rent but fields are not visible (shop page or related products)
                        // Open modal to get rent data
                        if (productId) {
                            // First, try to find view product button in the same product box
                            var $productBox = $button.closest('.product-box-3');
                            var $viewBtn = $productBox.find('.view-product-btn[data-product-id="' + productId + '"]');

                            // If not found in same box, search globally
                            if ($viewBtn.length === 0) {
                                $viewBtn = $('.view-product-btn[data-product-id="' + productId + '"]');
                            }

                            if ($viewBtn.length > 0) {
                                // Trigger click on view button to open modal
                                $viewBtn.first().trigger('click');
                                // Show notification after a short delay to ensure modal is opening
                                setTimeout(function() {
                                    showNotification('{{ __("messages.Please fill in the rental period in the modal") }}', 'info');
                                }, 500);
                                return;
                            } else {
                                // If view button not found, try to open modal directly
                                var modalElement = document.getElementById('view');
                                if (modalElement) {
                                    // Show loading first
                                    $('#modal-loading').show();
                                    $('#modal-product-content').hide();

                                    // Get or create modal instance and open it first
                                    var modal = bootstrap.Modal.getInstance(modalElement);
                                    if (!modal) {
                                        modal = new bootstrap.Modal(modalElement);
                                    }
                                    // Open modal immediately
                                    modal.show();

                                    // Load product data
                                    $.ajax({
                                        url: '/api/web/product-modal/' + productId,
                                        type: 'GET',
                                        dataType: 'json',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        },
                                        success: function(response) {
                                            if (response.status === 200 && response.data) {
                                                var product = response.data;
                                                // Render product in modal (this function already exists)
                                                if (typeof renderProductModal === 'function') {
                                                    renderProductModal(product);
                                                }
                                                setTimeout(function() {
                                                    showNotification('{{ __("messages.Please fill in the rental period in the modal") }}', 'info');
                                                }, 500);
                                            } else if (response.data) {
                                                // Fallback: check if data exists even without status
                                                var product = response.data;
                                                if (typeof renderProductModal === 'function') {
                                                    renderProductModal(product);
                                                }
                                                setTimeout(function() {
                                                    showNotification('{{ __("messages.Please fill in the rental period in the modal") }}', 'info');
                                                }, 500);
                                            } else {
                                                showNotification('{{ __("messages.Error loading product") }}', 'error');
                                            }
                                        },
                                        error: function() {
                                            showNotification('{{ __("messages.Error loading product") }}', 'error');
                                        }
                                    });
                                    return;
                                } else {
                                    showNotification('{{ __("messages.Modal not found") }}', 'error');
                                    return;
                                }
                            }
                        }
                        // If we can't open modal, show error
                        showNotification('{{ __("messages.Please fill in the rental period") }}', 'error');
                        return;
                    }
                }
            }

            if (!productId) {
                showNotification('{{ __("messages.Product ID not found") }}', 'error');
                return;
            }

            // Add to cart
            addToCart(productId, variantId, quantity, condition, rentData);

            // Reset quantity input
            $qtyInput.val('0');
            $cartBox.find('.cart_qty').removeClass('open');
        });

        /**
         * Handle remove from cart button click
         */
        $(document).on('click', '.close-cart-item', function(e) {
            e.preventDefault();
            var $button = $(this);
            var productId = $button.data('product-id');
            var variantId = $button.data('variant-id') || null;
            var cartItemId = $button.closest('li').data('cart-item-id');

            if (productId) {
                removeFromCart(productId, variantId, cartItemId);
            }
        });

        /**
         * Initialize cart system on page load
         */
        $(document).ready(function() {
            // Load cart display
            updateCartDisplay();

            // Sync cart after login
            if (isAuth) {
                syncCartAfterLogin();
            }
        });

        /**
         * Listen for login event
         */
        $(document).on('userLoggedIn', function() {
            isAuth = true;
            syncCartAfterLogin();
        });

        /**
         * Check if user just logged in
         */
        $(document).ready(function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('logged') === 'success' && isAuth) {
                setTimeout(function() {
                    syncCartAfterLogin();
                    updateCartDisplay();
                }, 500);
            }
        });
    })();
</script>

@if(request()->routeIs('shoppingCart'))
{{-- Shopping Cart Page JavaScript --}}
<script>
    (function() {
        'use strict';

        var $ = jQuery;
        var isAuth = {{ auth('user')->check() ? 'true' : 'false' }};
        var cartStorageKey = 'cart_products';

        /**
         * Get cart from localStorage
         */
        function getCartFromStorage() {
            try {
                var cart = localStorage.getItem(cartStorageKey);
                return cart ? JSON.parse(cart) : [];
            } catch (e) {
                return [];
            }
        }

        /**
         * Save cart to localStorage
         */
        function saveCartToStorage(cartItems) {
            try {
                localStorage.setItem(cartStorageKey, JSON.stringify(cartItems));
            } catch (e) {
                console.error('Error saving cart to localStorage:', e);
            }
        }

        /**
         * Update cart item quantity in localStorage
         */
        function updateLocalStorageCartItem(productId, variantId, quantity) {
            var cart = getCartFromStorage();
            var item = cart.find(function(item) {
                return item.product_id == productId &&
                       (variantId ? item.variant_id == variantId : !item.variant_id);
            });

            if (item) {
                if (quantity <= 0) {
                    // Remove item
                    cart = cart.filter(function(i) {
                        return !(i.product_id == productId &&
                                (variantId ? i.variant_id == variantId : !i.variant_id));
                    });
                } else {
                    item.quantity = quantity;
                }
                saveCartToStorage(cart);
            }
        }

        /**
         * Load and render cart items
         */
        /**
         * Load cart items and separate them into Buy and Rent
         */
        function loadCartItems() {
            var $buyContainer = $('#cart-buy-items-container');
            var $rentContainer = $('#cart-rent-items-container');

            // Check if we're on shopping cart page
            if ($buyContainer.length === 0 && $rentContainer.length === 0) {
                // Fallback to old container if exists
                var $container = $('#cart-items-container');
                if ($container.length === 0) return;
                $container.html('<tr><td colspan="5" class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __("messages.Loading") }}...</span></div></td></tr>');
            } else {
                // Show loading in both containers
                if ($buyContainer.length > 0) {
                    $buyContainer.html('<tr><td colspan="5" class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __("messages.Loading") }}...</span></div></td></tr>');
                }
                if ($rentContainer.length > 0) {
                    $rentContainer.html('<tr><td colspan="6" class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">{{ __("messages.Loading") }}...</span></div></td></tr>');
                }
            }

            if (isAuth) {
                // Load from database
                $.ajax({
                    url: '/api/web/cart/items',
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        if (response.data && response.data.items) {
                            // Separate items into buy and rent
                            var buyItems = response.data.items.filter(function(item) {
                                return item.department_id == 2;
                            });
                            var rentItems = response.data.items.filter(function(item) {
                                return item.department_id == 1;
                            });

                            renderCartItems(buyItems, rentItems, response.data.total);
                        } else {
                            renderEmptyCart();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading cart items:', xhr);
                        renderEmptyCart();
                    }
                });
            } else {
                // Load from localStorage
                var cart = getCartFromStorage();
                if (cart.length === 0) {
                    renderEmptyCart();
                    return;
                }

                // Fetch products by IDs
                var productIds = cart.map(function(item) { return item.product_id; });
                $.ajax({
                    url: '/api/web/wishlist/products-by-ids',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    data: {
                        product_ids: productIds
                    },
                    success: function(response) {
                        if (response.data && response.data.length > 0) {
                            // Map cart items with product details
                            var items = cart.map(function(cartItem) {
                                var product = response.data.find(function(p) {
                                    return p.id == cartItem.product_id;
                                });
                                if (product) {
                                    var itemPrice = product.discount_price && product.discount_percentage > 0
                                        ? product.discount_price
                                        : product.price;

                                    return {
                                        id: cartItem.product_id,
                                        product_id: cartItem.product_id,
                                        variant_id: cartItem.variant_id,
                                        department_id: product.department_id,
                                        title: product.title,
                                        slug: product.slug,
                                        image: product.image,
                                        quantity: cartItem.quantity || 1,
                                        price: itemPrice,
                                        total: itemPrice * (cartItem.quantity || 1),
                                        unit: product.unit || '',
                                        category: product.category ? product.category.name : ''
                                    };
                                }
                                return null;
                            }).filter(function(item) { return item !== null; });

                            // Separate items into buy and rent
                            var buyItems = items.filter(function(item) {
                                return item.department_id == 2;
                            });
                            var rentItems = items.filter(function(item) {
                                return item.department_id == 1;
                            });

                            // Add rent data from localStorage
                            rentItems = rentItems.map(function(item) {
                                var cartItem = cart.find(function(c) {
                                    return c.product_id == item.product_id && c.type === 'rent';
                                });
                                if (cartItem) {
                                    item.start_date = cartItem.start_date;
                                    item.count_day = cartItem.count_day;
                                    item.note = cartItem.note;
                                    item.total = item.price * (cartItem.count_day || 1);
                                }
                                return item;
                            });

                            var total = items.reduce(function(sum, item) { return sum + (item.total || 0); }, 0);
                            renderCartItems(buyItems, rentItems, total);
                        } else {
                            renderEmptyCart();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading cart products:', xhr);
                        renderEmptyCart();
                    }
                });
            }
        }

        /**
         * Render cart items in tables (Buy and Rent separated)
         * @param {Array} buyItems - Buy items array
         * @param {Array} rentItems - Rent items array
         * @param {number} total - Total amount
         */
        function renderCartItems(buyItems, rentItems, total) {
            buyItems = buyItems || [];
            rentItems = rentItems || [];

            // Check if we're on shopping cart page (new layout)
            var $buyContainer = $('#cart-buy-items-container');
            var $rentContainer = $('#cart-rent-items-container');

            if ($buyContainer.length > 0 || $rentContainer.length > 0) {
                // New layout: separate tables
                renderBuyItems(buyItems);
                renderRentItems(rentItems);
                updateCartSummary(total);
                return;
            }

            // Fallback: old layout (single table)
            var $container = $('#cart-items-container');
            if ($container.length === 0) return;

            var allItems = buyItems.concat(rentItems);
            if (allItems.length === 0) {
                renderEmptyCart();
                return;
            }

            var html = '';
            items.forEach(function(item) {
                var productUrl = '{{ route("productDetail", ":slug") }}'.replace(':slug', item.slug || item.product_id);
                var priceHtml = '';
                var savingHtml = '';
                var displayPrice = item.price; // Use the price from API (already includes discount if available)

                // Calculate price display
                if (item.discount_price && item.discount_percentage > 0) {
                    priceHtml = '<span class="theme-color">{{ __("messages.currency") }} ' + parseFloat(item.discount_price).toFixed(2) + '</span>' +
                                '<del class="text-content">{{ __("messages.currency") }} ' + parseFloat(item.price_before_discount || item.price).toFixed(2) + '</del>';
                    var saving = (item.price_before_discount || item.price) - item.discount_price;
                    savingHtml = '<h6 class="theme-color">{{ __("messages.You Save") }} : {{ __("messages.currency") }} ' + parseFloat(saving).toFixed(2) + '</h6>';
                    displayPrice = item.discount_price;
                } else {
                    priceHtml = '<span>{{ __("messages.currency") }} ' + parseFloat(item.price).toFixed(2) + '</span>';
                    displayPrice = item.price;
                }

                html += '<tr class="product-box-contain" data-cart-item-id="' + (item.id || item.product_id) + '" data-product-id="' + item.product_id + '" data-variant-id="' + (item.variant_id || '') + '" data-price="' + displayPrice + '">' +
                    '<td class="product-detail">' +
                    '<div class="product border-0">' +
                    '<a href="' + productUrl + '" class="product-image">' +
                    '<img src="' + item.image + '" class="img-fluid blur-up lazyload" alt="' + (item.title || '') + '">' +
                    '</a>' +
                    '<div class="product-detail">' +
                    '<ul>' +
                    '<li class="name">' +
                    '<a href="' + productUrl + '">' + (item.title || '') + '</a>' +
                    '</li>' +
                    '<li class="text-content"><span class="text-title">{{ __("messages.Items") }}:</span> ' + (item.category || '') + '</li>';

                if (item.unit) {
                    html += '<li class="text-content"><span class="text-title">{{ __("messages.Quantity") }}</span> - ' + item.unit + '</li>';
                }

                html += '<li>' +
                    '<h5 class="text-content d-inline-block">{{ __("messages.Price") }} :</h5>' +
                    priceHtml +
                    '</li>';

                if (savingHtml) {
                    html += '<li>' +
                        '<h5 class="saving theme-color">' + savingHtml.replace('<h6', '<h5').replace('</h6>', '</h5>') + '</h5>' +
                        '</li>';
                }

                html += '<li class="quantity-price-box">' +
                    '<div class="cart_qty">' +
                    '<div class="input-group">' +
                    '<button type="button" class="btn qty-left-minus" data-type="minus" data-field="" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                    '<i class="fa fa-minus ms-0" aria-hidden="true"></i>' +
                    '</button>' +
                    '<input class="form-control input-number qty-input" type="text" name="quantity" value="' + item.quantity + '" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                    '<button type="button" class="btn qty-right-plus" data-type="plus" data-field="" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                    '<i class="fa fa-plus ms-0" aria-hidden="true"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '<li>' +
                    '<h5>{{ __("messages.Total") }}: <span class="item-total">{{ __("messages.currency") }} ' + parseFloat(item.total).toFixed(2) + '</span></h5>' +
                    '</li>' +
                    '</ul>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="price">' +
                    '<h4 class="table-title text-content">{{ __("messages.Price") }}</h4>' +
                    '<h5>' + priceHtml + '</h5>';

                if (savingHtml) {
                    html += savingHtml;
                }

                html += '</td>' +
                    '<td class="quantity">' +
                    '<h4 class="table-title text-content">{{ __("messages.Qty") }}</h4>' +
                    '<div class="quantity-price">' +
                    '<div class="cart_qty">' +
                    '<div class="input-group">' +
                    '<button type="button" class="btn qty-left-minus" data-type="minus" data-field="" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                    '<i class="fa fa-minus ms-0" aria-hidden="true"></i>' +
                    '</button>' +
                    '<input class="form-control input-number qty-input" type="text" name="quantity" value="' + item.quantity + '" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                    '<button type="button" class="btn qty-right-plus" data-type="plus" data-field="" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                    '<i class="fa fa-plus ms-0" aria-hidden="true"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="subtotal">' +
                    '<h4 class="table-title text-content">{{ __("messages.Total") }}</h4>' +
                    '<h5 class="item-total">{{ __("messages.currency") }} ' + parseFloat(item.total).toFixed(2) + '</h5>' +
                    '</td>' +
                    '<td class="save-remove">' +
                    '<h4 class="table-title text-content">{{ __("messages.Action") }}</h4>' +
                    '<a class="remove close-cart-item-btn" href="javascript:void(0)" data-cart-item-id="' + (item.id || item.product_id) + '" data-product-id="' + item.product_id + '" data-variant-id="' + (item.variant_id || '') + '">' +
                    '{{ __("messages.Remove") }}' +
                    '</a>' +
                    '</td>' +
                    '</tr>';
            });

            $container.html(html);
            updateCartSummary(total);
        }

        /**
         * Render buy items in buy table
         */
        function renderBuyItems(items) {
            var $container = $('#cart-buy-items-container');
            var $empty = $('#cart-buy-empty');

            if (!$container.length) return;

            if (items.length === 0) {
                $container.html('');
                $empty.show();
                return;
            }

            $empty.hide();

            var html = '';
            items.forEach(function(item) {
                html += renderBuyItemRow(item);
            });

            $container.html(html);
        }

        /**
         * Render rent items in rent table
         */
        function renderRentItems(items) {
            var $container = $('#cart-rent-items-container');
            var $empty = $('#cart-rent-empty');

            if (!$container.length) return;

            if (items.length === 0) {
                $container.html('');
                $empty.show();
                return;
            }

            $empty.hide();

            var html = '';
            items.forEach(function(item) {
                html += renderRentItemRow(item);
            });

            $container.html(html);
        }

        /**
         * Render a single buy item row
         */
        function renderBuyItemRow(item) {
            var productUrl = '{{ route("productDetail", ":slug") }}'.replace(':slug', item.slug || item.product_id);
            var priceHtml = '';
            var savingHtml = '';
            var displayPrice = item.price;

            if (item.discount_price && item.discount_percentage > 0) {
                priceHtml = '<span class="theme-color">{{ __("messages.currency") }} ' + parseFloat(item.discount_price).toFixed(2) + '</span>' +
                            '<del class="text-content">{{ __("messages.currency") }} ' + parseFloat(item.price_before_discount || item.price).toFixed(2) + '</del>';
                var saving = (item.price_before_discount || item.price) - item.discount_price;
                savingHtml = '<h6 class="theme-color">{{ __("messages.You Save") }} : {{ __("messages.currency") }} ' + parseFloat(saving).toFixed(2) + '</h6>';
                displayPrice = item.discount_price;
            } else {
                priceHtml = '<span>{{ __("messages.currency") }} ' + parseFloat(item.price).toFixed(2) + '</span>';
            }

            var total = item.price * item.quantity;
            if (item.discount_price) {
                total = item.discount_price * item.quantity;
            }

            return '<tr class="product-box-contain" data-cart-item-id="' + (item.id || item.product_id) + '" data-product-id="' + item.product_id + '" data-variant-id="' + (item.variant_id || '') + '" data-price="' + displayPrice + '">' +
                '<td class="product-detail">' +
                '<div class="product border-0">' +
                '<a href="' + productUrl + '" class="product-image">' +
                '<img src="' + item.image + '" class="img-fluid blur-up lazyload" alt="' + (item.title || '') + '">' +
                '</a>' +
                '<div class="product-detail">' +
                '<ul>' +
                '<li class="name"><a href="' + productUrl + '">' + (item.title || '') + '</a></li>' +
                '<li class="text-content"><span class="text-title">{{ __("messages.Items") }}:</span> ' + (item.category || '') + '</li>' +
                (item.unit ? '<li class="text-content"><span class="text-title">{{ __("messages.Quantity") }}</span> - ' + item.unit + '</li>' : '') +
                '<li><h5 class="text-content d-inline-block">{{ __("messages.Price") }} :</h5>' + priceHtml + '</li>' +
                (savingHtml ? '<li><h5 class="saving theme-color">' + savingHtml.replace('<h6', '<h5').replace('</h6>', '</h5>') + '</h5></li>' : '') +
                '</ul>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="price">' +
                '<h4 class="table-title text-content">{{ __("messages.Price") }}</h4>' +
                '<h5>' + priceHtml + '</h5>' +
                (savingHtml ? savingHtml : '') +
                '</td>' +
                '<td class="quantity">' +
                '<h4 class="table-title text-content">{{ __("messages.Qty") }}</h4>' +
                '<div class="quantity-price">' +
                '<div class="cart_qty">' +
                '<div class="input-group">' +
                '<button type="button" class="btn qty-left-minus" data-type="minus" data-field="" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                '<i class="fa fa-minus ms-0" aria-hidden="true"></i>' +
                '</button>' +
                '<input class="form-control input-number qty-input" type="text" name="quantity" value="' + item.quantity + '" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                '<button type="button" class="btn qty-right-plus" data-type="plus" data-field="" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                '<i class="fa fa-plus ms-0" aria-hidden="true"></i>' +
                '</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="subtotal">' +
                '<h4 class="table-title text-content">{{ __("messages.Total") }}</h4>' +
                '<h5 class="item-total">{{ __("messages.currency") }} ' + parseFloat(total).toFixed(2) + '</h5>' +
                '</td>' +
                '<td class="save-remove">' +
                '<h4 class="table-title text-content">{{ __("messages.Action") }}</h4>' +
                '<a class="remove close-cart-item-btn" href="javascript:void(0)" data-cart-item-id="' + (item.id || item.product_id) + '" data-product-id="' + item.product_id + '" data-variant-id="' + (item.variant_id || '') + '">' +
                '{{ __("messages.Remove") }}' +
                '</a>' +
                '</td>' +
                '</tr>';
        }

        /**
         * Render a single rent item row
         */
        function renderRentItemRow(item) {
            var productUrl = '{{ route("productDetail", ":slug") }}'.replace(':slug', item.slug || item.product_id);
            var priceHtml = '';
            var savingHtml = '';
            var displayPrice = item.price;

            if (item.discount_price && item.discount_percentage > 0) {
                priceHtml = '<span class="theme-color">{{ __("messages.currency") }} ' + parseFloat(item.discount_price).toFixed(2) + '</span>' +
                            '<del class="text-content">{{ __("messages.currency") }} ' + parseFloat(item.price_before_discount || item.price).toFixed(2) + '</del>';
                var saving = (item.price_before_discount || item.price) - item.discount_price;
                savingHtml = '<h6 class="theme-color">{{ __("messages.You Save") }} : {{ __("messages.currency") }} ' + parseFloat(saving).toFixed(2) + '</h6>';
                displayPrice = item.discount_price;
            } else {
                priceHtml = '<span>{{ __("messages.currency") }} ' + parseFloat(item.price).toFixed(2) + '</span>';
            }

            var countDay = item.count_day || 1;
            var total = item.price * countDay;
            if (item.discount_price) {
                total = item.discount_price * countDay;
            }

            var startDate = item.start_date || '';
            var note = item.note || '';

            return '<tr class="product-box-contain" data-cart-item-id="' + (item.id || item.product_id) + '" data-product-id="' + item.product_id + '" data-variant-id="' + (item.variant_id || '') + '" data-price="' + displayPrice + '">' +
                '<td class="product-detail">' +
                '<div class="product border-0">' +
                '<a href="' + productUrl + '" class="product-image">' +
                '<img src="' + item.image + '" class="img-fluid blur-up lazyload" alt="' + (item.title || '') + '">' +
                '</a>' +
                '<div class="product-detail">' +
                '<ul>' +
                '<li class="name"><a href="' + productUrl + '">' + (item.title || '') + '</a></li>' +
                '<li class="text-content"><span class="text-title">{{ __("messages.Items") }}:</span> ' + (item.category || '') + '</li>' +
                '<li><h5 class="text-content d-inline-block">{{ __("messages.Price") }} :</h5>' + priceHtml + '</li>' +
                (savingHtml ? '<li><h5 class="saving theme-color">' + savingHtml.replace('<h6', '<h5').replace('</h6>', '</h5>') + '</h5></li>' : '') +
                (note ? '<li class="text-content"><span class="text-title">{{ __("messages.Note") }}:</span> ' + note + '</li>' : '') +
                '</ul>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td class="price">' +
                '<h4 class="table-title text-content">{{ __("messages.Price") }}</h4>' +
                '<h5>' + priceHtml + '</h5>' +
                (savingHtml ? savingHtml : '') +
                '</td>' +
                '<td class="start-date">' +
                '<h4 class="table-title text-content">{{ __("messages.Start Date") }}</h4>' +
                '<input type="date" class="form-control rent-start-date" value="' + startDate + '" data-cart-item-id="' + (item.id || item.product_id) + '" min="' + new Date().toISOString().split('T')[0] + '">' +
                '</td>' +
                '<td class="count-day">' +
                '<h4 class="table-title text-content">{{ __("messages.Count Days") }}</h4>' +
                '<input type="number" class="form-control rent-count-day" value="' + countDay + '" min="1" data-cart-item-id="' + (item.id || item.product_id) + '">' +
                '</td>' +
                '<td class="subtotal">' +
                '<h4 class="table-title text-content">{{ __("messages.Total") }}</h4>' +
                '<h5 class="item-total">{{ __("messages.currency") }} ' + parseFloat(total).toFixed(2) + '</h5>' +
                '</td>' +
                '<td class="save-remove">' +
                '<h4 class="table-title text-content">{{ __("messages.Action") }}</h4>' +
                '<a class="remove close-cart-item-btn" href="javascript:void(0)" data-cart-item-id="' + (item.id || item.product_id) + '" data-product-id="' + item.product_id + '" data-variant-id="' + (item.variant_id || '') + '">' +
                '{{ __("messages.Remove") }}' +
                '</a>' +
                '</td>' +
                '</tr>';
        }

        /**
         * Render empty cart message
         */
        function renderEmptyCart() {
            var $container = $('#cart-items-container');
            $container.html(
                '<tr>' +
                '<td colspan="5" class="text-center py-5">' +
                '<h4>{{ __("messages.Your cart is empty") }}</h4>' +
                '<p class="text-muted">{{ __("messages.Add products to your cart to see them here") }}</p>' +
                '<a href="{{ route("web.home") }}" class="btn btn-primary mt-3">{{ __("messages.Return To Shopping") }}</a>' +
                '</td>' +
                '</tr>'
            );
            updateCartSummary(0);
        }

        /**
         * Update cart summary in shopping-cart page
         */
        function updateCartSummary(total) {
            total = parseFloat(total) || 0;
            var currencyText = '{{ __("messages.currency") }} ' + total.toFixed(2);

            // Update subtotal - try all possible selectors
            $('#cart-subtotal').text(currencyText);
            $('.summery-box .cart-subtotal').text(currencyText);
            $('.cart-section .cart-subtotal').text(currencyText);
            $('.cart-subtotal').text(currencyText);

            // Update total - try all possible selectors
            $('#cart-total').text(currencyText);
            $('.summery-box .cart-total').text(currencyText);
            $('.cart-section .cart-total').text(currencyText);
            $('.cart-total').text(currencyText);

            // Also update header and footer cart totals
            if (typeof updateCartTotalsEverywhere === 'function') {
                updateCartTotalsEverywhere(total);
            }
        }

        /**
         * Update cart totals in header and footer
         */
        function updateCartTotalsEverywhere(total) {
            // Update header cart total
            var $headerPriceBox = $('.cart-section-custom .price-box h4');
            if ($headerPriceBox.length > 0) {
                $headerPriceBox.text('{{ __("messages.currency") }} ' + parseFloat(total).toFixed(2));
            }

            // Update footer cart total
            var $footerItemButton = $('.item-section .cart-total-price, .item-section .item-button');
            if ($footerItemButton.length > 0) {
                $footerItemButton.text('{{ __("messages.currency") }} ' + parseFloat(total).toFixed(2));
            }

            // Also trigger updateCartDisplay if available (from main cart system)
            if (typeof window.updateCartDisplay === 'function') {
                window.updateCartDisplay();
            }
        }

        /**
         * Update cart item quantity
         */
        function updateCartItemQuantity(cartItemId, quantity, productId, variantId) {
            if (isAuth) {
                // Update in database
                $.ajax({
                    url: '/api/web/cart/update-quantity/' + cartItemId,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {
                        quantity: quantity
                    },
                    success: function(response) {
                        if (quantity <= 0) {
                            // Item was deleted, update total immediately
                            updateCartSummary(0);
                            // Reload cart
                            loadCartItems();
                            // Update cart display in header and footer
                            if (typeof updateCartTotalsEverywhere === 'function') {
                                updateCartTotalsEverywhere(0);
                            }
                            if (typeof window.updateCartDisplay === 'function') {
                                window.updateCartDisplay();
                            }
                        } else {
                            // Update item total
                            var $row = $('tr[data-cart-item-id="' + cartItemId + '"]');
                            if ($row.length === 0) {
                                // Try to find by product ID
                                $row = $('tr[data-product-id="' + productId + '"]');
                            }

                            var price = parseFloat($row.data('price') || response.data.price || 0);
                            var newTotal = price * quantity;
                            $row.find('.item-total').text('{{ __("messages.currency") }} ' + parseFloat(newTotal).toFixed(2));

                            // Update quantity input value
                            $row.find('.qty-input').val(quantity);

                            // Recalculate and update summary from all rows
                            var total = 0;
                            $('tr.product-box-contain').each(function() {
                                var $row = $(this);
                                var rowPrice = parseFloat($row.data('price') || 0);
                                // Get quantity from input - try multiple ways
                                var $qtyInput = $row.find('.qty-input').first();
                                var rowQty = parseInt($qtyInput.val() || $qtyInput.attr('value') || 0);
                                if (rowPrice > 0 && rowQty > 0) {
                                    total += rowPrice * rowQty;
                                }
                            });

                            // Force update cart summary immediately
                            updateCartSummary(total);

                            // Update cart display in header and footer with new total
                            updateCartTotalsEverywhere(total);

                            // Also trigger full cart display update if available
                            if (typeof window.updateCartDisplay === 'function') {
                                window.updateCartDisplay();
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating cart item:', xhr);
                        var message = xhr.responseJSON?.message || '{{ __("messages.Error updating cart") }}';
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __("messages.Error") }}',
                                text: message,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    }
                });
            } else {
                // Update in localStorage
                updateLocalStorageCartItem(productId, variantId, quantity);

                if (quantity <= 0) {
                    // Update total immediately
                    updateCartSummary(0);
                    // Reload cart
                    loadCartItems();
                } else {
                    // Update item total
                    var $row = $('tr[data-product-id="' + productId + '"]');
                    var price = parseFloat($row.data('price') || 0);
                    var newTotal = price * quantity;
                    $row.find('.item-total').text('{{ __("messages.currency") }} ' + parseFloat(newTotal).toFixed(2));

                    // Update quantity input value
                    $row.find('.qty-input').val(quantity);

                    // Recalculate and update summary from all rows
                    var total = 0;
                    $('tr.product-box-contain').each(function() {
                        var $row = $(this);
                        var rowPrice = parseFloat($row.data('price') || 0);
                        // Get quantity from input - try multiple ways
                        var $qtyInput = $row.find('.qty-input').first();
                        var rowQty = parseInt($qtyInput.val() || $qtyInput.attr('value') || 0);
                        if (rowPrice > 0 && rowQty > 0) {
                            total += rowPrice * rowQty;
                        }
                    });

                    // Force update cart summary immediately
                    updateCartSummary(total);

                    // Update cart display in header and footer
                    updateCartTotalsEverywhere(total);

                    // Also trigger full cart display update if available
                    if (typeof window.updateCartDisplay === 'function') {
                        window.updateCartDisplay();
                    }
                }

                // Update cart display in header and footer
                if (typeof updateCartDisplay === 'function') {
                    updateCartDisplay();
                }
            }
        }

        /**
         * Handle quantity buttons
         */
        $(document).on('click', '.qty-left-minus, .qty-right-plus', function(e) {
            e.preventDefault();
            var $button = $(this);
            var $row = $button.closest('tr');
            var $input = $row.find('.qty-input').first();
            var cartItemId = $button.data('cart-item-id') || $input.data('cart-item-id');
            var productId = $row.data('product-id');
            var variantId = $row.data('variant-id') || null;
            var currentQty = parseInt($input.val()) || 0;
            var type = $button.data('type');

            if (type === 'minus') {
                currentQty = Math.max(0, currentQty - 1);
            } else {
                currentQty = currentQty + 1;
            }

            $input.val(currentQty);
            updateCartItemQuantity(cartItemId, currentQty, productId, variantId);
        });

        /**
         * Handle quantity input change
         */
        $(document).on('change blur', '.qty-input', function() {
            var $input = $(this);
            var $row = $input.closest('tr');
            var cartItemId = $input.data('cart-item-id') || $row.data('cart-item-id');
            var productId = $row.data('product-id');
            var variantId = $row.data('variant-id') || null;
            var quantity = parseInt($input.val()) || 0;

            if (quantity < 0) {
                quantity = 0;
                $input.val(0);
            }

            updateCartItemQuantity(cartItemId, quantity, productId, variantId);
        });

        /**
         * Handle remove button
         */
        /**
         * Handle rent fields update (start_date and count_day)
         */
        $(document).on('change blur', '.rent-start-date, .rent-count-day', function() {
            var $input = $(this);
            var cartItemId = $input.data('cart-item-id');
            var $row = $('tr[data-cart-item-id="' + cartItemId + '"]');

            if (!$row.length || !cartItemId) return;

            var startDate = $row.find('.rent-start-date').val();
            var countDay = parseInt($row.find('.rent-count-day').val()) || 1;

            if (!startDate || countDay < 1) {
                return;
            }

            if (isAuth) {
                // Update in database
                $.ajax({
                    url: '/api/web/cart/update-quantity/' + cartItemId,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {
                        start_date: startDate,
                        count_day: countDay
                    },
                    success: function(response) {
                        if (response.data) {
                            // Update item total
                            var price = parseFloat($row.data('price') || response.data.price || 0);
                            var newTotal = price * countDay;
                            $row.find('.item-total').text('{{ __("messages.currency") }} ' + parseFloat(newTotal).toFixed(2));

                            // Recalculate and update summary
                            loadCartItems();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating rent item:', xhr);
                        var message = xhr.responseJSON?.message || '{{ __("messages.Error updating cart") }}';
                        showNotification(message, 'error');
                    }
                });
            } else {
                // Update in localStorage
                var productId = $row.data('product-id');
                var variantId = $row.data('variant-id');
                var cart = getCartFromStorage();
                var cartItem = cart.find(function(item) {
                    return item.product_id == productId &&
                           (variantId ? item.variant_id == variantId : !item.variant_id) &&
                           item.type === 'rent';
                });

                if (cartItem) {
                    cartItem.start_date = startDate;
                    cartItem.count_day = countDay;
                    saveCartToStorage(cart);

                    // Update item total
                    var price = parseFloat($row.data('price') || 0);
                    var newTotal = price * countDay;
                    $row.find('.item-total').text('{{ __("messages.currency") }} ' + parseFloat(newTotal).toFixed(2));
                    // Recalculate and update summary
                    loadCartItems();
                }
            }
        });

        $(document).on('click', '.close-cart-item-btn', function(e) {
            e.preventDefault();
            var $button = $(this);
            var cartItemId = $button.data('cart-item-id');
            var productId = $button.data('product-id');
            var variantId = $button.data('variant-id') || null;

            updateCartItemQuantity(cartItemId, 0, productId, variantId);
        });

        /**
         * Initialize on page load
         */
        $(document).ready(function() {
            loadCartItems();
        });
    })();
</script>
@endif

</body>

</html>

