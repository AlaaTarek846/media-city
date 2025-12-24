<!doctype html>
<html lang="{{app()->getLocale()}}">
	@include('website.layouts.headStyle')
	<body >
        @php
            $joinUs = \App\Models\JoinUs::first();
            $contactUs = \App\Models\ContactUs::first();
            $topCategories = \App\Models\Category::where('status',1)
                ->whereHas('products', function($query){
                    $query->where('status',1);
                })
                ->inRandomOrder()
                ->take(6)
                ->get();

        @endphp
        <div id="app">
        @include('website.layouts.header',['joinUs' => $joinUs ])


        @yield('body')
        </div>

        @include('website.layouts.footer',['joinUs' => $joinUs , 'contactUs' => $contactUs , 'topCategories' => $topCategories])

        <!--JS file-->
        <script src="/website/js/jquery.min.js" ></script>
        <script src="/website/js/bootstrap.bundle.min.js" ></script>

        <!-- Swiper JS -->
        <script src="/website/plugins/swiper/js/swiper-bundle.min.js" defer></script>
        <script src="/website/js/search-slider.js" defer></script>
        <!-- Initialize Swiper -->
        <script src="/website/js/index.js" defer></script>
        <!-- Initialize Swiper -->

        <script src="/website/js/product-details.js" defer></script>

        <script src="/website/js/main.js" defer></script>



	</body>

    <script>'undefined'=== typeof _trfq || (window._trfq = []);'undefined'=== typeof _trfd && (window._trfd=[]),_trfd.push({'tccl.baseHost':'secureserver.net'},{'ap':'cpsh-oh'},{'server':'p3plzcpnl509132'},{'dcenter':'p3'},{'cp_id':'10399385'},{'cp_cl':'8'}) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.</script><script src='../../img1.wsimg.com/signals/js/clients/scc-c2/scc-c2.min.js'></script>
<!-- Mirrored from codervent.com/shopnest/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Jul 2025 14:01:16 GMT -->
</html>


