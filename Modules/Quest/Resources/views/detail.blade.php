<?php
    use App\Lib\MyHelper;
    $configs  = session('configs');
    $grantedFeature     = session('granted_features');
    date_default_timezone_set('Asia/Jakarta');
 ?>
@extends('layouts.main-closed')
@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" /> 
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	
	<style type="text/css">
	    #sample_1_filter label, #sample_5_filter label, #sample_4_filter label, .pagination, .dataTables_filter label {
	        float: right;
	    }
	    
	    .cont-col2{
	        margin-left: 30px;
	    }
        .page-container-bg-solid .page-content {
            background: #fff!important;
        }
        .v-align-top {
            vertical-align: top;
        }
        .width-voucher-img {
            max-width: 150px;
        }
        .custom-text-green {
            color: #28a745!important;
        }
        .font-black {
            color: #333!important;
        }
        .pull-right>.dropdown-menu{
            left: 0;
        }
        .fa-chevron-right {
            transition-duration: .2s;
        }
        a[aria-expanded=true] .fa-chevron-right {
            transform: rotate(-90deg);
        }
        a[aria-expanded=false] .fa-chevron-right {
            transform: rotate(90deg);
        }
        .select2-container {
            width: 100% !important;
        }
        .tooltip {
            z-index: 100000000; 
        }
	</style>
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>

	<script>
    function addSummernoteContent(target, text){
        var textvalue = $(target).val();

        var textvaluebaru = textvalue+" "+text;
        $(target).val(textvaluebaru);
        $(target).summernote('editor.saveRange');
        $(target).summernote('editor.restoreRange');
        $(target).summernote('editor.focus');
        $(target).summernote('editor.insertText', text);
    }

    function addTextContent(target, text){
        var textvalue = $(target).val();

        var textvaluebaru = textvalue+" "+text;
        $(target).val(textvaluebaru);
    }

    $(document).ready( function () {
        $('.select2-multiple').select2({
            placeholder : "Select",
            allowClear : true,
            width: '100%'
        })
        $('.digit_mask').inputmask({
            removeMaskOnSubmit: true, 
            placeholder: "",
            alias: "currency", 
            digits: 0, 
            rightAlign: false,
            min: 0,
            max: '999999999'
        });
        var index = 1;
        $('.addBox').click(function() {
            nomer = index++
            $('.btn-rmv').before(`<div class="box"> <div class="col-md-2 text-right" style="text-align: -webkit-right;"> <a href="javascript:;" onclick="removeBox(this)" class="remove-btn btn btn-danger"> <i class="fa fa-close"></i> </a> </div><div class="col-md-10"> <div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Name <span class="required" aria-required="true"> * </span> <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i> </label> </div><div class="col-md-8"> <input type="text" class="form-control" name="detail[`+nomer+`][name]" placeholder="Detail Quest" required maxlength="20"> </div></div><div class="form-group"><div class="input-icon right"><label class="col-md-3 control-label">Short Description<span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Short Description" data-container="body"></i></label></div><div class="col-md-8"><input type="text" class="form-control" name="detail[`+nomer+`][short_description]" placeholder="Short Description" required maxlength="20"></div></div><div class="form-group"><div class="input-icon right"><label class="col-md-3 control-label">Quest Category Product Rule<i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i></label></div><div class="col-md-4"><div class="input-icon right"><select class="form-control select2-multiple" data-placeholder="Select Category Product" name="detail[`+nomer+`][id_product_category]"><option></option>@foreach ($category as $item)<option value="{{$item['id_product_category']}}">{{$item['product_category_name']}}</option>@endforeach</select></div></div><div class="col-md-4"><div class="input-icon right"><div class="input-group"><select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[`+nomer+`][different_category_product]"><option></option><option value="1">Yes</option><option value="0">No</option></select><span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-question-circle tooltips" data-original-title="Rule for different category product" data-container="body"></i></button></span></div></div></div></div><div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Quest Product Rule <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i> </label> </div><div class="col-md-4"> <div class="input-icon right"> <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[`+nomer+`][id_product]"> <option></option>  @foreach ($product as $item) <option value="{{$item['id_product']}}">{{$item['product_name']}}</option> @endforeach </select> </div></div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <input type="text" class="form-control" name="detail[`+nomer+`][product_total]" placeholder="Total Product"> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i> </button> </span> </div></div></div></div><div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Quest Transaction Rule <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i> </label> </div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <input type="text" class="form-control digit_mask" name="detail[`+nomer+`][trx_nominal]" placeholder="Transaction Nominal"> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i> </button> </span> </div></div></div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <input type="text" class="form-control digit_mask" name="detail[`+nomer+`][trx_total]" placeholder="Transaction Total"> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i> </button> </span> </div></div></div></div><div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Quest Outlet Rule <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i> </label> </div><div class="col-md-4"> <div class="input-icon right"> <select class="form-control select2-multiple" data-placeholder="Select Product" name="detail[`+nomer+`][id_outlet]"> <option></option> @foreach ($outlet as $item) <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option> @endforeach </select> </div></div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[`+nomer+`][different_outlet]"> <option></option> <option value="1">Yes</option> <option value="0">No</option> </select> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Rule for different outlet" data-container="body"></i> </button> </span> </div></div></div></div><div class="form-group"> <div class="input-icon right"> <label class="col-md-3 control-label"> Quest Province Rule <i class="fa fa-question-circle tooltips" data-original-title="Select a province. leave blank, if the quest is not based on the province" data-container="body"></i> </label> </div><div class="col-md-4"> <div class="input-icon right"> <select class="form-control select2-multiple" data-placeholder="Select Province" name="detail[`+nomer+`][id_province]"> <option></option> @foreach ($province as $item) <option value="{{$item['id_province']}}">{{$item['province_name']}}</option> @endforeach </select> </div></div><div class="col-md-4"> <div class="input-icon right"> <div class="input-group"> <select class="form-control select2-multiple" data-placeholder="Different Rule" name="detail[`+nomer+`][different_province]"> <option></option> <option value="1">Yes</option> <option value="0">No</option> </select> <span class="input-group-btn"> <button class="btn default" type="button"> <i class="fa fa-question-circle tooltips" data-original-title="Rule for different province" data-container="body"></i> </button> </span> </div></div></div></div></div></div>`);
            $('.digit_mask').inputmask({
                removeMaskOnSubmit: true, 
                placeholder: "",
                alias: "currency", 
                digits: 0, 
                rightAlign: false,
                min: 0,
                max: '999999999'
            });
            $(".select2-multiple").select2({
                allowClear: true,
                width: '100%'
            });
        });

        function sendFile(file, id){
            token = "<?php echo csrf_token(); ?>";
            var data = new FormData();
            data.append('image', file);
            data.append('_token', token);
            // document.getElementById('loadingDiv').style.display = "inline";
            $.ajax({
                url : "{{url('summernote/picture/upload/advert')}}",
                data: data,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(url) {
                    if (url['status'] == "success") {
                        $('#'+id).summernote('editor.saveRange');
                        $('#'+id).summernote('editor.restoreRange');
                        $('#'+id).summernote('editor.focus');
                        $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                    }
                    // document.getElementById('loadingDiv').style.display = "none";
                },
                error: function(data){
                    // document.getElementById('loadingDiv').style.display = "none";
                }
            })
        }

        $('.summernote').summernote({
            placeholder: true,
            tabsize: 2,
            height: 120,
            toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
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
        $('#quest-content-container').on('click', '.delete-btn', function() {
            $($(this).parents('.accordion-item')[0]).remove();
        });

        $('.sortable').sortable({
            items: '> div:not(.unsortable)',
            handle: ".sortable-handle",
            connectWith: ".sortable",
            axis: 'y',
        });
    })
    function removeBox(params) {
        $(params).parents('.detail-container-item').remove()
    }
    function editBadge(params) {
        $('#editBadge').find("input[name='name']").val(params.name)
        $('#editBadge').find("textarea[name='short_description']").val(params.short_description)
        $('#editBadge').find("select[name='id_product_category']").val(params.id_product_category).trigger('change')
        $('#editBadge').find("input[name='different_category_product']").val(params.different_category_product).trigger('change')
        $('#editBadge').find("select[name='id_product']").val(params.id_product).trigger('change')
        $('#editBadge').find("select[name='id_product_variant_group']").val(params.id_product_variant_group).trigger('change')
        $('#editBadge').find("input[name='trx_nominal']").val(params.trx_nominal)
        $('#editBadge').find("input[name='trx_total']").val(params.trx_total)
        $('#editBadge').find("input[name='product_total']").val(params.product_total)
        if (params.id_outlet_group) {
            params.id_outlet = '0';
        }
        $('#editBadge').find("select[name='id_outlet']").val(params.id_outlet).trigger('change')
        $('#editBadge').find("select[name='id_outlet_group']").val(params.id_outlet_group).trigger('change')
        $('#editBadge').find("select[name='different_outlet']").val(params.different_outlet).trigger('change')
        $('#editBadge').find("select[name='id_province']").val(params.id_province).trigger('change')
        $('#editBadge').find("select[name='different_province']").val(params.different_province).trigger('change')
        $('#editBadge').find("input[name='id_quest_detail']").val(params.id_quest_detail)

        if (params.id_province) {
            $('#editBadge').find(".additional_rule_type").val('province').trigger('change')
        } else if (params.id_outlet && params.id_outlet != '0') {
            $('#editBadge').find(".additional_rule_type").val('outlet').trigger('change')
        } else if (params.id_outlet_group) {
            $('#editBadge').find(".additional_rule_type").val('outlet_group').trigger('change')
        }

        let total_rule = params.total_rule;

        if (!total_rule) {
            if (params.different_outlet) {
                total_rule = 'total_outlet';
            } else if (params.different_province) {
                total_rule = 'total_province';
            } else if (params.trx_total) {
                total_rule = 'total_transaction';
            } else if (params.product_total && params.id_product) {
                total_rule = 'total_product';
            } else {
                total_rule = 'nominal_transaction';
            }
        }

        if (params.trx_nominal) {
            $('#editBadge .rule_trx').prop('checked', true);
        } else {
            $('#editBadge .rule_trx').removeAttr('checked');
        }

        if (params.id_product || (params.product_total && total_rule != 'total_product')) {
            $('#editBadge .rule_product').prop('checked', true);
        } else {
            $('#editBadge .rule_product').removeAttr('checked');
        }

        if (params.id_product_variant_group) {
            $('#editBadge .rule_product_variant').prop('checked', true);
        } else {
            $('#editBadge .rule_product_variant').removeAttr('checked');
        }

        if (params.id_outlet || params.id_outlet_group || params.id_province) {
            $('#editBadge .rule_additional').prop('checked', true);
        } else {
            $('#editBadge .rule_additional').removeAttr('checked');
        }

        $('#editBadge').find("select[name='quest_rule']").val(total_rule).trigger('change');
        $('.digit_mask').inputmask("numeric", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 0,
            autoGroup: true,
            rightAlign: false,
            removeMaskOnSubmit: true, 
        });
        $(".select2-multiple").select2({
            allowClear: true,
            width: '100%'
        });
    }
    function removeBadge(params, data) {
        var btn = $(params).parent().parent().parent().before().children()
        btn.find('#loadingBtn').show()
        btn.find('#moreBtn').hide()
        $.post( "{{ url('quest/delete') }}", { id_quest_detail: data, _token: "{{ csrf_token() }}" })
        .done(function( data ) {
            if (data.status == 'success') {
                var removeDiv = $(params).parents()[5]
                removeDiv.remove()
                toastr.info("Success delete");
            } else {
                toastr.warning(data.messages[0]);
            }
            btn.find('#loadingBtn').hide()
            btn.find('#moreBtn').show()
        });
    }
    let detail_count = $('#quest-content-container').children().length;
    function addCustomContent() {
        detail_count++;
        $('#quest-content-container').append(`
            <div id="accordion${detail_count}" class="accordion-item" style="padding-bottom: 10px;">
                <div class="row">
                    <div class="col-md-6 content-title">
                        <div class="input-group">
                            <span class="input-group-addon sortable-handle"><a><i class="fa fa-arrows-v"></i></a></span>
                            <input type="text" class="form-control" name="content[${detail_count}][title]"  placeholder="Content Title" required maxlength="20" value="">
                            <input type="hidden" name="content[${detail_count}][id_quest_content]" value="0" >
                            <input type="hidden" name="content_order[]" value="${detail_count}">
                            <span class="input-group-addon">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion${detail_count}" aria-expanded="false" href="#collapse_${detail_count}">
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="checkbox" class="make-switch visibility-switch" data-on="success" data-on-color="success" data-on-text="Visible" data-off-text="Hidden" data-size="normal" name="content[${detail_count}][is_active]">
                    </div>
                    <div class="col-md-3 text-right">
                        <button class="btn btn-danger delete-btn" type="button"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="col-md-12 accordion-body collapse" style="margin-top: 10px; " id="collapse_${detail_count}">
                        <textarea name="content[${detail_count}][content]" class="form-control summernote" placeholder="Content" id="summernote${detail_count}"></textarea>
                        <div class="portlet-body" style="margin-bottom: 15px">
                            <span style="margin-bottom: 5px">You can use this variables to display dynamic information:</span>
                            <div>
                                @if($data['quest']['quest_benefit']['benefit_type'] == 'voucher')
                                    <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addSummernoteContent('#summernote${detail_count}', '%deals_title%')">%deals_title%</button>
                                    <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addSummernoteContent('#summernote${detail_count}', '%voucher_qty%')">%voucher_qty%</button>
                                @else
                                    <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addSummernoteContent('#summernote${detail_count}', '%point_received%')">%point_received%</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border-bottom: 1px solid #F0F5F7;margin: 10px 0"/>
            </div>
        `);
        $(`input[name="content[${detail_count}][is_active]"]`).bootstrapSwitch();
        $(`textarea[name="content[${detail_count}][content]"]`).summernote({
            placeholder: true,
            tabsize: 2,
            height: 120,
            toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
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
    }
	</script>
    <script type="text/javascript">
        const product_variants = {!!json_encode($product_variant_groups)!!};
        let counter_rule = 1;
        function addRule() {
            const template = `
                <div class="portlet light bordered detail-container-item detail-container-item-${counter_rule}">
                    <div class="portlet-body row">
                        <div class="col-md-1 text-right" style="text-align: -webkit-right;">
                            <a href="javascript:;" onclick="removeBox(this)" class="remove-box btn btn-danger">
                                <i class="fa fa-close"></i>
                            </a>
                        </div>
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Name
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="detail[${counter_rule}][name]" placeholder="Detail Quest" required maxlength="40" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Short Description
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <textarea name="detail[${counter_rule}][short_description]" class="form-control" placeholder="Quest Detail Short Description">{{$detail['short_description'] ?? ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Total Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select quest rule" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <select class="form-control select2 quest_rule" name="detail[${counter_rule}][quest_rule]" data-placeholder="Select Quest Rule" required>
                                                <option></option>
                                                <option value="nominal_transaction">Transaction Nominal</option>
                                                <option value="total_transaction">Transaction Total</option>
                                                <option value="total_product">Product Total</option>
                                                <option value="total_outlet">Outlet Different</option>
                                                <option value="total_province">Province Different</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group additional_rule">
                                <label class="col-md-3 control-label">
                                    Additional Rule
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Detail Quest Name" data-container="body"></i>
                                </label>
                                <div class="col-md-9">
                                    <div class="mt-checkbox-inline">
                                        <label class="mt-checkbox rule_transaction not_nominal_transaction">
                                            <input type="checkbox" class="rule_trx"> Transaction
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox rule_product_add">
                                            <input type="checkbox" class="rule_product"> Product
                                            <span></span>
                                        </label>
                                        <label class="mt-checkbox additionalnya not_total_province">
                                            <input type="checkbox" class="rule_additional"> Additional
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group trx_rule_form">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Transaction Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Input transaction rule. leave blank, if the quest is not based on the transaction" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control digit_mask nominal_transaksi" name="detail[${counter_rule}][trx_nominal]" placeholder="Transaction Nominal">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product_rule_form">
                                <div class="form-group">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Product Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Select a product. leave blank, if the quest is not based on the product" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <select class="form-control select2 id_product" data-placeholder="Select Product" name="detail[${counter_rule}][id_product]">
                                                <option></option>
                                                @foreach ($product as $item)
                                                    <option value="{{$item['id_product']}}">{{$item['product_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 not_total_product">
                                        <div class="input-icon right">
                                            <div class="input-group">
                                                <input type="text" class="form-control total_product product_total_rule" name="detail[${counter_rule}][product_total]" placeholder="Total Product">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Input total product, if quest reward by product" data-container="body"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group has_variant">
                                    <div class="input-icon right">
                                        <label class="col-md-3 control-label">
                                        Product Variant Rule
                                        <i class="fa fa-question-circle tooltips" data-original-title="Select a product variant. leave blank, if the quest is not based on the product variant" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-checkbox-inline">
                                            <label class="mt-checkbox" style="margin-left: 15px;">
                                                <input type="checkbox" class="use_variant rule_product_variant"> Use Variant
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-offset-3 col-md-4 product_variant_rule_form">
                                        <div class="input-icon right">
                                            <select class="form-control select2 id_product_variant" data-placeholder="Select Variant" name="detail[${counter_rule}][id_product_variant_group]">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group additional_rule_form">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Additional Rule
                                    <i class="fa fa-question-circle tooltips" data-original-title="Select a outlet. leave blank, if the quest is not based on the product" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <select class="form-control select2 additional_rule_type" data-placeholder="Select Province" name="detail[${counter_rule}][additional_rule_type]">
                                            <option value="province" class="province_option">Province</option>
                                            <option value="outlet">Outlet</option>
                                            <option value="outlet_group">Outlet Group Filter</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 select_province">
                                    <div class="input-icon right">
                                        <select class="form-control select2 id_province province_total_rule" data-placeholder="Select Province" name="detail[${counter_rule}][id_province]">
                                            <option></option>
                                            @foreach ($province as $item)
                                                <option value="{{$item['id_province']}}">{{$item['province_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 select_outlet">
                                    <div class="input-icon right">
                                        <select class="form-control select2 id_outlet" data-placeholder="Select Outlet" name="detail[${counter_rule}][id_outlet] outlet_total_rule">
                                            <option></option>
                                            @foreach ($outlet as $item)
                                                <option value="{{$item['id_outlet']}}">{{$item['outlet_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-offset-3 col-md-4 select_outlet_group">
                                    <div class="input-icon right">
                                        <select class="form-control select2 id_outlet_group" data-placeholder="Select Outlet Group Filter" name="detail[${counter_rule}][id_outlet_group]">
                                            <option></option>
                                            @foreach ($outlet_group_filters as $item)
                                                <option value="{{$item['id_outlet_group']}}">{{$item['outlet_group_name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch nominal_transaction_form">
                                <label class="col-md-3 control-label">
                                    Transaction Nominal
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Transaction Nominal" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][trx_nominal]" placeholder="Transaction Nominal">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch total_transaction_form">
                                <label class="col-md-3 control-label">
                                    Transaction Total
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Transaction Total" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][trx_total]" placeholder="Transaction Total">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch total_product_form">
                                <label class="col-md-3 control-label">
                                    Product Total
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Product Total" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][product_total]" placeholder="Product Total">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch total_outlet_form">
                                <label class="col-md-3 control-label">
                                    Outlet Total
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Outlet Total" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][different_outlet]" placeholder="Outlet Total">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form_switch total_province_form">
                                <label class="col-md-3 control-label">
                                    Province Total
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Province Total" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" class="form-control digit_mask" name="detail[${counter_rule}][different_province]" placeholder="Province Total">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $(this).parents('.modal').find('.detail-container').append(template);
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .quest_rule`).change();
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .rule_trx`).change();
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .rule_product`).change();
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .rule_additional`).change();
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .rule_product_variant`).change();
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .id_outlet`).change();
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .additional_rule_type`).change();
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .digit_mask`).inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 0,
                autoGroup: true,
                rightAlign: false,
                removeMaskOnSubmit: true, 
            });
            $(this).parents('.modal').find(`.detail-container-item-${counter_rule} .select2`).select2({
                allowClear: true,
            });

            counter_rule++;
        }

        $(document).ready(function() {
            $('#benefit-selector').on('change', function() {
                if ($(this).val() == 'point') {
                    $('#benefit-voucher').addClass('hidden');
                    $('#benefit-voucher :input').prop('disabled', true);

                    $('#benefit-point').removeClass('hidden');
                    $('#benefit-point :input').removeAttr('disabled');
                } else {
                    $('#benefit-point').addClass('hidden');
                    $('#benefit-point :input').prop('disabled', true);

                    $('#benefit-voucher').removeClass('hidden');
                    $('#benefit-voucher :input').removeAttr('disabled');
                }
            }).change();

            $('#autoclaim-selector').on('switchChange.bootstrapSwitch', function(event, state) {
                if (state) {
                    $('.manualclaim-only').hide();
                    $('.manualclaim-only :input').prop('disabled', true);
                } else {
                    $('.manualclaim-only').show();
                    $('.manualclaim-only :input').removeAttr('disabled');
                }
            }).change();

            if ($('#autoclaim-selector').is(':checked')) {
                $('.manualclaim-only').hide();
                $('.manualclaim-only :input').prop('disabled', true);
            } else {
                $('.manualclaim-only').show();
                $('.manualclaim-only :input').removeAttr('disabled');
            }

            $('[value="duration"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.duration-only').show();
                    $('.duration-only :input').removeAttr('disabled');
                    $('.dates-only').hide();
                    $('.dates-only :input').prop('disabled', true);
                } else {
                    $('.duration-only').hide();
                    $('.duration-only :input').prop('disabled', true);
                }
            }).change();

            $('[value="dates"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.dates-only').show();
                    $('.dates-only :input').removeAttr('disabled');
                    $('.duration-only').hide();
                    $('.duration-only :input').prop('disabled', true);
                } else {
                    $('.dates-only').hide();
                    $('.dates-only :input').prop('disabled', true);
                }
            }).change();

            $('.detail-container').on('change', '.quest_rule', function() {
                const parent = $(this).parents('.detail-container-item');
                parent.find('.form_switch').hide();
                parent.find('.form_switch :input').prop('disabled', true);
                if ($(this).val()) {
                    parent.find('.additional_rule').show();
                    parent.find('.additional_rule :input').removeAttr('disabled');

                    parent.find('.not_nominal_transaction').show();
                    parent.find('.not_nominal_transaction :input').removeAttr('disabled');

                    parent.find('.not_total_province').show();
                    parent.find('.not_total_province :input').removeAttr('disabled');

                    parent.find('.not_total_product').show();
                    parent.find('.not_total_product :input').removeAttr('disabled');

                    parent.find(`.${$(this).val()}_form`).show();
                    parent.find(`.${$(this).val()}_form :input`).removeAttr('disabled');
                    parent.find('.not_total_product :input').removeAttr('disabled');
                    switch ($(this).val()) {
                        case 'nominal_transaction':
                            parent.find('.not_nominal_transaction').hide();
                            parent.find('.not_nominal_transaction :input').prop('disabled', true);
                            break;
                        case 'total_transaction':
                            break;
                        case 'total_product':
                            parent.find('.not_total_product').hide();
                            parent.find('.not_total_product :input').prop('disabled', true);
                            break;
                        case 'total_outlet':
                            break;
                        case 'total_province':
                            parent.find('.not_total_province').hide();
                            parent.find('.not_total_province :input').prop('disabled', true);
                            break;
                    }
                    $('.detail-container .rule_trx').change();
                    $('.detail-container .rule_product').change();
                    $('.detail-container .rule_additional').change();
                    $('.detail-container .rule_product_variant').change();
                } else {
                    parent.find('.additional_rule').hide();
                    parent.find('.additional_rule :input').prop('disabled', true);
                }
            });
            $('.detail-container .quest_rule').change();

            $('.detail-container').on('change', '.rule_trx', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.trx_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
            });
            $('.detail-container .rule_trx').change();

            $('.detail-container').on('change', '.rule_product', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.product_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
            });
            $('.detail-container .rule_product').change();

            $('.detail-container').on('change', '.rule_additional', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.additional_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
                $('.detail-container .additional_rule_type').change();
            });
            $('.detail-container .rule_additional').change();

            $('.detail-container').on('change', '.rule_product_variant', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.product_variant_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
            });
            $('.detail-container .rule_product_variant').change();

            $('.detail-container').on('change', '.id_product', function() {
                const parent = $(this).parents('.detail-container-item');
                const variants = product_variants[$(this).val()];
                if (variants && $(this).val()) {
                    const html = [];
                    variants.forEach(item => {
                        html.push(`<option value="${item.id_product_variant_group}">${item.product_variants}</option>`);
                    });
                    parent.find('.id_product_variant').html(html.join(''));
                    parent.find('.has_variant').show();
                    parent.find('.has_variant :input').removeAttr('disabled');
                } else {
                    parent.find('.has_variant').hide();
                    parent.find('.has_variant :input').prop('disabled', true);
                }
            });
            $('.detail-container .id_product').change();
            $('.detail-container').on('change', '.additional_rule_type', function() {
                const parent = $(this).parents('.detail-container-item');
                parent.find('.select_province').hide()
                parent.find('.select_province :input').prop('disabled', true);
                parent.find('.select_outlet').hide()
                parent.find('.select_outlet :input').prop('disabled', true);
                parent.find('.select_outlet_group').hide()
                parent.find('.select_outlet_group :input').prop('disabled', true);
                if ($(this).prop('disabled')) {
                    return;
                }
                switch ($(this).val()) {
                    case 'province':
                        parent.find('.select_province').show();
                        parent.find('.select_province :input').removeAttr('disabled');
                        break;
                    case 'outlet':
                        parent.find('.select_outlet').show();
                        parent.find('.select_outlet :input').removeAttr('disabled');
                        break;
                    case 'outlet_group':
                        parent.find('.select_outlet_group').show();
                        parent.find('.select_outlet_group :input').removeAttr('disabled');
                        break;
                }
            });
            $('.detail-container .additional_rule_type').change();

            $('.select2').select2({
                allowClear: true,
            });
        });

        function changeUserRuleType(value) {
            if(value == 'all'){
                document.getElementById('detail_user_rule').style.display = 'none';
                $("#user_rule_subject").prop('required', false);
                $("#user_rule_operator").prop('required', false);
                $("#user_rule_parameter").prop('required', false);
            }else{
                document.getElementById('detail_user_rule').style.display = 'block';
                $("#user_rule_subject").prop('required', true);
                $("#user_rule_operator").prop('required', true);
                $("#user_rule_parameter").prop('required', true);
            }
        }

        var unsaved = false;

        $("#quest-content-container").on('change', ':input, .note-editable', function(){ //triggers change in all input fields including text type
            unsaved = true;
        });

        $("#quest-content-container").on("summernote.change", ".summernote", function (e) {   // callback as jquery custom event 
            unsaved = true;
        });

        function unloadPage(){ 
            if(unsaved){
                return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
            }
        }

        window.onbeforeunload = unloadPage;
    </script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
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
</div>
@include('layouts.notifications')
@include('quest::detail_modal')
<div class="row" style="margin-top:20px">
    {{-- <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="3">{{ !empty($result['total_coupon']) ? number_format(($result['total_coupon']??0)-($result['count']??0)) : isset($result['total_coupon']) ? 'unlimited' : '' }}</span>
                            </div>
                            <div class="desc"> Available </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 red">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="20">{{ number_format($result['count']??0) }}</span>
                            </div>
                            <div class="desc"> Total Used </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 blue">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{$result['total_coupon']??''}}">{{ !empty($result['total_coupon']) ? number_format($result['total_coupon']??0) : isset($result['total_coupon']) ? 'unlimited' : '' }}</span>
                            </div>
                            <div class="desc"> Total {{ isset($result['total_coupon']) ? 'Coupon' : '' }} </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="portlet light bordered">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">{{ $data['quest']['name'] }}</span>
            </div>
        </div>
        <div class="portlet-body">

            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    @if(MyHelper::hasAccess([230], $grantedFeature))
                        @if ($data['quest']['is_complete'] != 1)
                            <form action="{{url('quest/detail/'.$data['quest']['id_quest'].'/start')}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success" style="float: right; margin-left: 5px" data-toggle="confirmation" data-title="Are you sure? Quests that have been started <b class='text-danger'>cannot be edited</b> any more. Make sure all data is correct before continuing this action." data-placement="left"><i class="fa fa-play"></i> Start Quest</button>
                            </form>
                        @endif
                    @endif
                    @if($data['quest']['autoclaim_quest'] && $data['quest']['is_complete'] && $data['quest']['publish_end'] >= date('Y-m-d H:i:s') && !$data['quest']['stop_at'])
                    <a href="{{url('quest/detail/' . $data['quest']['id_quest'] . '/reclaim')}}" style="float: right; margin-left: 5px;" class="btn btn-warning">Retry autoclaim</a>
                    @endif
                    <a href="{{url('quest/report/detail/'.$data['quest']['id_quest_encripted'])}}" style="float: right; " class="btn btn-info">Report Detail Quest</a>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#overview" data-toggle="tab"> Quest Overview </a>
                        </li>
                        <li>
                            <a href="#content" data-toggle="tab"> Content Info </a>
                        </li>
                    </ul>
                    <div class="tab-content" style="margin-top:20px">
                        <div class="tab-pane active" id="overview">
                            @include('quest::detail_tab_overview')
                        </div>
                        <div class="tab-pane" id="content">
                            @include('quest::detail_tab_content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection