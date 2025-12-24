@extends('website.layouts.layoutPage')
@section('pageTitle',__('messages.Blog'))

@section('body')
    @include('website.layouts.breadcrump', ['currentPage' => __('messages.Blog')])

	  <!--start main content-->
  <main class="main-content">


    <section class="py-5">
      <div class="container px-3">
        <div class="row row-cols-1 row-cols-lg-3 g-4 g-lg-5">
        @foreach ($news as $blog)
          <div class="col">
            <div class="blog-post">
              <div class="grid-posts-img">
                <img src="{{ $blog->image }}" class="img-fluid rounded-3" alt="">
              </div>

              <div class="post-content mt-4">
                <div class="mb-3">
                  <a href="/blog-details/{{$blog->id}}-{{$blog->slug}}">
                    <h3 class="grid-posts-title fw-semibold">{{$blog->current_translation?->title}}</h3>
                  </a>
                </div>
                <p class="post-short-desc mb-0">{{$blog->current_translation?->description}}</p>
              </div>
            </div>
          </div>
        @endforeach

        </div><!--end row-->


        <!--pagination-->

         <div class="page-pagination d-flex justify-content-center">
            <nav class="mt-4">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                <li class="page-item {{ $news->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $news->previousPageUrl() ?? 'javascript:;' }}" aria-label="Previous">
                        <i class="bi bi-chevron-double-left"></i>
                    </a>
                </li>

                {{-- Pagination Elements --}}
                @foreach ($news->links()->elements[0] as $page => $url)
                    @if ($page == $news->currentPage())
                        <li class="page-item active"><a class="page-link" href="javascript:;">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                <li class="page-item {{ $news->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $news->nextPageUrl() ?? 'javascript:;' }}" aria-label="Next">
                        <i class="bi bi-chevron-double-right"></i>
                    </a>
                </li>
            </ul>
            </nav>
        </div>
        <!--end pagination-->

      </div>
    </section>

  </main>
  <!--end main content-->
@endsection
