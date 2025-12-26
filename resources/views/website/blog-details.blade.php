@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Blog Details'))

@section('body')

    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Blog Details Page</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{route('web.home')}}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Blog</li>
                                <li class="breadcrumb-item active" aria-current="page">Blog Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Details Section Start -->
    <section class="blog-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-12 col-xl-12 col-lg-12 ratio_50">
                    <div class="blog-detail-image rounded-3 mb-4">
                        <img src="{{asset('website/images/veg-3/home/19.jpg')}}" class="bg-img blur-up lazyload" alt="">
                        <div class="blog-image-contain">
                            <ul class="contain-list">
                                <li>Cameras</li>
                                <li>Camera fasdfs</li>
                                <li>fvdasf</li>
                            </ul>
                            <h2>Sony Alpha a7 IV Mirrorless Digital Camera Sony Alpha a7 IV Mirrorless </h2>
                            <ul class="contain-comment-list">

                                <li>
                                    <div class="user-list">
                                        <i data-feather="calendar"></i>
                                        <span>April 19, 2022</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="blog-detail-contain">
                        <p><span class="first">S</span> hotgun approach message the initiative so can I just chime in
                            on that one. Make sure to include in your wheelhouse bells and whistles, and touch base
                            slow-walk our commitment nor what's the status on the deliverables for eow?. Create spaces
                            to explore whatâ€™s next commitment to the cause , or UI, for get buy-in but draw a line in
                            the sand, and pig in a python we've got kpis for that. Message the initiative value prop,
                            please use "solutionise" instead of solution ideas! :) i am dead inside. Quick sync
                            4-blocker. Driving the initiative forward flesh that out.</p>

                        <p>Let's unpack that later everyone thinks the soup tastes better after theyâ€™ve pissed in it
                            pivot, re-inventing the wheel, and it's not hard guys. Market-facing pushback back of the
                            net, for pro-sumer software let's see if we can dovetail these two projects but turn the
                            crank for they have downloaded gmail and seems to be working for now. This is not the hill i
                            want to die on you better eat a reality sandwich before you walk back in that boardroom land
                            the plane yet exposing new ways to evolve our design language design thinking nor poop, so
                            can you put it into a banner that is not alarming, but eye catching and not too giant. That
                            is a good problem to have dog and pony show we're ahead of the curve on that one.</p>

                        <p> Waste of
                            resources can you run this by clearance? hot johnny coming through driving the
                            initiative
                            forward our competitors are jumping the shark. Unlock meaningful moments of relaxation.
                            Copy
                            and paste from stack overflow a tentative event rundown is attached for your reference,
                            including other happenings on the day you are most welcome to join us beforehand for a
                            light
                            lunch we would also like to invite you to other activities on the day, including the
                            interim
                            and closing panel discussions on the intersection of businesses and social innovation,
                            and
                            on building a stronger social innovation eco-system respectively what are the
                            expectations,
                            on-brand but completeley fresh we can't hear you.</p>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->
@endsection
