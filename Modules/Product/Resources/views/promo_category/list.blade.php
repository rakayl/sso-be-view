<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs            = session('configs');

?>
@extends('layouts.main')
@include('infinitescroll')
@section('page-style')
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@yield('is-style')
<style>
    .btn{
        margin:0 !important;
    }
</style>
@endsection

@section('page-script')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
@yield('is-script')
<script type="text/javascript">
    $('.sortable').sortable({
        items: '> .can-sort',
        handle:'.handle',
        stop: function(){
            const id_promo_category = [];
            $('.input-id-product-promo-category').each(function(idx,val){
                id_promo_category.push($(val).val());
            });
            $.ajax({
                method: 'POST',
                url: "{{url('product/promo-category/reorder')}}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id_product_promo_category: id_promo_category
                },
                success: function(response) {
                    if(response.status == 'success'){
                        toastr.info("Success reorder promo category");
                    }else{
                        toastr.warning("Failed reorder promo category");
                    }
                }
            });
        }});
    function enableConfirmation(table,response){
        $(`.page${table.data('page')+1} [data-toggle='confirmation']`).confirmation({
            'btnOkClass':'btn btn-sm green',
            'btnCancelClass':'btn btn-sm red',
            'placement':'left'
        });
        table.parents('.is-container').find('.total-record').text(response.total?response.total:0).val(response.total?response.total:0);
    }
    $(document).ready(function(){
        template = {
            productgroup: function(item){
                return `
                <tr class="page${item.page} can-sort">
                    <td class="text-center handle">
                        <i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i>
                        <input type="hidden" class="input-id-product-promo-category" value="${item.id_product_promo_category}"/>
                    </td>
                    <td>${item.product_promo_category_name}</td>
                    <td>${item.products_count}</td>
                    <td>
                      <div>
                        <form action="{{url('product/promo-category/delete')}}" class="form-inline" method="POST">
                          <a href="{{url('product/promo-category')}}/${item.id_product_promo_category}" target="_blank" class="btn btn-sm blue"><i class="fa fa-pencil"></i></a>
                          @csrf
                          <input type="hidden" name="id_product_promo_category" value="${item.id_product_promo_category}">
                          <button class="btn btn-sm red deleteBtn" data-toggle="confirmation" data-title="Are you sure delete this product category?" type="submit"><i class="fa fa-trash-o"></i></button>
                        </form>
                      </div>
                    </td>
                </tr>
                `;
            }
        };
    })
</script>
@endsection

@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="/">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{ $title }}</span>
            @if (!empty($sub_title))
            <i class="fa fa-circle"></i>
            @endif
        </li>
        @if (!empty($sub_title))
        <li>
            <span>{{ $sub_title }}</span>
        </li>
        @endif
    </ul>
</div><br>

@include('layouts.notifications')

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject sbold uppercase font-blue">List Promo Category</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class=" table-responsive is-container">
            <div class="row">
                <div class="col-md-offset-9 col-md-3">
                    <form class="filter-form">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control search-field" name="keyword" placeholder="Search">
                                <div class="input-group-btn">
                                    <button class="btn blue search-btn" type="submit"><i class="fa fa-search"></i></button>
                                    <a class="btn green-dark search-btn" href="{{url('product/promo-category')}}"><i class="fa fa-trash-o"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="alert alert-info">Drag [<i class="fa fa-ellipsis-h" style="transform: rotate(90deg);"></i>] handle button to reorder promo category</div>
            <div class="table-infinite">
                <table class="table table-striped" id="tableTrx" data-template="productgroup"  data-page="0" data-is-loading="0" data-is-last="0" data-url="{{url()->current()}}" data-callback="enableConfirmation" data-order="promo_campaign_referral_transactions.created_at" data-sort="asc">
                    <thead>
                        <tr>
                            <th style="width: 1%" class="text-center">#</th>
                            <th>Name</th>
                            <th>Products</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="sortable">
                    </tbody>
                </table>
            </div>
            <div><span class="text-muted">Total record: </span><span class="total-record"></span></div>
        </div>
    </div>
</div>


@endsection