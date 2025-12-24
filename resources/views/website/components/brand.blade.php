<!--start brands-->
    <section class="special-offer py-5">
      <div class="container px-3">
        <div class="d-flex align-items-center justify-content-center mb-4">
          <h2 class="section-title">@lang('messages.Our Brands')</h2>
        </div>
        <div class="">
          <div class="row row-cols-1 row-cols-lg-5 g-4">
          @foreach ($brands as  $brand)
            <div class="col">
              <div class="brand-logo p-3 border rounded-3">
                <img src="{{$brand->image}}" class="img-fluid" alt="">
              </div>
            </div>
        @endforeach
          </div><!--end row-->
        </div>
      </div>
    </section>
    <!--end brands-->
