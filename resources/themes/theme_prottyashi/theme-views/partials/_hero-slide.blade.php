{{--<div class="row no-gutters position-relative rtl">--}}
{{--    <div class="col-12 col-xl-9 __top-slider-images">--}}
{{--        <div class="{{Session::get('direction') === "rtl" ? 'pr-xl-2' : 'pl-xl-2'}}">--}}
{{--            <div class="owl-theme owl-carousel hero-slider">--}}
{{--                @foreach($main_banner as $key=>$banner)--}}
{{--                    <a href="{{$banner['url']}}" class="d-block" target="_blank">--}}
{{--                        <img class="w-100 __slide-img" alt=""--}}
{{--                             src="{{ getValidImage(path: 'storage/app/public/banner/'.$banner['photo'], type: 'banner') }}">--}}
{{--                    </a>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<div id="banner-prottyashi" class="carousel slide" data-bs-ride="carousel" data-touch="true">
    <div class="carousel-inner">
        @foreach($main_banner as $key=>$banner)
            <div class="carousel-item {{$key == 0 ? 'active' : '' }}" data-bs-interval="5000">
                <a href="{{$banner['url']}}" class="d-block" target="_blank">
                    <img class="d-block" style="width:100%; height:100vh; object-fit: cover" alt="{{$banner['photo']}}"
                         src="{{ getValidImage(path: 'storage/app/public/banner/'.$banner['photo'], type: 'banner') }}">
                </a>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev"  role="button" data-slide="prev"  onclick="$('#banner-prottyashi').carousel('prev')">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
{{--        <span class="sr-only">Previous</span>--}}
    </a>
    <a class="carousel-control-next"   role="button" data-slide="next"  onclick="$('#banner-prottyashi').carousel('next')">
        <span class="carousel-control-next-icon" aria-hidden="true" style=""></span>
{{--        <span class="sr-only">Next</span>--}}
    </a>
</div>



