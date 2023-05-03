@extends('layouts.main')
@include('filter-list-achievement')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@yield('is-style')
    <style>
        .dropleft .dropdown-menu{
        	top: -100% !important;
        	left: -180px !important;
        	right: auto;
        }
		.btn-group > .dropdown-menu::after, .dropleft > .dropdown-toggle > .dropdown-menu::after, .dropdown > .dropdown-menu::after {
            opacity: 0;
		}
		.btn-group > .dropdown-menu::before, .dropleft > .dropdown-toggle > .dropdown-menu::before, .dropdown > .dropdown-menu::before {
            opacity: 0;
		}
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@yield('is-script')
<script>
    template = {
        differentprice: function(item){
            const publish_start = item.publish_start?(new Date(item.publish_start).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"})):'Not set';
            const publish_end = item.publish_end?(new Date(item.publish_end).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"})):'Not set';
            const date_start = item.date_start?(new Date(item.date_start).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"})):'Not set';
            const date_end = item.date_end?(new Date(item.date_end).toLocaleString('id-ID',{day:"2-digit",month:"short",year:"numeric"})):'Not set';
            return `
            <tr class="page${item.page}">
                <td class="text-center">${item.increment}</td>
                <td>${item.category_name}</td>
                <td>${item.name}</td>
                <td>${date_start}</td>
                <td>${date_end}</td>
                <td>${item.total_user}</td>
                <td>
                    <div class="btn-group btn-group-solid pull-right dropleft">
                        <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div id="loadingBtn" hidden>
                                <i class="fa fa-spinner fa-spin"></i> Loading
                            </div>
                            <div id="moreBtn">
                                <i class="fa fa-ellipsis-horizontal"></i> More
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown">
                            <li style="margin: 0px;">
                                <a href="#editBadge" data-toggle="modal" onclick="editBadge(${item})"> Edit </a>
                            </li>
                            <li style="margin: 0px;">
                                <a href="{{url('achievement/detail/${item.id_achievement_group}')}}/"> Detail </a>
                            </li>
                            <li style="margin: 0px;">
                                <a href="javascript:;" onclick="removeAchievement(this, ${item.id_achievement_group})"> Remove </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            `;
        }
    };
    function removeAchievement(params, data) {
        var btn = $(params).parent().parent().parent().before().children()
        btn.find('#loadingBtn').show()
        btn.find('#moreBtn').hide()
        $.post( "{{ url('achievement/remove') }}", { id_achievement_group: data, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            console.log(data)
            if (data.status == 'success') {
                var removeDiv = $(params).parents()[4]
                removeDiv.remove()
            }
            btn.find('#loadingBtn').hide()
            btn.find('#moreBtn').show()
        });
    }
    function updater(table,response){
    }
    $(document).ready(function(){
        $('.is-container').on('change','.checkbox-different',function(){
            var status = $(this).is(':checked')?1:0;
            if($(this).data('auto')){
                $(this).data('auto',0);
            }else{
                const selector = $(this);
                $.post({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    url: "{{url('outlet/different-price/update')}}",
                    data: {
                        ajax: 1,
                        id_outlet: $(this).data('id'),
                        status: status
                    },
                    success: function(response){
                        selector.data('auto',1);
                        if(response.status == 'success'){
                            toastr.info("Update success");
                            if(response.result == '1'){
                                selector.prop('checked',true);
                            }else{
                                selector.prop('checked',false);
                            }
                        }else{
                            toastr.warning("Update fail");
                            if(status == 1){
                                selector.prop('checked',false);
                            }else{
                                selector.prop('checked',true);
                            }
                        }
                        selector.change();
                    },
                    error: function(data){
                        toastr.warning("Update fail");
                        selector.data('auto',1);
                        if(status == 1){
                            selector.prop('checked',false);
                        }else{
                            selector.prop('checked',true);
                        }
                        selector.change();
                    }
                });
            }
        });
        function categoryClick() {
            $('#filter_by').val('category')
            $('#user_filter').val('')
            $('#btnAchievementFilter').replaceWith( '<span id="btnAchievementFilter">Category</span>' );
            console.log('name');
        }
        function achievementClick() {
            $('#filter_by').val('achievement')
            $('#user_filter').val('')
            $('#btnAchievementFilter').replaceWith( '<span id="btnAchievementFilter">Achievement</span>' );
            console.log('name');
        }
    });
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
                <span class="caption-subject font-blue sbold uppercase">Achievement List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class=" table-responsive is-container">
                <form class="filter-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn green dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span id="btnAchievementFilter">Category</span>
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:;" onclick="categoryClick()"> Category </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" onclick="achievementClick()"> Achievement </a>
                                        </li>
                                    </ul>
                                </div>
                                <input type="hidden" class="form-control" id="filter_by" name="filter_by" value="category">
                                <input type="text" class="form-control" id="user_filter" name="user_filter">
                            </div>
                        </div>
                        {{-- <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control daterange" name="date_range">
                                <span class="input-group-btn">
                                    <button class="btn default date-range-toggle" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Achievement Rule
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Detail Achievement Name" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-9">
                                    <div class="mt-checkbox-inline">
                                        <label class="mt-checkbox" style="margin-left: 15px;">
                                            <input type="checkbox" class="rule_trx"> Transaction
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox">
                                            <input type="checkbox" class="rule_product"> Product
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox">
                                            <input type="checkbox" class="rule_total"> Total
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox">
                                            <input type="checkbox" class="rule_additional"> Additional
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group trx_rule_form" hidden>
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Achievement Transaction Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the achievement is not based on the transaction" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control digit_mask" name="detail[0][trx_nominal]" placeholder="Transaction Nominal">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group product_rule_form" hidden>
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Achievement Product Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the achievement is not based on the product" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[0][id_product]">
                                            <option></option>
                                            @foreach ($product as $item)
                                                <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="detail[0][product_total]" placeholder="Total Product">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group total_rule_form" hidden>
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Achievement Total Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the achievement is not based on the transaction" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <select class="form-control select2-multiple" name="detail[0][rule_total]" id="total_rule" data-placeholder="Select Total Rule By">
                                                <option></option>
                                                <option value="total_transaction">Transaction</option>
                                                <option value="total_outlet">Outlet Different</option>
                                                <option value="total_province">Province Different</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control digit_mask" name="detail[0][value_total]" placeholder="Value Total">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group additional_rule_form" hidden>
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Achievement Additional Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the achievement is not based on the product" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4" id="select_outlet">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple" data-placeholder="Select Outlet" name="detail[0][id_outlet]">
                                            <option></option>
                                            @foreach ($outlet as $item)
                                                <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="select_province">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple" data-placeholder="Select Province" name="detail[0][id_province]">
                                            <option></option>
                                            @foreach ($province as $item)
                                                <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button class="btn blue search-btn" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-achievement">
                    <table class="table table-striped" id="tableTrx" data-template="differentprice"  data-page="0" data-is-loading="0" data-is-last="0" data-url="{{url()->current()}}" data-callback="updater" data-order="promo_campaign_referral_transactions.created_at" data-sort="asc">
                        <thead>
                            <tr>
                                <th style="width: 1%" class="text-center">No</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Achievement Start</th>
                                <th>Achievement End</th>
                                <th>Total User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div><span class="text-muted">Total record: </span><span class="total-record"></span></div>
            </div>
        </div>
    </div>



@endsection
