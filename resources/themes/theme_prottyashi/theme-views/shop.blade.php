@extends('theme-views.layouts.app')

@section('title', $web_config['name']->value.' '.translate('Online_Shopping').' | '.$web_config['name']->value.' '.translate('ecommerce'))
@push('css_or_js')
    <meta property="og:image" content="{{dynamicStorage(path: 'storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{dynamicStorage(path: 'storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
    {{--    <link rel="stylesheet" href="{{theme_asset(path: 'assets/css/home.css')}}"/>--}}
    {{--    <link rel="stylesheet" href="{{ theme_asset(path: 'assets/css/owl.carousel.min.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ theme_asset(path: 'assets/css/owl.theme.default.min.css') }}">--}}
@endpush

@section('content')
    <main class="main-content d-flex flex-column gap-3 py-0">
{{--                @include('theme-views.partials._main-banner')--}}
{{--        @include('theme-views.partials._hero-slide',['main_banner'=>$main_banner])--}}
                @php($decimalPointSettings = !empty(getWebConfig(name: 'decimal_point_settings')) ? getWebConfig(name: 'decimal_point_settings') : 0)
{{--                <section class="bg-transparent py-3">--}}
{{--                    <div class="container position-relative">--}}
{{--                        @include('theme-views.partials._main-banner',['main_banner'=>$main_banner])--}}
{{--                    </div>--}}
{{--                </section>--}}

{{--        @include('theme-views.partials._category-section-home-prottyashi')--}}

                @if ($web_config['flash_deals'])
                    @include('theme-views.partials._flash-deals')
                @endif
                <section class="bg-transparent py-3">
{{--                    <div class="container position-relative">--}}
{{--                        @include('theme-views.partials._find-what-you-need')--}}
{{--                    </div>--}}
                </section>
{{--                @if ($web_config['business_mode'] == 'multi' && count($topVendorsList) > 0)--}}
{{--                    @include('theme-views.partials._top-stores')--}}
{{--                @endif--}}

                @if ($web_config['featured_deals']->count() > 0 && $featured_deals->count() > 0 )
                    @include('theme-views.partials._featured-deals')
                @endif

                @include('theme-views.partials._recommended-product')
{{--                @if($web_config['business_mode'] == 'multi')--}}
{{--                    @include('theme-views.partials._more-stores')--}}
{{--                @endif--}}

                @include('theme-views.partials._top-rated-products')

{{--                @include('theme-views.partials._best-deal-just-for-you')--}}

{{--                @include('theme-views.partials._home-categories')--}}
{{--                @if (!empty($main_section_banner))--}}
{{--                <section class="">--}}
{{--                    <div class="container">--}}
{{--                        <div class="py-5 rounded position-relative">--}}
{{--                            <img src="{{ getValidImage(path: 'storage/app/public/banner/'.($main_section_banner ? $main_section_banner['photo'] : ''), type:'banner') }}"--}}
{{--                                 alt="" class="rounded position-absolute dark-support img-fit start-0 top-0 index-n1 flipX-in-rtl">--}}
{{--                            <div class="row justify-content-center">--}}
{{--                                <div class="col-10 py-4">--}}
{{--                                    <h6 class="text-primary mb-2 text-capitalize">{{ translate('do_not_miss_today`s_deal') }}!</h6>--}}
{{--                                    <h2 class="fs-2 mb-4 absolute-dark text-capitalize">{{ translate('let_us_shopping_today') }}</h2>--}}
{{--                                    <div class="d-flex">--}}
{{--                                        <a href="{{$main_section_banner ? $main_section_banner->url:''}}" class="btn btn-primary fs-16 text-capitalize">{{ translate('shop_now') }}</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </section>--}}
{{--                @endif--}}
    </main>
@endsection
@push('script')
    {{--    <script src="{{theme_asset(path: 'assets/js/owl.carousel.min.js')}}"></script>--}}
    {{--    <script src="{{ theme_asset(path: 'assets/js/home.js') }}"></script>--}}
    {{--    <script src="{{ theme_asset(path: 'assets/js/bootstrap.bundle.min.js') }}"></script>--}}
@endpush
