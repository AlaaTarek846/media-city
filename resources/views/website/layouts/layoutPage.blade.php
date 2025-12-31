
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
<div class="fullpage-loader">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>
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

            // Set add to cart button
            $('#modal-add-to-cart-btn')
                .attr('data-product-id', product.id)
                .attr('data-variant-id', product.variant_id || '')
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
                data: {
                    product_id: productId
                },
                success: function(response) {
                    $button.prop('disabled', false);
                    $button.html(originalHtml);

                    if (response.status === 'already_exists') {
                        showNotification(response.message || '{{ __("messages.Product already in wishlist") }}', 'info');
                        updateHeartIcon($button, true);
                    } else if (response.status === 'added') {
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
         * Render wishlist products
         */
        function renderWishlistProducts(products) {
            var html = '';

            products.forEach(function(product) {
                var productUrl = '{{ route("productDetail", ":slug") }}'.replace(':slug', product.slug || product.id);
                var priceHtml = '';

                if (product.discount_price && product.discount_percentage > 0) {
                    priceHtml = '<span class="theme-color">{{ __("messages.currency") }} ' + parseFloat(product.discount_price).toFixed(2) + '</span>' +
                                '<del>{{ __("messages.currency") }} ' + parseFloat(product.price_before_discount).toFixed(2) + '</del>';
                } else {
                    priceHtml = '<span class="theme-color">{{ __("messages.currency") }} ' + parseFloat(product.price).toFixed(2) + '</span>';
                }

                html += '<div class="col-xxl-2 col-lg-3 col-md-4 col-6 product-box-contain" data-product-id="' + product.id + '">' +
                    '<div class="product-box-3 h-100">' +
                    '<div class="product-header">' +
                    '<div class="product-image">' +
                    '<a href="' + productUrl + '">' +
                    '<img src="' + product.image + '" class="img-fluid blur-up lazyload" alt="' + (product.title || '') + '">' +
                    '</a>' +
                    '<div class="product-header-top">' +
                    '<button class="btn wishlist-button close_button" data-product-id="' + product.id + '">' +
                    '<i data-feather="x"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="product-footer">' +
                    '<div class="product-detail">' +
                    '<span class="span-name">' + (product.category ? product.category.name : '') + '</span>' +
                    '<a href="' + productUrl + '">' +
                    '<h5 class="name">' + (product.title || '') + '</h5>' +
                    '</a>';

                if (product.unit) {
                    html += '<h6 class="unit mt-1">' + product.unit + '</h6>';
                }

                html += '<h5 class="price">' + priceHtml + '</h5>' +
                    '<div class="add-to-cart-box bg-white mt-2">' +
                    '<button class="btn btn-add-cart addcart-button" data-product-id="' + product.id + '" data-variant-id="' + (product.variant_id || '') + '">{{ __("messages.Add") }}' +
                    '<span class="add-icon bg-light-gray">' +
                    '<i class="fa-solid fa-plus"></i>' +
                    '</span>' +
                    '</button>' +
                    '<div class="cart_qty qty-box">' +
                    '<div class="input-group bg-white">' +
                    '<button type="button" class="qty-left-minus bg-gray" data-type="minus" data-field="">' +
                    '<i class="fa fa-minus" aria-hidden="true"></i>' +
                    '</button>' +
                    '<input class="form-control input-number qty-input" type="text" name="quantity" value="0">' +
                    '<button type="button" class="qty-right-plus bg-gray" data-type="plus" data-field="">' +
                    '<i class="fa fa-plus" aria-hidden="true"></i>' +
                    '</button>' +
                    '</div>' +
                    '</div>' +
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
                    success: function(response) {
                        $element.closest('.product-box-contain').fadeOut('slow', function() {
                            $(this).remove();

                            // Check if wishlist is empty
                            if ($('#wishlist-products-container .product-box-contain').length === 0) {
                                $('#wishlist-products-container').html(
                                    '<div class="col-12">' +
                                    '<div class="text-center py-5">' +
                                    '<h4>{{ __("messages.Your wishlist is empty") }}</h4>' +
                                    '<p class="text-muted">{{ __("messages.Add products to your wishlist to see them here") }}</p>' +
                                    '</div>' +
                                    '</div>'
                                );
                            }
                        });
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
                $element.closest('.product-box-contain').fadeOut('slow', function() {
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
                    }
                });
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

            // Handle remove button click
            $(document).on('click', '.close_button', function(e) {
                e.preventDefault();
                var $button = $(this);
                var productId = $button.data('product-id');

                if (!productId) {
                    productId = $button.closest('.product-box-contain').data('product-id');
                }

                if (productId) {
                    removeFromWishlist(productId, $button);
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
        function addToLocalStorageCart(productId, variantId, quantity) {
            quantity = quantity || 1;
            var cart = getCartFromStorage();

            // Check if product already exists
            var existingItem = cart.find(function(item) {
                return item.product_id == productId &&
                       (variantId ? item.variant_id == variantId : !item.variant_id);
            });

            if (existingItem) {
                // Update quantity
                existingItem.quantity = (existingItem.quantity || 0) + quantity;
            } else {
                // Add new item
                cart.push({
                    product_id: productId,
                    variant_id: variantId || null,
                    quantity: quantity
                });
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
         */
        function addToCart(productId, variantId, quantity) {
            quantity = quantity || 1;

            if (isAuth) {
                // Add to database
                $.ajax({
                    url: '/api/web/cart/add-single',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    data: {
                        product_id: productId,
                        variant_id: variantId || null,
                        quantity: quantity
                    },
                    success: function(response) {
                        showNotification(response.message || '{{ __("messages.Product added to cart successfully") }}', 'success');
                        updateCartDisplay();
                    },
                    error: function(xhr) {
                        var message = xhr.responseJSON?.message || '{{ __("messages.Error adding product to cart") }}';
                        showNotification(message, 'error');
                    }
                });
            } else {
                // Add to localStorage
                addToLocalStorageCart(productId, variantId, quantity);
                showNotification('{{ __("messages.Product added to cart successfully") }}', 'success');
                updateCartDisplay();
            }
        }

        /**
         * Update cart display in header and footer
         */
        function updateCartDisplay() {
            if (isAuth) {
                // Fetch cart from database
                $.ajax({
                    url: '/api/web/cart/items',
                    type: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.data && response.data.items) {
                            var items = response.data.items || [];
                            var total = response.data.total || 0;
                            var itemsCount = response.data.items_count || 0;
                            
                            renderCartHeader(items, total, itemsCount);
                            renderCartFooter(items, total, itemsCount);
                        } else {
                            renderCartHeader([], 0, 0);
                            renderCartFooter([], 0, 0);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching cart items:', xhr);
                        // Show empty cart on error
                        renderCartHeader([], 0, 0);
                        renderCartFooter([], 0, 0);
                    }
                });
            } else {
                // Get cart from localStorage and fetch product details
                var cart = getCartFromStorage();
                if (cart.length === 0) {
                    renderCartHeader([], 0, 0);
                    renderCartFooter([], 0, 0);
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

                            renderCartHeader(items, total, itemsCount);
                            renderCartFooter(items, total, itemsCount);
                        } else {
                            // No products found
                            renderCartHeader([], 0, 0);
                            renderCartFooter([], 0, 0);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching cart products:', xhr);
                        // Show empty cart on error
                        renderCartHeader([], 0, 0);
                        renderCartFooter([], 0, 0);
                    }
                });
            }
        }

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
                        '<button class="close-button close-cart-item" data-product-id="' + item.product_id + '" data-variant-id="' + (item.variant_id || '') + '">' +
                        '<i class="fa-solid fa-xmark"></i>' +
                        '</button>' +
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

            if (!productId) {
                console.error('Product ID not found');
                showNotification('{{ __("messages.Product ID not found") }}', 'error');
                return;
            }

            // Add to cart
            addToCart(productId, variantId, quantity);

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

</body>

</html>

