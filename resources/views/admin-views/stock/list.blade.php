@extends('layouts.back-end.app')
@section('title', translate('stock_in_|_list'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-4 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                @php
                    $currentDateTime = new DateTime('now');
                @endphp
                    {{ translate('stock_In') }}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1"></span>
            </h2>
            <div class="card">
                <div class="card-body">
                    <form action="" method="GET">
{{--                        <input type="hidden" value="{{ request('status') }}" name="status">--}}
                        <div class="row gx-2">
                            <div class="col-12">
                                <h4 class="mb-3">{{ translate('filter_Stock_Ins') }}</h4>
                            </div>

                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label class="title-color" for="store">{{ translate('supplier') }}</label>
                                    <select name="brand_id" class="js-select2-custom form-control text-capitalize">
{{--                                        <option value="" selected>{{ translate('all_brand') }}</option>--}}
{{--                                        @foreach ($brands as $brand)--}}
{{--                                            <option value="{{ $brand->id}}" {{request('brand_id')==$brand->id ? 'selected' :''}}>{{ $brand->default_name }}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label class="title-color" for="store">{{ translate('From Date') }}</label>
                                    <input type="date" name="from_date" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <label class="title-color" for="store">{{ translate('To Date') }}</label>
                                    <input type="date" name="to_date" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4 col-xl-3 mt-4">
                                <div class="d-flex gap-2 justify-content-center">
{{--                                    <a href="{{ route('admin.products.list',['type'=>request('type')]) }}"--}}
{{--                                       class="btn btn-secondary px-5">--}}
{{--                                        {{ translate('reset') }}--}}
{{--                                    </a>--}}
                                    <button type="submit" class="btn btn--primary px-5 action-get-element-type">
                                        {{ translate('show_data') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-20">
                <div class="col-md-12">
                    <div class="card">
                        <div class="px-3 pt-3 pb-0">
                            <div class="row align-items-center">
                                <div class="col-xl-6 col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group input-group-custom input-group-merge">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="tio-search"></i>
                                                </div>
                                            </div>
                                            <input id="datatableSearch_" type="search" name="searchValue"
                                                   class="form-control"
                                                   placeholder="{{ translate('search_by_Product_Name') }}"
                                                   aria-label="Search orders"
                                                   value="{{ request('searchValue') }}">
                                            <input type="hidden" value="{{ request('status') }}" name="status">
                                            <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 d-flex flex-wrap gap-3 justify-content-end">
                                    <a href="{{route('admin.stock.add-new')}}" class="btn btn--primary">
                                        <i class="tio-add"></i>
                                        <span class="text">{{ translate('add_new_stock') }}</span>
                                    </a>
                                </div>


                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable"
                                   class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                                <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ translate('SL') }}</th>
                                    <th>{{ translate('Reference No') }}</th>
                                    <th class="text-center">{{ translate('Supplier') }}</th>
                                    <th class="text-center">{{ translate('Status') }}</th>
                                    <th class="text-center">{{ translate('Date') }}</th>
                                    <th class="text-center">{{ translate('action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($stocks as $key=>$stock)
                                    <tr>
                                        <th>{{$key + 1}}</th>
                                        <td>{{$stock->ref_no}}</td>
                                        <td class="text-center">{{$stock->shop->name}}</td>
                                        <td class="text-center">
                                            @if($stock->status=="pending")
                                                <span class="badge badge-soft-info fz-12">Pending</span>
                                            @endif
                                            @if($stock->status=="received")
                                                <span class="badge badge-soft-info fz-12">Received</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{\Carbon\Carbon::parse($stock->date_time)->format('d-m-Y')}}</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a class="btn btn-outline-info btn-sm square-btn" title="View"
                                                   href="">
                                                    <i class="tio-invisible"></i>
                                                </a>
                                                <a class="btn btn-outline--primary btn-sm square-btn"
                                                   title="{{ translate('edit') }}"
                                                   href="">
                                                    <i class="tio-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
{{--                                @foreach($products as $key=>$product)--}}
{{--                                    <tr>--}}
{{--                                        <th scope="row">{{ $products->firstItem()+$key}}</th>--}}
{{--                                        <td>--}}
{{--                                            <a href="{{ route('admin.products.view',['addedBy'=>($product['added_by']=='seller'?'vendor' : 'in-house'),'id'=>$product['id']]) }}"--}}
{{--                                               class="media align-items-center gap-2">--}}
{{--                                                <img src="{{ getValidImage(path: 'storage/app/public/product/thumbnail/'.$product['thumbnail'], type: 'backend-product') }}"--}}
{{--                                                     class="avatar border" alt="">--}}
{{--                                                <span class="media-body title-color hover-c1">--}}
{{--                                            {{ Str::limit($product['name'], 20) }}--}}
{{--                                        </span>--}}
{{--                                            </a>--}}
{{--                                        </td>--}}
{{--                                        <td class="text-center">--}}
{{--                                            {{ translate(str_replace('_',' ',$product['product_type'])) }}--}}
{{--                                        </td>--}}
{{--                                        <td class="text-center">--}}
{{--                                            {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $product['unit_price']), currencyCode: getCurrencyCode()) }}--}}
{{--                                        </td>--}}
{{--                                        <td class="text-center">--}}

{{--                                            @php($productName = str_replace("'",'`',$product['name']))--}}
{{--                                            <form action="{{ route('admin.products.featured-status') }}" method="post"--}}
{{--                                                  id="product-featured{{ $product['id']}}-form">--}}
{{--                                                @csrf--}}
{{--                                                <input type="hidden" name="id" value="{{ $product['id']}}">--}}
{{--                                                <label class="switcher mx-auto">--}}
{{--                                                    <input type="checkbox" class="switcher_input toggle-switch-message"--}}
{{--                                                           name="status"--}}
{{--                                                           id="product-featured{{ $product['id'] }}" value="1"--}}
{{--                                                           {{ $product['featured'] == 1 ? 'checked' : '' }}--}}
{{--                                                           data-modal-id="toggle-status-modal"--}}
{{--                                                           data-toggle-id="product-featured{{ $product['id'] }}"--}}
{{--                                                           data-on-image="product-status-on.png"--}}
{{--                                                           data-off-image="product-status-off.png"--}}
{{--                                                           data-on-title="{{ translate('Want_to_Add').' '.$productName.' '.translate('to_the_featured_section') }}"--}}
{{--                                                           data-off-title="{{ translate('Want_to_Remove').' '.$productName.' '.translate('to_the_featured_section') }}"--}}
{{--                                                           data-on-message="<p>{{ translate('if_enabled_this_product_will_be_shown_in_the_featured_product_on_the_website_and_customer_app') }}</p>"--}}
{{--                                                           data-off-message="<p>{{ translate('if_disabled_this_product_will_be_removed_from_the_featured_product_section_of_the_website_and_customer_app') }}</p>">--}}
{{--                                                    <span class="switcher_control"></span>--}}
{{--                                                </label>--}}
{{--                                            </form>--}}

{{--                                        </td>--}}
{{--                                        <td class="text-center">--}}
{{--                                            <form action="{{ route('admin.products.status-update') }}" method="post" data-from="product-status"--}}
{{--                                                  id="product-status{{ $product['id']}}-form" class="admin-product-status-form">--}}
{{--                                                @csrf--}}
{{--                                                <input type="hidden" name="id" value="{{ $product['id']}}">--}}
{{--                                                <label class="switcher mx-auto">--}}
{{--                                                    <input type="checkbox" class="switcher_input toggle-switch-message"--}}
{{--                                                           name="status"--}}
{{--                                                           id="product-status{{ $product['id'] }}" value="1"--}}
{{--                                                           {{ $product['status'] == 1 ? 'checked' : '' }}--}}
{{--                                                           data-modal-id="toggle-status-modal"--}}
{{--                                                           data-toggle-id="product-status{{ $product['id'] }}"--}}
{{--                                                           data-on-image="product-status-on.png"--}}
{{--                                                           data-off-image="product-status-off.png"--}}
{{--                                                           data-on-title="{{ translate('Want_to_Turn_ON').' '.$productName.' '.translate('status') }}"--}}
{{--                                                           data-off-title="{{ translate('Want_to_Turn_OFF').' '.$productName.' '.translate('status') }}"--}}
{{--                                                           data-on-message="<p>{{ translate('if_enabled_this_product_will_be_available_on_the_website_and_customer_app') }}</p>"--}}
{{--                                                           data-off-message="<p>{{ translate('if_disabled_this_product_will_be_hidden_from_the_website_and_customer_app') }}</p>">--}}
{{--                                                    <span class="switcher_control"></span>--}}
{{--                                                </label>--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <div class="d-flex justify-content-center gap-2">--}}
{{--                                                <a class="btn btn-outline-info btn-sm square-btn"--}}
{{--                                                   title="{{ translate('barcode') }}"--}}
{{--                                                   href="{{ route('admin.products.barcode', [$product['id']]) }}">--}}
{{--                                                    <i class="tio-barcode"></i>--}}
{{--                                                </a>--}}
{{--                                                <a class="btn btn-outline-info btn-sm square-btn" title="View"--}}
{{--                                                   href="{{ route('admin.products.view',['addedBy'=>($product['added_by']=='seller'?'vendor' : 'in-house'),'id'=>$product['id']]) }}">--}}
{{--                                                    <i class="tio-invisible"></i>--}}
{{--                                                </a>--}}
{{--                                                <a class="btn btn-outline--primary btn-sm square-btn"--}}
{{--                                                   title="{{ translate('edit') }}"--}}
{{--                                                   href="{{ route('admin.products.update',[$product['id']]) }}">--}}
{{--                                                    <i class="tio-edit"></i>--}}
{{--                                                </a>--}}
{{--                                                <span class="btn btn-outline-danger btn-sm square-btn delete-data"--}}
{{--                                                      title="{{ translate('delete') }}"--}}
{{--                                                      data-id="product-{{ $product['id']}}">--}}
{{--                                                <i class="tio-delete"></i>--}}
{{--                                            </span>--}}
{{--                                            </div>--}}
{{--                                            <form action="{{ route('admin.products.delete',[$product['id']]) }}"--}}
{{--                                                  method="post" id="product-{{ $product['id']}}">--}}
{{--                                                @csrf @method('delete')--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
                                </tbody>
                            </table>
                        </div>

{{--                        <div class="table-responsive mt-4">--}}
{{--                            <div class="px-4 d-flex justify-content-lg-end">--}}
{{--                                {{ $products->links() }}--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        @if(count($products)==0)--}}
{{--                            @include('layouts.back-end._empty-state',['text'=>'no_product_found'],['image'=>'default'])--}}
{{--                        @endif--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
