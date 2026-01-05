@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Thank You'))
@push("headStyle")

@endpush
@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Checkout</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active mx-1" aria-current="page">Checkout</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout section Start -->
    <section class="checkout-section-2 section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-lg-8">
                    <div class="left-sidebar-checkout">
                        <div class="checkout-detail-box">
                            <ul>
                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                                   trigger="loop-on-hover"
                                                   colors="primary:#121331,secondary:#646e78,tertiary:#9d080f"
                                                   class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box">
                                        <div class="checkout-title">
                                            <h4>{{ __('messages.Delivery Address') }}</h4>
                                        </div>

                                        <div class="checkout-detail">
                                            @php
                                                $user = auth('user')->user();
                                            @endphp
                                            <div id="addresses-loading" class="text-center py-4 d-none">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">{{ __('messages.Loading') }}...</span>
                                                </div>
                                            </div>
                                            <div id="delivery-addresses-container">
                                                @if(isset($addresses) && $addresses->count() > 0)
                                                    <div class="row g-4">
                                                        @foreach($addresses as $index => $address)
                                                            @php
                                                                $areaTranslation = $address->area->translation ?? $address->area->translations->first() ?? null;
                                                                $areaName = $areaTranslation ? $areaTranslation->title : '';
                                                                $addressId = 'address-' . $address->id;
                                                                $isChecked = $address->is_primary ? 'checked' : '';
                                                            @endphp
                                                            <div class="col-xxl-6 col-lg-12 col-md-6">
                                                                <div class="delivery-address-box">
                                                                    <div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input address-radio" type="radio" name="selected_address"
                                                                                   id="{{ $addressId }}" value="{{ $address->id }}" {{ $isChecked }}>
                                                                        </div>

                                                                        <div class="label">
                                                                            <label>{{ $address->title ?? __('messages.Address') }}</label>
                                                                        </div>

                                                                        <ul class="delivery-address-detail">
                                                                            @if($address->name)
                                                                            <li>
                                                                                <h4 class="fw-500">{{ $address->name }}</h4>
                                                                            </li>
                                                                            @endif

                                                                            <li>
                                                                                <p class="text-content"><span class="text-title">{{ __('messages.Address') }}: </span>{{ $address->address }}</p>
                                                                            </li>

                                                                            @if($areaName)
                                                                            <li>
                                                                                <h6 class="text-content"><span class="text-title">{{ __('messages.Area') }}:</span> {{ $areaName }}</h6>
                                                                            </li>
                                                                            @endif

                                                                            @if($user->mobile)
                                                                            <li>
                                                                                <h6 class="text-content mb-0"><span class="text-title">{{ __('messages.Phone') }}:</span> <span style="direction: ltr;display: inline-block">{{ $user->mobile }}</span></h6>
                                                                            </li>
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="mt-3">
                                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add-address">
                                                            <i class="fa-solid fa-plus me-1"></i>{{ __('messages.Add Address') }}
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="text-center py-4" id="no-addresses-message">
                                                        <p class="text-muted mb-3">{{ __('messages.No addresses found') }}</p>
                                                        <button type="button" class="btn theme-bg-color text-white btn-md" data-bs-toggle="modal" data-bs-target="#add-address">
                                                            {{ __('messages.Add Address') }}
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                                   trigger="loop-on-hover" colors="primary:#9d080f,secondary:#9d080f"
                                                   class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box">
                                        <div class="checkout-title">
                                            <h4>Payment Option</h4>
                                        </div>

                                        <div class="checkout-detail">
                                            <div class="accordion accordion-flush custom-accordion"
                                                 id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingFour">
                                                        <div class="accordion-button collapsed"
                                                             data-bs-toggle="collapse"
                                                             data-bs-target="#flush-collapseFour">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="cash"><input
                                                                        class="form-check-input mt-0" type="radio"
                                                                        name="flexRadioDefault" id="cash" checked> Cash
                                                                    On Delivery</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="flush-collapseFour"
                                                         class="accordion-collapse collapse show"
                                                         data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <p class="cod-review">Pay digitally with SMS Pay
                                                                Link. Cash may not be accepted in COVID restricted
                                                                areas. <a href="javascript:void(0)">Know more.</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summery-box p-sticky">
                        <div class="summery-contain">
                            <div class="coupon-cart">
                                <h6 class="text-content mb-2">Coupon Apply</h6>
                                <div class="mb-3 coupon-box input-group">
                                    <input type="email" class="form-control" id="exampleFormControlInput1"
                                           placeholder="Enter Coupon Code Here...">
                                    <button class="btn-apply">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-side-summery-box">
                        <div class="summery-box-2">
                            <div class="summery-header">
                                <h3>Order Summery</h3>
                            </div>

                            <ul class="summery-contain">
                                <li>
                                    <img src="/website/images/veg-3/home/15.jpg"
                                         class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                    <h4>Bell pepper <span>X 1</span></h4>
                                    <h4 class="price">EGP 32.34</h4>
                                </li>

                                <li>
                                    <img src="/website/images/veg-3/home/17.jpg"
                                         class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                    <h4>Eggplant <span>X 3</span></h4>
                                    <h4 class="price">EGP 12.23</h4>
                                </li>

                                <li>
                                    <img src="/website/images/veg-3/home/22.jpg"
                                         class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                    <h4>Onion <span>X 2</span></h4>
                                    <h4 class="price">EGP 18.27</h4>
                                </li>

                                <li>
                                    <img src="/website/images/veg-3/home/23.jpg"
                                         class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                    <h4>Potato <span>X 1</span></h4>
                                    <h4 class="price">EGP 26.90</h4>
                                </li>

                                <li>
                                    <img src="/website/images/veg-3/home/24.jpg"
                                         class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                    <h4>Baby Chili <span>X 1</span></h4>
                                    <h4 class="price">EGP 19.28</h4>
                                </li>

                                <li>
                                    <img src="/website/images/veg-3/home/24.jpg"
                                         class="img-fluid blur-up lazyloaded checkout-image" alt="">
                                    <h4>Broccoli <span>X 2</span></h4>
                                    <h4 class="price">EGP 29.69</h4>
                                </li>
                            </ul>

                            <ul class="summery-total">
                                <li>
                                    <h4>Subtotal</h4>
                                    <h4 class="price">EGP 111.81</h4>
                                </li>

                                <li>
                                    <h4>Shipping</h4>
                                    <h4 class="price">EGP 8.90</h4>
                                </li>

                                <li>
                                    <h4>Tax</h4>
                                    <h4 class="price">EGP 29.498</h4>
                                </li>

                                <li>
                                    <h4>Coupon/Code</h4>
                                    <h4 class="price">EGP -23.10</h4>
                                </li>

                                <li class="list-total">
                                    <h4>Total (USD)</h4>
                                    <h4 class="price">EGP 19.28</h4>
                                </li>
                            </ul>
                        </div>

                        <button class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Checkout section End -->

    <!-- Add address modal box start -->
    <div class="modal fade theme-modal" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.Add a new address') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeAddressModal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Success/Error Messages Container -->
                    <div id="addAddressMessage" class="alert d-none mb-3" role="alert"></div>

                    <form id="addAddressForm" novalidate>
                        <input type="hidden" id="addressId" name="address_id" value="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="addressName" name="name" placeholder="{{ __('messages.Recipient Name') }}">
                                    <label for="addressName">{{ __('messages.Recipient Name') }}</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="addressTitle" name="title" placeholder="{{ __('messages.Address Title') }}" required maxlength="255">
                                    <label for="addressTitle">{{ __('messages.Address Title') }} <span class="text-danger">*</span> <small>({{ __('messages.e.g. Home, Office') }})</small></label>
                                    <div class="invalid-feedback">{{ __('messages.Please enter an address title') }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="addressArea" name="area_id" required>
                                        <option value="" selected disabled>{{ __('messages.Select Area') }}</option>
                                        @if(isset($areas))
                                            @foreach($areas as $area)
                                                <option value="{{ $area->id }}">{{  $area->current_translation?->title ?? '' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="addressArea">{{ __('messages.Area') }} <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">{{ __('messages.Please select an area') }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check ps-0 m-0 remember-box">
                                    <input class="checkbox_animated check-box" type="checkbox" id="isPrimary" name="is_primary" value="1">
                                    <label class="form-check-label" for="isPrimary">{{ __('messages.Set as primary address') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <textarea class="form-control" placeholder="{{ __('messages.Enter full address') }}" id="addressText" name="address" style="height: 100px" required maxlength="500"></textarea>
                                    <label for="addressText">{{ __('messages.Full Address') }} <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">{{ __('messages.Please enter the full address') }}</div>
                                </div>
                            </div>

                            <!-- Leaflet Map Section -->
                            <div class="col-12">
                                <label class="form-label">{{ __('messages.Select location on map') }} <span class="text-danger">*</span></label>

                                <!-- Search input for Leaflet Geocoder -->
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="mapSearch" placeholder="{{ __('messages.Search for a location') }}" autocomplete="off">
                                    </div>
                                    <small class="text-muted">{{ __('messages.Type to search for a location or click on the map') }}</small>
                                </div>

                                <div id="addressMap" style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 8px;"></div>
                                <small class="text-muted mt-2 d-block">{{ __('messages.Click on the map to select your location') }}</small>
                                <div id="mapLocationError" class="text-danger small mt-1 d-none">
                                    <i class="fa-solid fa-exclamation-circle me-1"></i> {{ __('messages.Please select a location on the map') }}
                                </div>
                            </div>

                            <!-- Hidden inputs for lat/lng -->
                            <input type="hidden" id="addressLat" name="lat" value="" required>
                            <input type="hidden" id="addressLng" name="lng" value="" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">{{ __('messages.Close') }}</button>
                    <button type="button" class="btn theme-bg-color btn-md text-white" id="saveAddressBtn">{{ __('messages.Save Address') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add address modal box end -->
@endsection

@push('headScript')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <!-- Leaflet Geocoder CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <!-- Leaflet Geocoder JS -->
    <script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>
    <script>
        (function() {
            var map;
            var marker;
            var defaultLat = 30.0444; // Default location (Cairo)
            var defaultLng = 31.2357;

            // Initialize map when modal is shown
            $('#add-address').on('shown.bs.modal', function() {
                if (!map) {
                    initMap();
                    initGeocoder();
                } else {
                    setTimeout(function() {
                        if (map) {
                            map.invalidateSize();
                        }
                    }, 300);
                }
            });

            /**
             * Initialize Leaflet Map
             */
            function initMap() {
                var mapElement = document.getElementById('addressMap');
                if (!mapElement) return;

                if (typeof L === 'undefined') {
                    mapElement.innerHTML = '<div class="alert alert-warning p-4 text-center">' +
                        '<i class="fa-solid fa-exclamation-triangle me-2"></i>' +
                        '<strong>{{ __("messages.Error") }}:</strong> ' +
                        '{{ __("messages.Leaflet library is not loaded") }}' +
                        '</div>';
                    return;
                }

                map = L.map('addressMap', {
                    center: [defaultLat, defaultLng],
                    zoom: 12
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                map.on('click', function(e) {
                    placeMarker([e.latlng.lat, e.latlng.lng]);
                });

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            var userLocation = [position.coords.latitude, position.coords.longitude];
                            map.setView(userLocation, 15);
                            placeMarker(userLocation);
                        },
                        function() {
                            placeMarker([defaultLat, defaultLng]);
                        }
                    );
                } else {
                    placeMarker([defaultLat, defaultLng]);
                }

                setTimeout(function() {
                    if (map) {
                        map.invalidateSize();
                    }
                }, 300);
            }

            /**
             * Initialize Leaflet Geocoder for search
             */
            function initGeocoder() {
                var searchInput = document.getElementById('mapSearch');
                if (!searchInput || !map) return;

                var searchContainer = $(searchInput).parent();
                var searchBtn = searchContainer.find('.search-btn');
                if (searchBtn.length === 0) {
                    searchBtn = $('<button type="button" class="btn btn-primary ms-2 search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>');
                    searchContainer.append(searchBtn);
                }

                function performSearch(query) {
                    if (!query || query.trim() === '') {
                        return;
                    }

                    searchBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i>');

                    var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&limit=5&countrycodes=ae,sa,eg&accept-language={{ app()->getLocale() === "ar" ? "ar" : "en" }}';

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'User-Agent': 'MediaCity Application'
                        },
                        success: function(results) {
                            if (results && results.length > 0) {
                                var result = results[0];
                                var lat = parseFloat(result.lat);
                                var lng = parseFloat(result.lon);
                                placeMarker([lat, lng]);
                                if (!$('#addressText').val()) {
                                    $('#addressText').val(result.display_name);
                                }
                                map.setView([lat, lng], 15);
                            } else {
                                alert('{{ __("messages.No results found") }}');
                            }
                        },
                        error: function() {
                            alert('{{ __("messages.Error searching for location") }}');
                        },
                        complete: function() {
                            searchBtn.prop('disabled', false).html('<i class="fa-solid fa-magnifying-glass"></i>');
                        }
                    });
                }

                searchBtn.off('click').on('click', function() {
                    performSearch($(searchInput).val());
                });

                $(searchInput).off('keypress').on('keypress', function(e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        performSearch($(this).val());
                    }
                });
            }

            /**
             * Place marker on map and update lat/lng inputs
             */
            function placeMarker(coordinates) {
                if (!map || !coordinates || coordinates.length < 2) return;

                var lat = coordinates[0];
                var lng = coordinates[1];

                if (marker) {
                    map.removeLayer(marker);
                }

                var customIcon = L.divIcon({
                    className: 'leaflet-custom-marker',
                    html: '<div style="width: 30px; height: 30px; border-radius: 50%; background-color: #3b82f6; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.3);"></div>',
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });

                marker = L.marker([lat, lng], {
                    icon: customIcon,
                    draggable: true
                }).addTo(map);

                document.getElementById('addressLat').value = lat;
                document.getElementById('addressLng').value = lng;

                marker.on('dragend', function(e) {
                    var position = marker.getLatLng();
                    document.getElementById('addressLat').value = position.lat;
                    document.getElementById('addressLng').value = position.lng;
                });

                map.setView([lat, lng], map.getZoom());
            }

            /**
             * Handle form submission via AJAX
             */
            $('#saveAddressBtn').on('click', function(e) {
                e.preventDefault();

                var form = document.getElementById('addAddressForm');
                var messageDiv = document.getElementById('addAddressMessage');
                var submitBtn = $(this);
                var originalBtnText = submitBtn.html();

                if (messageDiv) {
                    $(messageDiv).addClass('d-none').removeClass('alert-success alert-danger');
                }

                var lat = $('#addressLat').val();
                var lng = $('#addressLng').val();
                var mapError = $('#mapLocationError');

                if (!lat || !lng || lat === '' || lng === '') {
                    mapError.removeClass('d-none');
                    mapError[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    return;
                } else {
                    mapError.addClass('d-none');
                }

                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    var firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        firstInvalid.focus();
                    }
                    return;
                }

                var addressId = $('#addressId').val();
                var formData = {
                    name: $('#addressName').val(),
                    title: $('#addressTitle').val(),
                    address: $('#addressText').val(),
                    area_id: $('#addressArea').val(),
                    lat: $('#addressLat').val(),
                    lng: $('#addressLng').val(),
                    is_primary: $('#isPrimary').is(':checked') ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                };

                var url = '/api/web/add-address';
                var method = 'POST';
                if (addressId) {
                    url = '/api/web/edit-address/' + addressId;
                    method = 'PUT';
                }

                submitBtn.prop('disabled', true).html('{{ __("messages.Sending") }}...');

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (messageDiv) {
                            var successMsg = addressId ? '{{ __("messages.Address updated successfully") }}' : '{{ __("messages.Address added successfully") }}';
                            $(messageDiv)
                                .removeClass('d-none alert-danger')
                                .addClass('alert-success')
                                .html('<strong>{{ __("messages.Success") }}!</strong> ' + (data.message || successMsg));
                        }

                        // Reset form
                        form.reset();
                        form.classList.remove('was-validated');
                        $('#addressId').val('');
                        $('#addressLat').val('');
                        $('#addressLng').val('');

                        // Remove marker
                        if (marker) {
                            map.removeLayer(marker);
                            marker = null;
                        }

                        // Load and display addresses without reloading page
                        loadAddresses();

                        // Close modal after 1.5 seconds
                        setTimeout(function() {
                            $('#add-address').modal('hide');
                        }, 1500);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        var errorMessage = '{{ __("messages.An error occurred. Please try again.") }}';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = '<ul class="mb-0 ps-3">';
                            $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                if (Array.isArray(errorArray)) {
                                    $.each(errorArray, function(index, error) {
                                        errors += '<li>' + error + '</li>';
                                    });
                                } else {
                                    errors += '<li>' + errorArray + '</li>';
                                }
                            });
                            errors += '</ul>';
                            errorMessage = errors;
                        }

                        if (messageDiv) {
                            $(messageDiv)
                                .removeClass('d-none alert-success')
                                .addClass('alert-danger')
                                .html('<div class="d-flex align-items-start">' +
                                    '<i class="fa-solid fa-exclamation-circle me-2 mt-1"></i>' +
                                    '<div><strong>{{ __("messages.Error") }}!</strong><br>' + errorMessage + '</div>' +
                                    '</div>');
                            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, errorArray) {
                                var field = $('[name="' + key + '"]');
                                if (field.length) {
                                    field.addClass('is-invalid');
                                    field.on('input change', function() {
                                        $(this).removeClass('is-invalid');
                                    });
                                }
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            // Reset form when modal is hidden
            $('#add-address').on('hidden.bs.modal', function() {
                var form = document.getElementById('addAddressForm');
                if (form) {
                    form.reset();
                    form.classList.remove('was-validated');
                    $('#addressId').val('');
                    $('#addressLat').val('');
                    $('#addressLng').val('');
                    $('#mapSearch').val('');
                    $(form).find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                }
                $('#exampleModalLabel').text('{{ __("messages.Add a new address") }}');
                $('#saveAddressBtn').text('{{ __("messages.Save Address") }}');
                var messageDiv = document.getElementById('addAddressMessage');
                if (messageDiv) {
                    $(messageDiv).addClass('d-none').removeClass('alert-success alert-danger');
                }
                $('#mapLocationError').addClass('d-none');
                if (marker) {
                    map.removeLayer(marker);
                    marker = null;
                }
                var searchInput = document.getElementById('mapSearch');
                if (searchInput) {
                    searchInput.value = '';
                }
                var searchContainer = $('#mapSearch').parent();
                var searchBtn = searchContainer.find('.search-btn');
                if (searchBtn.length > 0) {
                    searchBtn.remove();
                }
                if (map) {
                    map.setView([defaultLat, defaultLng], 12);
                }
            });

            /**
             * Load addresses from API and display them
             */
            function loadAddresses() {
                $('#addresses-loading').removeClass('d-none');
                $('#no-addresses-message').addClass('d-none');

                $.ajax({
                    url: '/api/web/user-addresses',
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        $('#addresses-loading').addClass('d-none');
                        renderAddresses(response.data || []);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading addresses:', error);
                        $('#addresses-loading').addClass('d-none');
                        var container = $('#delivery-addresses-container');
                        container.html('<div class="text-center py-4">' +
                            '<p class="text-danger mb-3">{{ __("messages.Error loading addresses") }}</p>' +
                            '<button type="button" class="btn theme-bg-color text-white btn-md" data-bs-toggle="modal" data-bs-target="#add-address">' +
                            '{{ __("messages.Add Address") }}' +
                            '</button>' +
                            '</div>');
                    }
                });
            }

            /**
             * Render addresses in the container
             */
            function renderAddresses(addresses) {
                var container = $('#delivery-addresses-container');
                var userMobile = '{{ auth("user")->user()->mobile ?? "" }}';

                if (addresses.length === 0) {
                    container.html('<div class="text-center py-4" id="no-addresses-message">' +
                        '<p class="text-muted mb-3">{{ __("messages.No addresses found") }}</p>' +
                        '<button type="button" class="btn theme-bg-color text-white btn-md" data-bs-toggle="modal" data-bs-target="#add-address">' +
                        '{{ __("messages.Add Address") }}' +
                        '</button>' +
                        '</div>');
                    return;
                }

                var addressesHtml = '<div class="row g-4">';

                $.each(addresses, function(index, address) {
                    var areaName = '';
                    if (address.area) {
                        if (address.area.translation) {
                            areaName = address.area.translation.title || '';
                        } else if (address.area.title) {
                            areaName = address.area.title;
                        }
                    }

                    var addressId = 'address-' + address.id;
                    var isChecked = address.is_primary ? 'checked' : '';

                    addressesHtml += '<div class="col-xxl-6 col-lg-12 col-md-6">' +
                        '<div class="delivery-address-box">' +
                        '<div>' +
                        '<div class="form-check">' +
                        '<input class="form-check-input address-radio" type="radio" name="selected_address" ' +
                        'id="' + addressId + '" value="' + address.id + '" ' + isChecked + '>' +
                        '</div>' +
                        '<div class="label">' +
                        '<label>' + (address.title || '{{ __("messages.Address") }}') + '</label>' +
                        '</div>' +
                        '<ul class="delivery-address-detail">';

                    if (address.name) {
                        addressesHtml += '<li><h4 class="fw-500">' + address.name + '</h4></li>';
                    }

                    addressesHtml += '<li>' +
                        '<p class="text-content"><span class="text-title">{{ __("messages.Address") }}: </span>' + (address.address || '') + '</p>' +
                        '</li>';

                    if (areaName) {
                        addressesHtml += '<li>' +
                            '<h6 class="text-content"><span class="text-title">{{ __("messages.Area") }}:</span> ' + areaName + '</h6>' +
                            '</li>';
                    }

                    if (userMobile) {
                        addressesHtml += '<li>' +
                            '<h6 class="text-content mb-0"><span class="text-title">{{ __("messages.Phone") }}:</span> ' +
                            '<span style="direction: ltr;display: inline-block">' + userMobile + '</span></h6>' +
                            '</li>';
                    }

                    addressesHtml += '</ul>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                });

                addressesHtml += '</div>' +
                    '<div class="mt-3">' +
                    '<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add-address">' +
                    '<i class="fa-solid fa-plus me-1"></i>{{ __("messages.Add Address") }}' +
                    '</button>' +
                    '</div>';

                container.html(addressesHtml);
            }

            // Handle address selection (radio button change)
            $(document).on('change', '.address-radio', function() {
                var selectedAddressId = $(this).val();
                // You can store the selected address ID for later use in checkout
                // For example, store it in a hidden input or use it when submitting the order
                console.log('Selected address ID:', selectedAddressId);
            });
        })();
    </script>
@endpush
