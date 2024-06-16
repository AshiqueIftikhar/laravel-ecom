@extends('layouts.back-end.app')
@section('title', translate('stock_list'))
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
                @if($type == 'in_house')
                    {{ translate('add_to_Stock_/_Stock_In') }}
                @elseif($type == 'seller')
                    {{ translate('vendor_Product_List') }}
                @endif
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1"></span>
            </h2>
            @if($errors->any())
                <ul class="alert alert-danger list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            @endif
                            {{--            FORM--}}
            <form action="{{route('admin.stock.store')}}" method="POST" id='data-stock'>
                @csrf
                @if($errors->any())
                    <ul class="alert alert-danger list-unstyled">
                        @foreach($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="col-lg-12 mb-4 mb-lg-0">
                    <div class="card">
                        <div class="px-3 py-3">
                            <div class="row gy-1">
                                <div class="col-sm-3">
                                        <label for="search">Search</label>
                                        <div class="input-group-overlay input-group-merge input-group-custom">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="tio-search"></i>
                                                </div>
                                            </div>
                                            <input id="search" autocomplete="off" type="text"
                                                   value="{{ $searchValue }}"
                                                   name="searchValue" class="form-control search-bar-input"
                                                   placeholder="{{ translate('search_by_name_or_sku') }}"
                                                   aria-label="Search here">
                                            <diV class="card pos-search-card w-4 position-absolute z-index-1 w-100">
                                                <div id="pos-search-box"
                                                     class="card-body search-result-box d-none "></div>
                                            </diV>
                                        </div>
                                </div>
                                <div class="col-sm-6 col-lg-4 col-xl-2">
                                    <div class="form-group">
                                        <label class="title-color" for="store">{{translate('Vendor')}}</label>
                                        <select name="seller_id" id="seller_id" class="form-control">
                                            <option value="0">{{translate('none')}}</option>
                                              @foreach ($sellers as $seller)
                                                @isset($seller->shop)
                                                    <option value="{{$seller->id}}"{{request('seller_id') == $seller->id ? 'selected' :''}}>
                                                        {{ $seller->shop->name }}
                                                    </option>
                                                @endisset
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="variations">Warehouse</label>
                                    <input type="text" readonly class="form-control" id="warehouse_id" name="warehouse_id" value="Inhouse">
                                </div>
                                <div class="col-sm-2">
                                    <label for="variations">Date</label>
                                    <input type="date" class="form-control" name="date-time" id="date-time" value="{{$currentDateTime->format('Y-m-d')}}">
                                </div>
                                <div class="col-sm-3">
                                    <span class="style-one-pro cursor-pointer user-select-none text--primary action-onclick-generate-number" data-input="#generate_number">
                                        {{ translate('new_Ref._No.') }}
                                    </span>
                                    <input type="text" minlength="6" id="generate_number" name="refNo"
                                           class="form-control mt-2 ref-no" value="{{ old('refNo') }}"
                                           placeholder="{{ translate('Ref No').': 161183'}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-2 mt-3">
                    <div class="card billing-section-wrap">
                        <h5 class="p-3 m-0 bg-light">{{ translate('Product List') }}</h5>
                        <div class="card-body">
                            @include('admin-views.stock.partials._table_two')
                            <div id="cart-summary">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end gap-3 mt-3 mx-1">
                        <button id="submit-stock" type="button" class="btn btn--primary px-5 m-0 action-form-submit" data-message="{{translate('want_to_store_the_items').'?'}}" data-toggle="modal" data-target="#stockModal">{{ translate('submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade pt-5" id="quick-view" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="quick-view-modal"></div>
        </div>
    </div>

{{--    <div class="alert alert--message-3 alert--message-for-pos border-bottom alert-dismissible fade show d-none">--}}
{{--        <img width="28" src="{{ dynamicAsset(path: 'public/assets/back-end/img/warning.png') }}" alt="">--}}
{{--        <div class="w-0">--}}
{{--            <h6>{{ translate('Warning').'!'}}</h6>--}}
{{--            <span class="warning-message"></span>--}}
{{--        </div>--}}
{{--        <button type="button" class="close position-relative p-0 close-alert--message-for-pos">--}}
{{--            <span aria-hidden="true">&times;</span>--}}
{{--        </button>--}}
{{--    </div>--}}

    <span id="message-please-choose-all-the-options" data-text="{{ translate('please_choose_all_the_options') }}"></span>
    <span id="route-admin-products-search-product" data-url="{{ route('admin.pos.search-product') }}"></span>
    <span id="route-admin-pos-stock-quick-view" data-url="{{ route('admin.stock.stock-quick-view') }}"></span>
    <span id="route-admin-pos-get-variant-price" data-url="{{ route('admin.pos.get-variant-price') }}"></span>

    <span id="message-stock-in-seller-id" data-text="{{ translate('No_vendor_selected') }}"></span>
    <span id="message-stock-in-warehouse" data-text="{{ translate('No_warehouse_selected') }}"></span>
    <span id="message-stock-in-date-time" data-text="{{ translate('Date-Time_not_provided') }}"></span>
    <span id="message-stock-in-ref-no" data-text="{{ translate('Ref._no._not_provided') }}"></span>
    <span id="message-stock-in-product" data-text="{{ translate('No_product_in_list') }}"></span>

@endsection
@push('script_2')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/stock-script.js') }}"></script>
@endpush
