@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.register_new_account'))
@push("headStyle")
    @vite(['resources/js/single-components.js'])
@endpush
@section('body')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Register</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Register</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section auth-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row g-4 align-items-center">
                <div class="col-xxl-5 col-xl-6 col-lg-6 d-lg-block d-none">
                    <div class="image-contain">
                        <img src="{{asset('website/images/inner-page/sign-up.png')}}" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-7 col-xl-6 col-lg-6 col-sm-11 mx-auto">
                    <div class="auth-card">
                        <div class="auth-card-body">
                            <div class="auth-title">
                                <h3>Create your account</h3>
                                <p class="text-content">Fill in your information to complete registration.</p>
                            </div>

                            <form class="row g-3" id="registerForm" novalidate>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <strong>Account type</strong>
                                        <div class="required-hint">* Required</div>
                                    </div>

                                    <div class="account-type-grid">
                                        <div>
                                            <input class="btn-check" type="radio" name="accountType" id="typePerson" value="person" checked>
                                            <label class="account-type-option" for="typePerson">
                                                <div class="left">
                                                    <div class="icon"><i data-feather="user"></i></div>
                                                    <div class="text">
                                                        <h6>Person</h6>
                                                        <small>Individual</small>
                                                    </div>
                                                </div>
                                                <i data-feather="check"></i>
                                            </label>
                                        </div>

                                        <div>
                                            <input class="btn-check" type="radio" name="accountType" id="typeCompany" value="company">
                                            <label class="account-type-option" for="typeCompany">
                                                <div class="left">
                                                    <div class="icon"><i data-feather="briefcase"></i></div>
                                                    <div class="text">
                                                        <h6>Company</h6>
                                                        <small>Business</small>
                                                    </div>
                                                </div>
                                                <i data-feather="check"></i>
                                            </label>
                                        </div>

                                        <div>
                                            <input class="btn-check" type="radio" name="accountType" id="typeStudio" value="studio">
                                            <label class="account-type-option" for="typeStudio">
                                                <div class="left">
                                                    <div class="icon"><i data-feather="camera"></i></div>
                                                    <div class="text">
                                                        <h6>Studio</h6>
                                                        <small>Production</small>
                                                    </div>
                                                </div>
                                                <i data-feather="check"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="fullName" placeholder="Full name" required>
                                        <label for="fullName">Full name (as on national ID) *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="tel" class="form-control" id="mobile" placeholder="Mobile" required>
                                        <label for="mobile">Mobile number *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="tel" class="form-control" id="whatsapp" placeholder="WhatsApp" required>
                                        <label for="whatsapp">WhatsApp number *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Email" required>
                                        <label for="email">Email address *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="date" class="form-control" id="dob" required>
                                        <label for="dob">Date of birth (21+ years) *</label>
                                    </div>
                                    <div class="required-hint" id="dobError" style="display: none;">You must be at least 21 years old.</div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="url" class="form-control" id="socialProfile" placeholder="Profile link" required>
                                        <label for="socialProfile">Facebook / Instagram / LinkedIn profile link *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <select class="form-select" id="howDidYouHear" required>
                                            <option value="" selected disabled>Select</option>
                                            <option value="facebook">Facebook</option>
                                            <option value="instagram">Instagram</option>
                                            <option value="tiktok">TikTok</option>
                                            <option value="linkedin">LinkedIn</option>
                                            <option value="youtube">YouTube</option>
                                            <option value="google">Google</option>
                                            <option value="friend">Friend / Referral</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <label for="howDidYouHear">How did you hear about us? *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <select class="form-select" id="residence" required>
                                            <option value="" selected disabled>Select residence</option>
                                            <option value="cairo">Cairo</option>
                                            <option value="giza">Giza</option>
                                            <option value="alex">Alexandria</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <label for="residence">Current residence *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <select class="form-select" id="area" required>
                                            <option value="" selected disabled>Select area</option>
                                            <option value="nasr_city">Nasr City</option>
                                            <option value="heliopolis">Heliopolis</option>
                                            <option value="maadi">Maadi</option>
                                            <option value="dokki">Dokki</option>
                                            <option value="mohandeseen">Mohandeseen</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <label for="area">Area *</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password" placeholder="Password" required>
                                        <label for="password">Password *</label>
                                    </div>
                                </div>

                                <div class="col-12" id="businessFields" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-floating theme-form-floating">
                                                <input type="url" class="form-control" id="portfolio" placeholder="Portfolio link">
                                                <label for="portfolio">Portfolio / Previous work link *</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="commercialRegister" placeholder="Commercial register">
                                                <label for="commercialRegister">Commercial register *</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="taxCard" placeholder="Tax card">
                                                <label for="taxCard">Tax card *</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold" for="idFront">Attach national ID (front) *</label>
                                            <input type="file" class="form-control" id="idFront" accept="image/*" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold" for="idBack">Attach national ID (back) *</label>
                                            <input type="file" class="form-control" id="idBack" accept="image/*" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="businessUploads" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold" for="commercialRegisterFile">Upload commercial register *</label>
                                            <input type="file" class="form-control" id="commercialRegisterFile" accept="image/*,application/pdf">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold" for="taxCardFile">Upload tax card *</label>
                                            <input type="file" class="form-control" id="taxCardFile" accept="image/*,application/pdf">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check ps-0 m-0 remember-box">
                                        <input class="checkbox_animated check-box" type="checkbox" id="terms" required>
                                        <label class="form-check-label" for="terms">I agree with <span>Terms</span> and <span>Privacy</span></label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center" type="submit">Create account</button>
                                </div>
                            </form>

                            <div class="sign-up-box">
                                <h4>Already have an account?</h4>
                                <a href="login.html">Log In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

@endsection

