	<!-- Champion Awards Start Here-->
    <div class="{{isset($background) ? 'champion-section-page sec-spacer' : 'champion-awards-section sec-spacer'}}"
    >
     @if (!isset($background) )

      <div class="overly-bg"></div> @endif
        <div class="container">
            <h3 class="title-bg">@lang('messages.Championships awards')</h3>
            <div class="rs-carousel owl-carousel" data-loop="true" data-items="4" data-margin="30" data-autoplay="true" data-autoplay-timeout="8000" data-smart-speed="1500" data-dots="false" data-nav="false" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="4" data-md-device-nav="false" data-md-device-dots="false">

                @foreach ($championAwards as  $award)
                     <div class="champion-list">
                        <img src="{{$award->image}}" alt="champion award" style="width: 247px;height:323px" />
                        <div class="awards-content">
                            <h4 class="awards-title">{{$award->current_translation?->title}}</h4>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </div>
    <!-- Champion Awards end Here-->
