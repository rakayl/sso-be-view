<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')
@include('infinitescroll')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
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
        .modal-open .select2-container--open { z-index: 999999 !important; width:100% !important; }
    </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
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
                <td>${publish_start}</td>
                <td>${publish_end}</td>
                <td>${date_start}</td>
                <td>${date_end}</td>
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
                            @if(MyHelper::hasAccess([224], $grantedFeature))
                            <li style="margin: 0px;">
                                <a href="#editAchievement" data-toggle="modal" onclick="editAchievement(${item.id_achievement_group})"> Edit </a>
                            </li>
                            @endif
                            <li style="margin: 0px;">
                                <a href="{{url('achievement/detail/${item.id_achievement_group}')}}/"> Detail </a>
                            </li>
                            @if(MyHelper::hasAccess([225], $grantedFeature))
                            <li style="margin: 0px;">
                                <a href="javascript:;" onclick="removeAchievement(this, ${item.id_achievement_group})"> Remove </a>
                            </li>
                            @endif
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
            if (data.status == 'success') {
                var removeDiv = $(params).parents()[4]
                removeDiv.remove()
            }
            btn.find('#loadingBtn').hide()
            btn.find('#moreBtn').show()
        });
    }
    function editAchievement(params) {
        $.post( "{{ url('achievement/detailAjax') }}", { id_achievement_group: params, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            $('#editAchievement').find("select[name='category[name]']").val(data.id_achievement_category).trigger('change')
            $('#editAchievement').find("img").attr("src", data.logo_badge_default)
            $('#editAchievement').find("input[name='group[name]']").val(data.name).trigger('change')

            $('#editAchievement').find("input[name='group[date_start]']").val(data.date_start).trigger('change')
            if (!data.is_start) {
                $('#editAchievement').find("input[name='group[date_start]']").removeAttr('disabled');
            } else {
                $('#editAchievement').find("input[name='group[date_start]']").attr('disabled', 'disabled');
            }

            $('#editAchievement').find("input[name='group[date_end]']").val(data.date_end).trigger('change')
            // if (!data.is_start || data.date_end.length === 0) {
            //     $('#editAchievement').find("input[name='group[date_end]']").removeAttr('disabled');
            // } else {
            //     $('#editAchievement').find("input[name='group[date_end]']").attr('disabled', 'disabled');
            // }

            $('#editAchievement').find("input[name='group[publish_start]']").val(data.publish_start).trigger('change')
            if (!data.is_start) {
                $('#editAchievement').find("input[name='group[publish_start]']").removeAttr('disabled');
            } else {
                $('#editAchievement').find("input[name='group[publish_start]']").attr('disabled', 'disabled');
            }
            $('#editAchievement').find("input[name='group[publish_end]']").val(data.publish_end).trigger('change')
            // $('#editAchievement').find("input[name='group[date_start]']").val(data.date_start).trigger('change')
            // $('#editAchievement').find("input[name='group[date_end]']").val(data.date_end).trigger('change')
            // var desc = `<textarea name="group[description]" id="field_content_long" class="form-control summernote" placeholder="Achievement Description">${data.description}</textarea>`
            // $('#editAchievement').find("#field_content_long").replaceWith(desc)
            $('#editAchievement').find("input[name='group[progress_text]']").val(data.progress_text).trigger('change')
            if (data.is_calculate == 1) {
                $('#editAchievement').find("#calculate_1").prop("checked", true)
            } else {
                $('#editAchievement').find("#calculate_0").prop("checked", true)
            }
            $("#field_content_long").summernote("code", String(data.description));
            $('#editAchievement').find("input[name='id_achievement_group']").val(data.id_achievement_group).trigger('change')
            // $('#editAchievement').find("input[name='different_outlet']").val(data.different_outlet).trigger('change')
            // $('#editAchievement').find("select[name='id_province']").val(data.id_province).trigger('change')
            // $('#editAchievement').find("input[name='different_province']").val(data.different_province).trigger('change')
            // $('#editAchievement').find("input[name='id_achievement_detail']").val(data.id_achievement_detail)
            // $('.digit_mask').inputmask({
            //     removeMaskOnSubmit: true, 
            //     placeholder: "",
            //     alias: "currency", 
            //     digits: 0, 
            //     rightAlign: false,
            //     min: 0,
            //     max: '999999999'
            // });
            var rule = ''
            if(data.order_by == 'nominal_transaction'){
                rule = 'Transaction Nominal'
            }else if(data.order_by == 'total_transaction'){
                rule = 'Transaction Total'
            }else if(data.order_by == 'total_product'){
                rule = 'Product Total'
            }else if(data.order_by == 'total_outlet'){
                rule = 'Outlet Different'
            }else if(data.order_by == 'total_province'){
                rule = 'Province Different'
            }
            $('#editAchievement').find("input[name='total_rule']").val(rule)

            if(data.trx_nominal != null){
                $('#editAchievement').find('.trx_rule_form').show()
                $('#editAchievement').find("input[name='transaction_rule']").val(data.trx_nominal)
            }else{
                $('#editAchievement').find('.trx_rule_form').hide()
            }
            if(data.id_product != null){
                $('#editAchievement').find('.product_rule_form').show()
                $('#editAchievement').find('.product_variant_rule_form').show()
                $.ajax({
                    type: 'GET',
                    url: "{{url('product/ajax/simple')}}"
                }).then(function (dataProduct) {
                    // create the option and append to Select2
                    $('.id_product').empty()
                    $.each( dataProduct, function( key, value ) {
                        if(value.id_product == data.id_product){
                            var option = new Option(value.product_name, value.id_product, true, true);
                        }else{
                            var option = new Option(value.product_name, value.id_product);
                        }
                        $('.id_product').append(option);
                    });
                });
            }else{
                $('#editAchievement').find('.product_rule_form').hide()
                $('#editAchievement').find('.product_variant_rule_form').hide()
            }

            if(data.product_total > 0 && data.order_by != 'total_product'){
                $('#editAchievement').find('.product_total_form').show()
                $('#product_total_rule').val(data.product_total)
            }

            if(data.id_product_variant_group != null){
                $("#use_variant").attr('checked', 'checked');
                $('#editAchievement').find('.product_variant_rule_option').show()
            }
            $.ajax({
                type: 'GET',
                url: "{{url('product-variant-group/ajax')}}/" + data.id_product
            }).then(function (dataVariant) {
                // create the option and append to Select2
                $('.id_product_variant').empty()
                $.each( dataVariant, function( key, value ) {
                    if(value.id_product_variant_group == data.id_product_variant_group){
                        var option = new Option(value.product_variant_group_name, value.id_product_variant_group, true, true);
                    }else{
                        var option = new Option(value.product_variant_group_name, value.id_product_variant_group, true, false);
                    }
                    $('.id_product_variant').append(option).trigger('change');
                });
                $('.id_product_variant').val(data.id_product_variant_group).trigger("change")
            });


            if(data.id_province != null || data.id_outlet){
                $('#editAchievement').find('.additional_rule_form').show()
                if(data.id_province != null){
                    $('#editAchievement').find("input[name='province_rule']").val(data.province_name)
                }
                if(data.id_province != null){
                    $('#editAchievement').find("input[name='outlet_rule']").val(data.outlet_name)
                }
            }else{
                $('#editAchievement').find('.additional_rule_form').hide() 
            }

            // $('#editAchievement').find("input[name='total_rule']").val(rule)
            $(".select2-rule").select2({
                width: '100%'
            });
            $("#selectCategory").select2({
                tags: true
            });
            $("#selectProduct").select2({
                tags: true
            });

        });
    }
    function updater(table,response){
    }
    $(document).ready(function(){
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $(".form_datetime").datetimepicker({
            format: "d-M-yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            minuteStep: 1
        });
        $('.summernote').summernote({
            placeholder: true,
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
            ],
            fontNames: ['Open Sans', 'Product Sans'],
            fontNamesIgnoreCheck: ['Product Sans'],
            callbacks: {
                onInit: function(e) {
                    this.placeholder
                    ? e.editingArea.find(".note-placeholder").html(this.placeholder)
                    : e.editingArea.remove(".note-placeholder");
                },
                onImageUpload: function(files){
                    sendFile(files[0]);
                },
                onMediaDelete: function(target){
                    var name = target[0].src;
                    token = "{{ csrf_token() }}";
                    $.ajax({
                        type: 'post',
                        data: 'filename='+name+'&_token='+token,
                        url: "{{url('summernote/picture/delete/deals')}}",
                        success: function(data){
                            // console.log(data);
                        }
                    });
                }
            }
        });
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
        $("#selectCategory").select2({
            dropdownParent: $('#editAchievement')
        });
        $('#use_variant').change(function() {
            if ($(this).is(':checked')) {
                $('#editAchievement').find('.product_variant_rule_option').show()
            }else{
                $('#editAchievement').find('.product_variant_rule_option').hide()
            }
        });

        $('.id_product').change(function() {
            var id_product = $(this).val()
            $.ajax({
                type: 'GET',
                url: "{{url('product-variant-group/ajax')}}/" + id_product
            }).then(function (data) {
                // create the option and append to Select2
                $('.id_product_variant').empty()
                $.each( data, function( key, value ) {
                    var option = new Option(value.product_variant_group_name, value.id_product_variant_group, true, true);
                    $('.id_product_variant').append(option).trigger('change');
                });
                $('.id_product_variant').val("").trigger("change")
            });
        });
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
                <div class="row">
                    <div class="col-md-offset-9 col-md-3">
                        <form class="filter-form">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control search-field" name="keyword" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button class="btn blue search-btn" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-infinite">
                    <table class="table table-striped" id="tableTrx" data-template="differentprice"  data-page="0" data-is-loading="0" data-is-last="0" data-url="{{url()->current()}}" data-callback="updater" data-order="promo_campaign_referral_transactions.created_at" data-sort="asc">
                        <thead>
                            <tr>
                                <th style="width: 1%" class="text-center">No</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Achievement Publish Start</th>
                                <th>Achievement Publish End</th>
                                <th>Achievement Start</th>
                                <th>Achievement End</th>
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

    <div class="modal fade bs-modal-lg" id="editAchievement" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg" style="width: 700px;">
            <form role="form" action="{{ url('achievement/update/achievement') }}" method="post" enctype="multipart/form-data" class="form-horizontal modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Edit Achievement</h4>
                </div>
                <div class="modal-body" style="padding: 20ox;display: table;width: 100%;">
                    <div class="col-md-12">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Category
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Select category or type a new category, if it isn't available in the selection" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select id="selectCategory" data-placeholder="Select or Type new Category" name="category[name]" class="form-control">
                                        <option></option>
                                        @foreach ($category as $item)
                                            <option value="{{$item['id_achievement_category']}}">{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Name
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Achievement Name" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="group[name]" value="{{ old('group.name') }}" placeholder="Achievement" required maxlength="30">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Image Default Badge
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Gambar deals" data-container="body"></i>
                                    <br>
                                    <span class="required" aria-required="true"> (500*500) </span>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                            <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                            <div id="classImage">
                                                <span class="btn default btn-file">
                                                <span class="fileinput-new"> Select image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" accept="image/*" class="file" name="group[logo_badge_default]" value="{{ old('group.logo_badge_default') }}">
                                                </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label class="col-md-3 control-label"> Achievement Publish Periode <span class="required" aria-required="true"> * </span> </label>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="group[publish_start]" value="{{ old('group.publish_start') }}" required autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Start Publish Achievement" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="group[publish_end]" value="{{ old('group.publish_end.') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="End Publish Achievement (Leave this column, if the achievement is active forever)" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Achievement Periode <span class="required" aria-required="true"> * </span> </label>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="group[date_start]" value="{{ old('group.date_start') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Start Peroide Achievement" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="group[date_end]" value="{{ old('group.date_end') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="End Peroide Achievement (Leave this column, if the achievement is active forever)" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Description
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap tentang deals yang dibuat" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <textarea name="group[description]" id="field_content_long" class="form-control summernote" placeholder="Achievement Description">{{ old('group.description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Achievement Start Periode <span class="required" aria-required="true"> * </span> </label>
                                <div class="col-md-5">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="group[date_start]" value="{{ old('group.date_start') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Start Peroide Achievement" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Achievement End Periode </label>
                                <div class="col-md-5">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="group[date_end]" value="{{ old('group.date_end') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="End Peroide Achievement (Leave this column, if the achievement is active forever)" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Achievement Publish Start Periode <span class="required" aria-required="true"> * </span> </label>
                                <div class="col-md-5">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="group[publish_start]" value="{{ old('group.publish_start') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Publish Start Peroide Achievement" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Achievement Publish End Periode </label>
                                <div class="col-md-5">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="group[publish_end]" value="{{ old('group.publish_end') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Publish End Peroide Achievement (Leave this column, if the achievement is active forever)" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Order By
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih brand untuk deal ini" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <select class="form-control select2-multiple" data-placeholder="Select Brand" name="group[order_by]" required>
                                            <option value="trx_nominal" @if (old('group.order_by') == 'trx_nominal') selected @endif>Transaction Nominal</option>
                                            <option value="trx_total" @if (old('group.order_by') == 'trx_total') selected @endif>Transaction Total</option>
                                            <option value="different_outlet" @if (old('group.order_by') == 'different_outlet') selected @endif>Different Outlet</option>
                                            <option value="different_province" @if (old('group.order_by') == 'different_province') selected @endif>Different Province</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            --}}
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Achievement Total Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Rule achievement based on" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="total_rule" disabled>
                                        </div>
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
                                    <input type="text" class="form-control" name="transaction_rule" disabled>
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
                                        <select class="form-control id_product" data-placeholder="Select Product" name="rule[id_product]" id="selectProduct">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 product_total_form" hidden>
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control total_product" name="rule[product_total]" id="product_total_rule" placeholder="Total Product">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if achievement reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group product_variant_rule_form" hidden>
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Achievement Product Variant Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Select a product variant. leave blank, if the achievement is not based on the product variant" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-checkbox-inline">
                                            <label class="mt-checkbox" style="margin-left: 15px;" id="rule_product_variant">
                                                <input type="checkbox" id="use_variant"> Use Variant
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 product_variant_rule_option" hidden>
                                        <div class="input-icon right">
                                            <select class="form-control select2-multiple id_product_variant" data-placeholder="Select Variant" name="rule[id_product_variant_group]">
                                                <option></option>
                                            </select>
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
                                        <input type="text" class="form-control" name="province_rule" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4" id="select_province">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control" name="outlet_rule" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Calculate Membership
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Apakah achievement ini digunakan untuk kalkulasi pendapatan di membership?" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" id="calculate_1" name="group[is_calculate]" value="1"> Yes
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" id="calculate_0" name="group[is_calculate]" value="0"> No
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Progress Text
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Progress Text" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="group[progress_text]" placeholder="Text" required maxlength="255">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{ csrf_field() }}
                    <input type="text" name="id_achievement_group" hidden>
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn green">Save changes</button>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


@endsection
