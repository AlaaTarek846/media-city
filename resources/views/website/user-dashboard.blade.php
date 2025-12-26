@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Blog Details'))

@section('body')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>User Dashboard</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">User Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- User Dashboard Section Start -->
    <section class="user-dashboard-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 col-lg-4">
                    <div class="dashboard-left-sidebar">
                        <div class="close-button d-flex d-lg-none">
                            <button class="close-sidebar">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="profile-box">
                            <div class="cover-image">
                                <img src="/website/images/inner-page/cover-img.jpg" class="img-fluid blur-up lazyload"
                                     alt="">
                            </div>

                            <div class="profile-contain">
                                <div class="profile-image">
                                    <div class="position-relative">

                                    </div>
                                </div>

                                <div class="profile-name">
                                    <h3>Ahmed Hassan</h3>
                                    <h6 class="text-content">Ahmed@gmail.com</h6>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-dashboard-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-dashboard" type="button" role="tab"
                                        aria-controls="pills-dashboard" aria-selected="true"><i data-feather="home"></i>
                                    DashBoard</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                                        aria-selected="false"><i data-feather="shopping-bag"></i>Order</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-card-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-card" type="button" role="tab" aria-controls="pills-card"
                                        aria-selected="false"><i data-feather="credit-card"></i> Saved Card</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-address" type="button" role="tab"
                                        aria-controls="pills-address" aria-selected="false"><i data-feather="map-pin"></i>
                                    Address</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false"><i data-feather="user"></i>
                                    Profile</button>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                        Menu</button>
                    <div class="dashboard-right-sidebar">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel"
                                 aria-labelledby="pills-dashboard-tab">
                                <div class="dashboard-home">
                                    <div class="title">
                                        <h2>My Dashboard</h2>
                                        <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="dashboard-user-name">
                                        <h6 class="text-content">Hello, <b class="text-title">Ahmed Hassan</b></h6>
                                        <p class="text-content">From your My Account Dashboard you have the ability to
                                            view a snapshot of your recent account activity and update your account
                                            information. Select a link below to view or edit information.</p>
                                    </div>

                                    <div class="total-box">
                                        <div class="row g-sm-4 g-3">
                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain">
                                                    <img src="/website/images/svg/order.svg"
                                                         class="img-1 blur-up lazyload" alt="">
                                                    <img src="/website/images/svg/order.svg" class="blur-up lazyload"
                                                         alt="">
                                                    <div class="totle-detail">
                                                        <h5>Total Order</h5>
                                                        <h3>3658</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain">
                                                    <img src="/website/images/svg/pending.svg"
                                                         class="img-1 blur-up lazyload" alt="">
                                                    <img src="/website/images/svg/pending.svg" class="blur-up lazyload"
                                                         alt="">
                                                    <div class="totle-detail">
                                                        <h5>Total Pending Order</h5>
                                                        <h3>254</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain">
                                                    <img src="/website/images/svg/wishlist.svg"
                                                         class="img-1 blur-up lazyload" alt="">
                                                    <img src="/website/images/svg/wishlist.svg"
                                                         class="blur-up lazyload" alt="">
                                                    <div class="totle-detail">
                                                        <h5>Total Wishlist</h5>
                                                        <h3>32158</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dashboard-title">
                                        <h3>Account Information</h3>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-xxl-6">
                                            <div class="dashboard-contant-title">
                                                <h4>Contact Information <a href="javascript:void(0)"
                                                                           data-bs-toggle="modal" data-bs-target="#editProfile">Edit</a>
                                                </h4>
                                            </div>
                                            <div class="dashboard-detail">
                                                <h6 class="text-content">Ahmed Hassan</h6>
                                                <h6 class="text-content">Ahmed@gmail.com</h6>
                                                <a href="javascript:void(0)">Change Password</a>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6">
                                            <div class="dashboard-contant-title">
                                                <h4>Newsletters <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                   data-bs-target="#editProfile">Edit</a></h4>
                                            </div>
                                            <div class="dashboard-detail">
                                                <h6 class="text-content">You are currently not subscribed to any
                                                    newsletter</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-order" role="tabpanel"
                                 aria-labelledby="pills-order-tab">
                                <div class="dashboard-order">
                                    <div class="title">
                                        <h2>My Orders History</h2>
                                        <span class="title-leaf title-leaf-gray">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="order-contain">
                                        <div class="order-box dashboard-bg-box">
                                            <div class="order-container">
                                                <div class="order-icon">
                                                    <i data-feather="box"></i>
                                                </div>

                                                <div class="order-detail">
                                                    <h4>Delivere <span>Panding</span></h4>
                                                    <h6 class="text-content">Gouda parmesan caerphilly mozzarella
                                                        cottage cheese cauliflower cheese taleggio gouda.</h6>
                                                </div>
                                            </div>

                                            <div class="product-order-detail">
                                                <a href="product-left-thumbnail.html" class="order-image">
                                                    <img src="/website/images/veg-3/home/23.jpg" style="height: 150px;" alt="">
                                                </a>

                                                <div class="order-wrap">
                                                    <a href="product-left-thumbnail.html">
                                                        <h3> Sony Alpha a7 IV Mirrorless Digital Camera</h3>
                                                    </a>
                                                    <p class="text-content">Cheddar dolcelatte gouda. Macaroni cheese
                                                        cheese strings feta halloumi cottage cheese jarlsberg cheese
                                                        triangles say cheese.</p>
                                                    <ul class="product-size">
                                                        <li>
                                                            <div class="size-box">
                                                                <h6 class="text-content">Price : </h6>
                                                                <h5>EGP 20.68</h5>
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div class="size-box">
                                                                <h6 class="text-content">Rate : </h6>
                                                                <div class="product-rating ms-2">
                                                                    <ul class="rating">
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="order-box dashboard-bg-box">
                                            <div class="order-container">
                                                <div class="order-icon">
                                                    <i data-feather="box"></i>
                                                </div>

                                                <div class="order-detail">
                                                    <h4>Delivered <span class="success-bg">Success</span></h4>
                                                    <h6 class="text-content">Cheese on toast cheesy grin cheesy grin
                                                        cottage cheese caerphilly everyone loves cottage cheese the big
                                                        cheese.</h6>
                                                </div>
                                            </div>

                                            <div class="product-order-detail">
                                                <a href="product-left-thumbnail.html" class="order-image">
                                                    <img src="/website/images/veg-3/home/17.jpg" style="height: 150px;" alt=""
                                                         class="blur-up lazyload">
                                                </a>

                                                <div class="order-wrap">
                                                    <a href="product-left-thumbnail.html">
                                                        <h3> Sony Alpha a7 IV Mirrorless Digital Camera</h3>
                                                    </a>
                                                    <p class="text-content">Pecorino paneer port-salut when the cheese
                                                        comes out everybody's happy red leicester mascarpone blue
                                                        castello cauliflower cheese.</p>
                                                    <ul class="product-size">
                                                        <li>
                                                            <div class="size-box">
                                                                <h6 class="text-content">Price : </h6>
                                                                <h5>EGP 20.68</h5>
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div class="size-box">
                                                                <h6 class="text-content">Rate : </h6>
                                                                <div class="product-rating ms-2">
                                                                    <ul class="rating">
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="order-box dashboard-bg-box">
                                            <div class="order-container">
                                                <div class="order-icon">
                                                    <i data-feather="box"></i>
                                                </div>

                                                <div class="order-detail">
                                                    <h4>Delivere <span>Panding</span></h4>
                                                    <h6 class="text-content">Cheesy grin boursin cheesy grin cheesecake
                                                        blue castello cream cheese lancashire melted cheese.</h6>
                                                </div>
                                            </div>

                                            <div class="product-order-detail">
                                                <a href="product-left-thumbnail.html" class="order-image">
                                                    <img src="/website/images/veg-3/home/19.jpg" style="height: 150px;" alt=""
                                                         class="blur-up lazyload">
                                                </a>

                                                <div class="order-wrap">
                                                    <a href="product-left-thumbnail.html">
                                                        <h3> Sony Alpha a7 IV Mirrorless Digital Camera</h3>
                                                    </a>
                                                    <p class="text-content">Cow bavarian bergkase mascarpone paneer
                                                        squirty cheese fromage frais cheese slices when the cheese comes
                                                        out everybody's happy.</p>
                                                    <ul class="product-size">
                                                        <li>
                                                            <div class="size-box">
                                                                <h6 class="text-content">Price : </h6>
                                                                <h5>EGP 20.68</h5>
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div class="size-box">
                                                                <h6 class="text-content">Rate : </h6>
                                                                <div class="product-rating ms-2">
                                                                    <ul class="rating">
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="order-box dashboard-bg-box">
                                            <div class="order-container">
                                                <div class="order-icon">
                                                    <i data-feather="box"></i>
                                                </div>

                                                <div class="order-detail">
                                                    <h4>Delivered <span class="success-bg">Success</span></h4>
                                                    <h6 class="text-content">Caerphilly port-salut parmesan pecorino
                                                        croque monsieur dolcelatte melted cheese cheese and wine.</h6>
                                                </div>
                                            </div>

                                            <div class="product-order-detail">
                                                <a href="product-left-thumbnail.html" class="order-image">
                                                    <img src="/website/images/veg-3/home/16.jpg" style="height: 150px;" alt="">
                                                </a>

                                                <div class="order-wrap">
                                                    <a href="product-left-thumbnail.html">
                                                        <h3> Sony Alpha a7 IV Mirrorless Digital Camera</h3>
                                                    </a>
                                                    <p class="text-content">The big cheese cream cheese pepper jack
                                                        cheese slices danish fontina everyone loves cheese on toast
                                                        bavarian bergkase.</p>
                                                    <ul class="product-size">
                                                        <li>
                                                            <div class="size-box">
                                                                <h6 class="text-content">Price : </h6>
                                                                <h5>EGP 20.68</h5>
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div class="size-box">
                                                                <h6 class="text-content">Rate : </h6>
                                                                <div class="product-rating ms-2">
                                                                    <ul class="rating">
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star" class="fill"></i>
                                                                        </li>
                                                                        <li>
                                                                            <i data-feather="star"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-address" role="tabpanel"
                                 aria-labelledby="pills-address-tab">
                                <div class="dashboard-address">
                                    <div class="title title-flex">
                                        <div>
                                            <h2>My Address Book</h2>
                                            <span class="title-leaf">
                                                <svg class="icon-width bg-gray">
                                                    <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                                </svg>
                                            </span>
                                        </div>

                                        <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
                                                data-bs-toggle="modal" data-bs-target="#add-address"><i data-feather="plus"
                                                                                                        class="me-2"></i> Add New Address</button>
                                    </div>

                                    <div class="row g-sm-4 g-3">
                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                               id="flexRadioDefault2" checked>
                                                    </div>

                                                    <div class="label">
                                                        <label>Home</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="2">Ahmed hassan</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Address :</td>
                                                                <td>
                                                                    <p>8424 James Lane South San Francisco, CA 94080
                                                                    </p>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Pin Code :</td>
                                                                <td>+380</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Phone :</td>
                                                                <td>+ 812-710-3798</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                               id="flexRadioDefault3">
                                                    </div>

                                                    <div class="label">
                                                        <label>Office</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="2">Terry S. Sutton</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Address :</td>
                                                                <td>
                                                                    <p>2280 Rose Avenue Kenner, LA 70062</p>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Pin Code :</td>
                                                                <td>+25</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Phone :</td>
                                                                <td>+ 504-228-0969</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                               id="flexRadioDefault4">
                                                    </div>

                                                    <div class="label">
                                                        <label>Neighbour</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="2">Juan M. McKeon</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Address :</td>
                                                                <td>
                                                                    <p>1703 Carson Street Lexington, KY 40593</p>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Pin Code :</td>
                                                                <td>+78</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Phone :</td>
                                                                <td>+ 859-257-0509</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                               id="flexRadioDefault5">
                                                    </div>

                                                    <div class="label">
                                                        <label>Home 2</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="2">Gary M. Bailey</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Address :</td>
                                                                <td>
                                                                    <p>2135 Burning Memory Lane Philadelphia, PA
                                                                        19135</p>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Pin Code :</td>
                                                                <td>+26</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Phone :</td>
                                                                <td>+ 215-335-9916</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                            <div class="address-box">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="jack"
                                                               id="flexRadioDefault1">
                                                    </div>

                                                    <div class="label">
                                                        <label>Home 2</label>
                                                    </div>

                                                    <div class="table-responsive address-table">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td colspan="2">Gary M. Bailey</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Address :</td>
                                                                <td>
                                                                    <p>2135 Burning Memory Lane Philadelphia, PA
                                                                        19135</p>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>Pin Code :</td>
                                                                <td>+26</td>
                                                            </tr>

                                                            <tr>
                                                                <td>Phone :</td>
                                                                <td>+ 215-335-9916</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="button-group">
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#editProfile"><i data-feather="edit"></i>
                                                        Edit</button>
                                                    <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                                            data-bs-target="#removeProfile"><i data-feather="trash-2"></i>
                                                        Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-card" role="tabpanel"
                                 aria-labelledby="pills-card-tab">
                                <div class="dashboard-card">
                                    <div class="title title-flex">
                                        <div>
                                            <h2>My Card Details</h2>
                                            <span class="title-leaf">
                                                <svg class="icon-width bg-gray">
                                                    <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                                </svg>
                                            </span>
                                        </div>

                                        <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
                                                data-bs-toggle="modal" data-bs-target="#editCard"><i data-feather="plus"
                                                                                                     class="me-2"></i> Add New Card</button>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                            <div class="payment-card-detail">
                                                <div class="card-details">
                                                    <div class="card-number">
                                                        <h4>XXXX - XXXX - XXXX - 2548</h4>
                                                    </div>

                                                    <div class="valid-detail">
                                                        <div class="title">
                                                            <span>valid</span>
                                                            <span>thru</span>
                                                        </div>
                                                        <div class="date">
                                                            <h3>08/05</h3>
                                                        </div>
                                                        <div class="primary">
                                                            <span class="badge bg-pill badge-light">primary</span>
                                                        </div>
                                                    </div>

                                                    <div class="name-detail">
                                                        <div class="name">
                                                            <h5>Audrey Carol</h5>
                                                        </div>
                                                        <div class="card-img">
                                                            <img src="/website/images/payment-icon/1.jpg"
                                                                 class="img-fluid blur-up lazyloaded" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="edit-card">
                                                    <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                       href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       data-bs-target="#removeProfile"><i
                                                            class="far fa-minus-square"></i> delete</a>
                                                </div>
                                            </div>

                                            <div class="edit-card-mobile">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                   href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                            <div class="payment-card-detail">
                                                <div class="card-details card-visa">
                                                    <div class="card-number">
                                                        <h4>XXXX - XXXX - XXXX - 1536</h4>
                                                    </div>

                                                    <div class="valid-detail">
                                                        <div class="title">
                                                            <span>valid</span>
                                                            <span>thru</span>
                                                        </div>
                                                        <div class="date">
                                                            <h3>12/23</h3>
                                                        </div>
                                                        <div class="primary">
                                                            <span class="badge bg-pill badge-light">primary</span>
                                                        </div>
                                                    </div>

                                                    <div class="name-detail">
                                                        <div class="name">
                                                            <h5>Leah Heather</h5>
                                                        </div>
                                                        <div class="card-img">
                                                            <img src="/website/images/payment-icon/2.jpg"
                                                                 class="img-fluid blur-up lazyloaded" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="edit-card">
                                                    <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                       href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       data-bs-target="#removeProfile"><i
                                                            class="far fa-minus-square"></i> delete</a>
                                                </div>
                                            </div>

                                            <div class="edit-card-mobile">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                   href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                            <div class="payment-card-detail">
                                                <div class="card-details dabit-card">
                                                    <div class="card-number">
                                                        <h4>XXXX - XXXX - XXXX - 1366</h4>
                                                    </div>

                                                    <div class="valid-detail">
                                                        <div class="title">
                                                            <span>valid</span>
                                                            <span>thru</span>
                                                        </div>
                                                        <div class="date">
                                                            <h3>05/21</h3>
                                                        </div>
                                                        <div class="primary">
                                                            <span class="badge bg-pill badge-light">primary</span>
                                                        </div>
                                                    </div>

                                                    <div class="name-detail">
                                                        <div class="name">
                                                            <h5>Ahmed Hassan</h5>
                                                        </div>
                                                        <div class="card-img">
                                                            <img src="/website/images/payment-icon/3.jpg"
                                                                 class="img-fluid blur-up lazyloaded" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="edit-card">
                                                    <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                       href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       data-bs-target="#removeProfile"><i
                                                            class="far fa-minus-square"></i> delete</a>
                                                </div>
                                            </div>

                                            <div class="edit-card-mobile">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                   href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-profile" role="tabpanel"
                                 aria-labelledby="pills-profile-tab">
                                <div class="dashboard-profile">
                                    <div class="title">
                                        <h2>My Profile</h2>
                                        <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="/website/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="profile-detail dashboard-bg-box">
                                        <div class="dashboard-title">
                                            <h3>Profile Name</h3>
                                        </div>
                                        <div class="profile-name-detail">
                                            <div class="d-sm-flex align-items-center d-block">
                                                <h3>Ahmed Hassan</h3>
                                                <div class="product-rating profile-rating">
                                                    <ul class="rating">
                                                        <li>
                                                            <i data-feather="star" class="fill"></i>
                                                        </li>
                                                        <li>
                                                            <i data-feather="star" class="fill"></i>
                                                        </li>
                                                        <li>
                                                            <i data-feather="star" class="fill"></i>
                                                        </li>
                                                        <li>
                                                            <i data-feather="star"></i>
                                                        </li>
                                                        <li>
                                                            <i data-feather="star"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                               data-bs-target="#editProfile">Edit</a>
                                        </div>

                                        <div class="location-profile">
                                            <ul>
                                                <li>
                                                    <div class="location-box">
                                                        <i data-feather="map-pin"></i>
                                                        <h6>Downers Grove, IL</h6>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="location-box">
                                                        <i data-feather="mail"></i>
                                                        <h6>Ahmed@gmail.com</h6>
                                                    </div>
                                                </li>


                                            </ul>
                                        </div>

                                        <div class="profile-description">
                                            <p>Residences can be classified by and how they are connected to
                                                neighbouring residences and land. Different types of housing tenure can
                                                be used for the same physical type.</p>
                                        </div>
                                    </div>

                                    <div class="profile-about dashboard-bg-box">
                                        <div class="row">
                                            <div class="col-xxl-7">
                                                <div class="dashboard-title mb-3">
                                                    <h3>Profile About</h3>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>


                                                        <tr>
                                                            <td>Phone Number :</td>
                                                            <td>
                                                                <a href="javascript:void(0)"> +91 846 - 547 -
                                                                    210</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address :</td>
                                                            <td>549 Sulphur Springs Road, Downers, IL</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="dashboard-title mb-3">
                                                    <h3>Login Details</h3>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <td>Email :</td>
                                                            <td>
                                                                <a href="javascript:void(0)">Ahmed@gmail.com
                                                                    <span data-bs-toggle="modal"
                                                                          data-bs-target="#editProfile">Edit</span></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Password :</td>
                                                            <td>
                                                                <a href="javascript:void(0)">●●●●●●
                                                                    <span data-bs-toggle="modal"
                                                                          data-bs-target="#editProfile">Edit</span></a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-xxl-5">
                                                <div class="profile-image">
                                                    <img src="/website/images/inner-page/dashboard-profile.png"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- User Dashboard Section End -->

    <!-- Add address modal box start -->
    <div class="modal fade theme-modal" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a new address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" id="fname" placeholder="Enter First Name">
                            <label for="fname">First Name</label>
                        </div>
                    </form>

                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name">
                            <label for="lname">Last Name</label>
                        </div>
                    </form>

                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="email" class="form-control" id="email" placeholder="Enter Email Address">
                            <label for="email">Email Address</label>
                        </div>
                    </form>

                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="address"
                                      style="height: 100px"></textarea>
                            <label for="address">Enter Address</label>
                        </div>
                    </form>

                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="email" class="form-control" id="pin" placeholder="Enter Pin Code">
                            <label for="pin">Pin Code</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn theme-bg-color btn-md text-white" data-bs-dismiss="modal">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add address modal box end -->

    <!-- Location Modal Start -->
    <div class="modal location-modal fade theme-modal" id="locationModal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Choose your Delivery Location</h5>
                    <p class="mt-1 text-content">Enter your address and we will specify the offer for your area.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="location-list">
                        <div class="search-input">
                            <input type="search" class="form-control" placeholder="Search Your Area">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>

                        <div class="disabled-box">
                            <h6>Select a Location</h6>
                        </div>

                        <ul class="location-select custom-height">
                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Alabama</h6>
                                    <span>Min: EGP 130</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Arizona</h6>
                                    <span>Min: EGP 150</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>California</h6>
                                    <span>Min: EGP 110</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Colorado</h6>
                                    <span>Min: EGP 140</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Florida</h6>
                                    <span>Min: EGP 160</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Georgia</h6>
                                    <span>Min: EGP 120</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Kansas</h6>
                                    <span>Min: EGP 170</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Minnesota</h6>
                                    <span>Min: EGP 120</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>New York</h6>
                                    <span>Min: EGP 110</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0)">
                                    <h6>Washington</h6>
                                    <span>Min: EGP 130</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Location Modal End -->

    <!-- Edit Profile Start -->
    <div class="modal fade theme-modal" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel2"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-xxl-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="pname" value="Ahmed hassan">
                                    <label for="pname">Full Name</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-6">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="email" class="form-control" id="email1" value="ahmed@gmail.com">
                                    <label for="email1">Email address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-6">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input class="form-control" type="tel" value="4567891234" name="mobile" id="mobile"
                                           maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                            this.value.slice(0, this.maxLength);">
                                    <label for="mobile">Email address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address1"
                                           value="8424 James Lane South San Francisco">
                                    <label for="address1">Add Address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address2" value="CA 94080">
                                    <label for="address2">Add Address 2</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="floatingSelect1"
                                            aria-label="Floating label select example">
                                        <option selected>Choose Your Country</option>
                                        <option value="kindom">United Kingdom</option>
                                        <option value="states">United States</option>
                                        <option value="fra">France</option>
                                        <option value="china">China</option>
                                        <option value="spain">Spain</option>
                                        <option value="italy">Italy</option>
                                        <option value="turkey">Turkey</option>
                                        <option value="germany">Germany</option>
                                        <option value="russian">Russian Federation</option>
                                        <option value="malay">Malaysia</option>
                                        <option value="mexico">Mexico</option>
                                        <option value="austria">Austria</option>
                                        <option value="hong">Hong Kong SAR, China</option>
                                        <option value="ukraine">Ukraine</option>
                                        <option value="thailand">Thailand</option>
                                        <option value="saudi">Saudi Arabia</option>
                                        <option value="canada">Canada</option>
                                        <option value="singa">Singapore</option>
                                    </select>
                                    <label for="floatingSelect">Country</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="floatingSelect">
                                        <option selected>Choose Your City</option>
                                        <option value="kindom">India</option>
                                        <option value="states">Canada</option>
                                        <option value="fra">Dubai</option>
                                        <option value="china">Los Angeles</option>
                                        <option value="spain">Thailand</option>
                                    </select>
                                    <label for="floatingSelect">City</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address3" value="94080">
                                    <label for="address3">Pin Code</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                            data-bs-dismiss="modal">Close</button>
                    <button type="button" data-bs-dismiss="modal"
                            class="btn theme-bg-color btn-md fw-bold text-light">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile End -->

    <!-- Remove Profile Modal Start -->
    <div class="modal fade theme-modal remove-profile" id="removeProfile" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header d-block text-center">
                    <h5 class="modal-title w-100" id="exampleModalLabel22">Are You Sure ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box">
                        <p>The permission for the use/group, preview is inherited from the object, object will create a
                            new permission for this object</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                            data-bs-target="#removeAddress" data-bs-toggle="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade theme-modal remove-profile" id="removeAddress" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel12">Done!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box text-center">
                        <h4 class="text-content">It's Removed.</h4>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                            data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
