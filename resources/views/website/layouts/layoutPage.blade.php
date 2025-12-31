
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

            // Set add to cart button (you can add cart functionality later)
            $('#modal-add-to-cart-btn').attr('data-product-id', product.id);

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

</body>

</html>

