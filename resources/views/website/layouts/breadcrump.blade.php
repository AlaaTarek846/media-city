
 <!--start breadcrumb-->
<section class="section-breadcrumb bg-img-page-header d-flex align-items-center justify-content-center">
    <div class="container px-3 d-flex flex-column align-items-center justify-content-center">
    <h2>{{$currentPage}}</h2>
    <nav>
        <ol class="breadcrumb mb-0 gap-2">
        <li class="breadcrumb-item"><a href="/" class="breadcrumb-link">@lang("messages.homePage")</a></li>
        @if (isset($parentPage))
        <li><i class="bi bi-chevron-right"></i></li>
        <li class="breadcrumb-item"><a href="/{{$parentPageUri}}" class="breadcrumb-link">{{$parentPage}}</a></li>
        @endif
        <li><i class="bi bi-chevron-right"></i></li>
        <li class="breadcrumb-item breadcrumb-active">{{$currentPage}}</li>
        </ol>
    </nav>
    </div>
</section>
<!--end breadcrumb-->
