@if ($categories->count() > 0 )
    <section class="pb-4 rtl">
        <div class="container">
            <div>
{{--                <div class="card __shadow h-100 max-md-shadow-0">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex justify-content-between">--}}
{{--                            <div class="categories-title m-0">--}}
{{--                                <span class="font-semibold">{{ translate('categories')}}</span>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <a class="text-capitalize view-all-text web-text-primary"--}}
{{--                                   href="{{route('categories')}}">{{ translate('view_all')}}--}}
{{--                                    <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left mr-1 ml-n1 mt-1 float-left' : 'right ml-1 mr-n1'}}"></i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="categories-title m-0 d-flex justify-content-center my-5">
                            <span style="font-size: 20px; color:var(--bs-primary); display:{{Request::is('collections')?'none':'block'}};">{{ translate('NATURAL,_HANDMADE_&_FAIR_TRADE_HOME_DECOR')}}</span>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="d-flex flex-wrap justify-content-center gap-5 w-100">
                                @foreach($categories as $key => $category)
                                    @if ($key<10)
                                        <div class="text-center mb-5" style="width: 30%;">
                                            <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                                <div class="__img aspect-prottyashi">
                                                    <img alt="{{ $category->name }}"
                                                         src="{{ getValidImage(path: 'storage/app/public/category/'.$category->icon, type: 'category') }}">
                                                </div>
{{--                                                <p class="text-center fs-13 font-semibold mt-2">{{Str::limit($category->name, 12)}}</p>--}}
                                                <p class="text-center fs-13 font-semibold mt-3" style="text-transform: uppercase;color:var(--bs-primary)">{{$category->name}}</p>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="d-md-none">
                            <div class="owl-theme owl-carousel categories--slider mt-3 mb-5">
                                @foreach($categories as $key => $category)
                                    @if ($key<10)
                                        <div class="text-center m-0 __cate-item w-100">
                                            <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                                <div class="__img mw-100 h-auto">
                                                    <img alt="{{ $category->name }}"
                                                         src="{{ getValidImage(path: 'storage/app/public/category/'.$category->icon, type: 'category') }}">
                                                </div>
                                                <p class="text-center small mt-2" style="color:var(--bs-primary)">{{Str::limit($category->name, 12)}}</p>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </section>
@endif
