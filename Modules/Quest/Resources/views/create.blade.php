@extends('layouts.main-closed') 

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection 

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        const product_variants = {!!json_encode($product_variant_groups)!!};
        let counter_rule = {{count($details)}};
        function addRule() {
            const template = `
                <div class="portlet light bordered detail-container-item" id="detail-container-item-${counter_rule}">
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama rule quest" data-container="body"></i>
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
                                    <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="Syarat penyelesaian quest secara global.<br/>
                                            <b>Transaction Nominal</b>: Total Nominal transaksi<br/>
                                            <b>Transaction Total</b>: Jumlah melakukan transaksi<br/>
                                            <b>Total Product</b>: Total produk yang dibeli<br/>
                                            <b>Outlet Different</b>: Transaksi di beberapa outlet<br/>
                                            <b>Province Different</b>: Transaksi di beberapa provinsi<br/>" data-container="body"></i>
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
                                    <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="Syarat tambahan penyelesaian quest untuk setiap transaksinya.<br/>
                                            <b>Transaction</b>: Nominal minimal setiap transaksi<br/>
                                            <b>Product</b>: Jumlah melakukan transaksi<br/>
                                            <b>Additional</b>: Outlet / Provinsi dilakukannya transaksi<br/>
                                    " data-container="body"></i>
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah minimal nominal transaksi" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form-control digit_mask nominal_transaksi" name="detail[${counter_rule}][trx_nominal]" placeholder="Transaction Nominal">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang harus dibeli" data-container="body"></i>
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
                                        <i class="fa fa-question-circle tooltips" data-original-title="Produk yang harus dibeli" data-container="body"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-icon right">
                                            <select class="form-control select2 id_product" data-placeholder="Select Product" name="detail[${counter_rule}][id_product]">
                                                <option></option>
                                                @foreach ($product as $item)
                                                    <option value="{{$item['id_product']}}">{{$item['product_code'] ?? ''}} - {{$item['product_name']}}</option>
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
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang harus dibeli" data-container="body"></i>
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
                                        <i class="fa fa-question-circle tooltips" data-original-title="Produk varian yang harus dibeli" data-container="body"></i>
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Outlet/provinsi tempat transaksi" data-container="body"></i>
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
                                <div class="col-md-4 select_outlet_group" style="margin-top: 10px">
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah nominal transaksi untuk menyelesaikan quest" data-container="body"></i>
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah transaksi untuk menyelesaikan quest" data-container="body"></i>
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang harus dibeli untuk menyelesaikan quest" data-container="body"></i>
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah outlet tempat transaksi untuk menyelesaikan quest" data-container="body"></i>
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
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah provinsi tempat transaksi untuk menyelesaikan quest" data-container="body"></i>
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
            $('#detail-container').append(template);
            $(`#detail-container-item-${counter_rule} .quest_rule`).change();
            $(`#detail-container-item-${counter_rule} .rule_trx`).change();
            $(`#detail-container-item-${counter_rule} .rule_product`).change();
            $(`#detail-container-item-${counter_rule} .rule_additional`).change();
            $(`#detail-container-item-${counter_rule} .rule_product_variant`).change();
            $(`#detail-container-item-${counter_rule} .additional_rule_type`).change();
            $(`#detail-container-item-${counter_rule} .digit_mask`).inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 0,
                autoGroup: true,
                rightAlign: false,
                removeMaskOnSubmit: true, 
            });
            $(`#detail-container-item-${counter_rule} .select2`).select2({
                allowClear: true,
            });

            counter_rule++;
        }

        function addTextContent(target, text){
            var textvalue = $(target).val();

            var textvaluebaru = textvalue+" "+text;
            $(target).val(textvaluebaru);
        }

        $(document).ready(function() {
            $("body").tooltip({ selector: '.tooltips' });

            $('.select2').select2({
                allowClear: true,
            });

            $('.select2_rule').select2();

            $(".file").change(function(e) {
                console.log($(this))
                var btnRemove = $(this).parent().next()[0]
                var widthImg  = 500;
                var heightImg = 500;

                var _URL = window.URL || window.webkitURL;
                var image, file;

                if ((file = this.files[0])) {
                    image = new Image();

                    image.onload = function() {
                        if (this.width != widthImg && this.height != heightImg) {
                            toastr.warning("Please check dimension of your photo.");
                            btnRemove.click()
                        }
                    };
                    image.src = _URL.createObjectURL(file);
                }

            });

            $(".form_datetime").datetimepicker({
                format: "d-M-yyyy hh:ii",
                autoclose: true,
                todayBtn: true,
                minuteStep: 1
            });

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

            $('.digit_mask').inputmask("numeric", {
                radixPoint: ",",
                groupSeparator: ".",
                digits: 0,
                autoGroup: true,
                rightAlign: false,
                removeMaskOnSubmit: true, 
            });

            $('#detail-container').on('change', '.quest_rule', function() {
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
                    $('#detail-container .rule_trx').change();
                    $('#detail-container .rule_product').change();
                    $('#detail-container .rule_additional').change();
                    $('#detail-container .rule_product_variant').change();
                } else {
                    parent.find('.additional_rule').hide();
                    parent.find('.additional_rule :input').prop('disabled', true);
                }
            });
            $('#detail-container .quest_rule').change();

            $('#detail-container').on('change', '.rule_trx', function() {
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
            $('#detail-container .rule_trx').change();

            $('#detail-container').on('change', '.rule_product', function() {
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
            $('#detail-container .rule_product').change();

            $('#detail-container').on('change', '.rule_additional', function() {
                const parent = $(this).parents('.detail-container-item');
                const rule_form = parent.find('.additional_rule_form');

                if ($(this).is(':checked') && !$(this).prop('disabled')) {
                    rule_form.show();
                    rule_form.find(':input').removeAttr('disabled');
                } else {
                    rule_form.hide();
                    rule_form.find(':input').prop('disabled', true);
                }
                $('#detail-container .additional_rule_type').change();
            });
            $('#detail-container .rule_additional').change();

            $('#detail-container').on('change', '.rule_product_variant', function() {
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
            $('#detail-container .rule_product_variant').change();

            $('#detail-container').on('change', '.id_product', function() {
                const parent = $(this).parents('.detail-container-item');
                const variants = product_variants[$(this).val()];
                if (variants && $(this).val()) {
                    const html = [];
                    const currentVal = parent.find('.id_product_variant').data('value');
                    variants.forEach(item => {
                        html.push(`<option value="${item.id_product_variant_group}">${item.product_variants}</option>`);
                    });
                    parent.find('.id_product_variant').html(html.join(''));
                    parent.find('.id_product_variant').val(currentVal);
                    parent.find('.has_variant').show();
                    parent.find('.has_variant :input').removeAttr('disabled');
                } else {
                    parent.find('.has_variant').hide();
                    parent.find('.has_variant :input').prop('disabled', true);
                }
            });
            $('#detail-container .id_product').change();

            $('#detail-container').on('change', '.additional_rule_type', function() {
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
            $('#detail-container .additional_rule_type').change();
        });
        function removeBox(params) {
            $(params).parents('.detail-container-item').remove()
        }
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
                <span>{{ $title }}</span> @if (!empty($sub_title))
                <i class="fa fa-circle"></i> @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div>
    <br> 

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">New Quest</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('quest/create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Name
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Quest Name" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <input type="text" name="quest[name]" class="form-control" placeholder="Enter quest name" value="{{old('quest.name')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    User Rule Type
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="User Rule Type" data-container="body"></i>
                                </label>
                                <div class="col-md-3">
                                    <select class="form-control select2_rule" name="quest[user_rule_type]" data-placeholder="User Rule Type" required onchange="changeUserRuleType(this.value)">
                                        <option></option>
                                        <option value="all" {{old('quest.user_rule_type') == 'all' ? 'selected' : ''}}>All User</option>
                                        <option value="with_rule" {{old('quest.user_rule_type') == 'with_rule' ? 'selected' : ''}}>With Rule</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="detail_user_rule" @if(old('quest.user_rule_type') == 'all' || empty(old('quest.user_rule_type'))) style="display: none" @endif>
                                <label class="col-md-3 control-label">
                                    User Rule
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="User Rule" data-container="body"></i>
                                </label>
                                <div class="col-md-3">
                                    <select class="form-control select2" id="user_rule_subject" name="quest[user_rule_subject]" data-placeholder="Rule Subject">
                                        <option></option>
                                        <option value="r_quartile" {{old('quest.user_rule_subject') == 'r_quartile' ? 'selected' : ''}}>R</option>
                                        <option value="f_quartile" {{old('quest.user_rule_subject') == 'f_quartile' ? 'selected' : ''}}>F</option>
                                        <option value="m_quartile" {{old('quest.user_rule_subject') == 'm_quartile' ? 'selected' : ''}}>M</option>
                                        <option value="RFMScore" {{old('quest.user_rule_subject') == 'RFMScore' ? 'selected' : ''}}>RFM</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control select2" id="user_rule_operator" name="quest[user_rule_operator]" data-placeholder="Rule Operator">
                                        <option></option>
                                        <option value=">" {{old('quest.user_rule_operator') == '>' ? 'selected' : ''}}>></option>
                                        <option value=">=" {{old('quest.user_rule_operator') == '>=' ? 'selected' : ''}}>>=</option>
                                        <option value="=" {{old('quest.user_rule_operator') == '=' ? 'selected' : ''}}>=</option>
                                        <option value="<" {{old('quest.user_rule_operator') == '<' ? 'selected' : ''}}><</option>
                                        <option value="<=" {{old('quest.user_rule_operator') == '<=' ? 'selected' : ''}}><=</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="quest[user_rule_parameter]" id="user_rule_parameter" class="form-control" placeholder="Rule Param">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Image Quest
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Gambar Quest" data-container="body"></i>
                                    <br>
                                    <span class="required" aria-required="true"> (500*500) </span>
                                </label>
                                <div class="col-md-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                        <img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 150px; max-height: 150px;"></div>
                                        <div id="classImage">
                                            <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" accept="image/*" class="file" name="quest[image]" value="{{ old('quest.image') }}" required>
                                            </span>
                                            <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"> Quest Publish Periode <span class="required" aria-required="true"> * </span> </label>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="quest[publish_start]" value="{{ old('quest.publish_start') }}" required autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Start Publish Quest" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="quest[publish_end]" value="{{ old('quest.publish_end') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="End Publish Quest (Leave this column, if the quest is active forever)" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Quest Calculation Start Date
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai periode perhitungan quest" data-container="body"></i>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="quest[date_start]" value="{{ old('quest.date_start') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Start Peroide Quest" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                Quest Maximum Complete Periode
                                <i class="fa fa-question-circle tooltips" data-original-title="Periode penyelesaian quest oleh user" data-container="body"></i>
                                </label>
                                <div class="col-md-2">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="quest[quest_period_type]" id="radio9" value="dates" class="expiry md-radiobtn" required @if (old('quest.quest_period_type') == 'dates') checked @endif required>
                                            <label for="radio9">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> By Date </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" name="quest[quest_period_type]" id="radio10" value="duration" class="expiry md-radiobtn" required @if (old('quest.quest_period_type') == 'duration') checked @endif required>
                                            <label for="radio10">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Duration </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class=" col-md-offset-3 col-md-2 control-label">
                                    Complete before
                                </div>
                                <div class="col-md-4 dates-only">
                                    <div class="input-icon right">
                                        <div class="input-group">
                                            <input type="text" class="form_datetime form-control" name="quest[date_end]" value="{{ old('quest.date_end') }}" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                                <button class="btn default" type="button">
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Batas akhir user menyelesaikan quest" data-container="body"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 duration-only">
                                    <div class="input-group">
                                        <input type="text" class="form-control digit_mask" name="quest[max_complete_day]" placeholder="Max Complete Day" required  value="{{old('quest.max_complete_day', 1)}}" />
                                        <div class="input-group-addon">day after claimed</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Short Description
                                    <span class="required" aria-required="true"> * </span>
                                    <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat yang ditampilkan di daftar misi" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <textarea name="quest[short_description]" class="form-control" placeholder="Quest Short Description" id="input-quest-short-description" required="">{{ old('quest.short_description') }}</textarea>
                                        <div class="portlet-body" style="margin-bottom: 15px">
                                            <span style="margin-bottom: 5px">You can use this variables to display dynamic information:</span>
                                            <div>
                                                <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addTextContent('#input-quest-short-description', '%deals_title%')">%deals_title%</button>
                                                <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addTextContent('#input-quest-short-description', '%voucher_qty%')">%voucher_qty%</button>
                                                <button type="button" class="btn btn-transparent dark btn-outline btn-xs" onclick="addTextContent('#input-quest-short-description', '%point_received%')">%point_received%</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Autoclaim Quest
                                    <i class="fa fa-question-circle tooltips" data-original-title="Apakah misi harus di claim manual atau otomatis" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="On" data-off-color="default" data-off-text="Off" value="1" name="quest[autoclaim_quest]" id="autoclaim-selector" @if(old('quest.autoclaim_quest')) checked @endif>
                                </div>
                            </div>
                            <div class="form-group manualclaim-only">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                    Quest Claim Limit
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah maksimal klaim untuk quest. Masukan 0 untuk tidak terbatas" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control digit_mask" name="quest[quest_limit]" placeholder="Claim limit" required  value="{{old('quest.quest_limit', 0)}}" />
                                </div>
                            </div>
                        </div>
                        <div class="preview col-md-3 pull-right" style="right: 0;top: 70px; position: sticky">
                            <img src="{{env('STORAGE_URL_VIEW').'img/setting/quest_preview1.png'}}" class="img-responsive">
                            <img src="{{env('STORAGE_URL_VIEW').'img/setting/quest_preview2.png'}}" class="img-responsive" style="padding-top: 10px">
                        </div>
                    </div>

                    <hr>
                    <h4 class="text-center" style="margin-bottom:20px">Benefit</h4>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Benefit Type
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Hadiah yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2" id="benefit-selector" name="quest_benefit[benefit_type]" data-placeholder="Benefit Type" required>
                                <option value="point" {{old('quest_benefit.benefit_type') == 'point' ? 'selected' : ''}}>{{env('POINT_NAME', 'Points')}}</option>
                                <option value="voucher" {{old('quest_benefit.benefit_type') == 'voucher' ? 'selected' : ''}}>Voucher</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="benefit-voucher">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Benefit Voucher
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Voucher yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control select2" name="quest_benefit[id_deals]" data-placeholder="Select Voucher" required>
                                <option></option>
                                @foreach($deals as $deal)
                                    @if($deal['deals_total_voucher'] > $deal['deals_total_claimed'] || $deal['deals_voucher_type'] == 'Unlimited')
                                        <option value="{{$deal['id_deals']}}" {{old('quest_benefit.id_deals') == $deal['id_deals'] ? 'selected' : ''}}>{{$deal['deals_title']}} ({{($deal['deals_voucher_expired'] ?? null) ? date('d F Y H:i', strtotime($deal['deals_voucher_expired'])) : ($deal['deals_voucher_duration'] ?? '-') . ' days'}})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control digit_mask" name="quest_benefit[value]" placeholder="Total Voucher" required value="{{old('quest_benefit.value', 1)}}"/>
                                <span class="input-group-addon">Voucher/User</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="benefit-point">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Benefit Point Nominal
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nominal point yang akan didapatkan setelah menyelesaikan quest" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control digit_mask" name="quest_benefit[value]" placeholder="Nominal Point" required  value="{{old('quest_benefit.value', 0)}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Autoclaim Benefit
                            <i class="fa fa-question-circle tooltips" data-original-title="Apakah hadiah langsung didapatkan ketika menyelesaikan misi atau harus klaim manual" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="checkbox" class="make-switch brand_status" data-size="small" data-on-color="info" data-on-text="On" data-off-color="default" data-off-text="Off" value="1" name="quest_benefit[autoclaim_benefit]" @if(old('quest_benefit.autoclaim_benefit')) checked @endif>
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-center" style="margin-bottom:20px">Quest Rule</h4>
                    <div class="row">
                        <div class="col-md-9">
                            <div id="detail-container">
                                @foreach($details as $index => $detail)
                                <div class="portlet light bordered detail-container-item">
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
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Nama rule quest" data-container="body"></i>
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="detail[{{$index}}][name]" placeholder="Detail Quest Name" required maxlength="40" value="{{$detail['name'] ?? ''}}">
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
                                                        <textarea name="detail[{{$index}}][short_description]" class="form-control" placeholder="Quest Detail Short Description">{{$detail['short_description'] ?? ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Total Rule
                                                    <i class="fa fa-question-circle tooltips"  data-html="true" data-original-title="Syarat penyelesaian quest secara global.<br/>
                                            <b>Transaction Nominal</b>: Total Nominal transaksi<br/>
                                            <b>Transaction Total</b>: Jumlah melakukan transaksi<br/>
                                            <b>Total Product</b>: Total produk yang dibeli<br/>
                                            <b>Outlet Different</b>: Transaksi di beberapa outlet<br/>
                                            <b>Province Different</b>: Transaksi di beberapa provinsi<br/>" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <select class="form-control select2 quest_rule" name="detail[{{$index}}][quest_rule]" data-placeholder="Select Quest Rule" required>
                                                                <option></option>
                                                                <option value="nominal_transaction" {{($detail['quest_rule'] ?? '') == 'nominal_transaction' ? 'selected' : ''}}>Transaction Nominal</option>
                                                                <option value="total_transaction" {{($detail['quest_rule'] ?? '') == 'total_transaction' ? 'selected' : ''}}>Transaction Total</option>
                                                                <option value="total_product" {{($detail['quest_rule'] ?? '') == 'total_product' ? 'selected' : ''}}>Product Total</option>
                                                                <option value="total_outlet" {{($detail['quest_rule'] ?? '') == 'total_outlet' ? 'selected' : ''}}>Outlet Different</option>
                                                                <option value="total_province" {{($detail['quest_rule'] ?? '') == 'total_province' ? 'selected' : ''}}>Province Different</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group additional_rule">
                                                <label class="col-md-3 control-label">
                                                    Additional Rule
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="Syarat tambahan penyelesaian quest untuk setiap transaksinya.<br/>
                                                            <b>Transaction</b>: Nominal minimal setiap transaksi<br/>
                                                            <b>Product</b>: Jumlah melakukan transaksi<br/>
                                                            <b>Additional</b>: Outlet / Provinsi dilakukannya transaksi<br/>
                                                    " data-container="body"></i>
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="mt-checkbox-inline">
                                                        <label class="mt-checkbox rule_transaction not_nominal_transaction">
                                                            <input type="checkbox" class="rule_trx" name="detail[{{$index}}][input_rule_trx]" {{($detail['input_rule_trx'] ?? '') ? 'checked' : ''}}/> Transaction
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox rule_product_add">
                                                            <input type="checkbox" class="rule_product" name="detail[{{$index}}][input_rule_product]" {{($detail['input_rule_product'] ?? '') ? 'checked' : ''}}> Product
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-checkbox additionalnya not_total_province">
                                                            <input type="checkbox" class="rule_additional" name="detail[{{$index}}][input_rule_additional]" {{($detail['input_rule_additional'] ?? '') ? 'checked' : ''}}> Additional
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group trx_rule_form">
                                                <div class="input-icon right">
                                                    <label class="col-md-3 control-label">
                                                    Transaction Rule
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah minimal nominal transaksi" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control digit_mask nominal_transaksi" name="detail[{{$index}}][trx_nominal]" placeholder="Transaction Nominal" value="{{$detail['trx_nominal'] ?? ''}}">
                                                            <span class="input-group-btn">
                                                                <button class="btn default" type="button">
                                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang harus dibeli" data-container="body"></i>
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
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Produk yang harus dibeli" data-container="body"></i>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-icon right">
                                                            <select class="form-control select2 id_product" data-placeholder="Select Product" name="detail[{{$index}}][id_product]">
                                                                <option></option>
                                                                @foreach ($product as $item)
                                                                    <option value="{{$item['id_product']}}" {{($detail['id_product'] ?? '') == $item['id_product'] ? 'selected': ''}}>{{$item['product_code'] ?? ''}} - {{$item['product_name']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 not_total_product">
                                                        <div class="input-icon right">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control total_product product_total_rule" name="detail[{{$index}}][product_total]" placeholder="Total Product" value="{{$detail['product_total'] ?? ''}}">
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button">
                                                                        <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang harus dibeli" data-container="body"></i>
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
                                                        <i class="fa fa-question-circle tooltips" data-original-title="Produk variant yang harus dibeli" data-container="body"></i>
                                                        </label>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mt-checkbox-inline">
                                                            <label class="mt-checkbox" style="margin-left: 15px;">
                                                                <input type="checkbox" class="use_variant rule_product_variant" {{($detail['id_product_variant_group'] ?? '') ? 'checked' : ''}}> Use Variant
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-offset-3 col-md-4 product_variant_rule_form">
                                                        <div class="input-icon right">
                                                            <select class="form-control select2 id_product_variant" data-placeholder="Select Variant" name="detail[{{$index}}][id_product_variant_group]" data-value="{{$detail['id_product_variant_group'] ?? ''}}">
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
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Outlet tempat transaksi" data-container="body"></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2 additional_rule_type" data-placeholder="Select Province" name="detail[{{$index}}][additional_rule_type]">
                                                            <option value="province" class="province_option" {{($detail['additional_rule_type'] ?? '') == 'province' ? 'selected': ''}}>Province</option>
                                                            <option value="outlet" {{($detail['additional_rule_type'] ?? '') == 'outlet' ? 'selected': ''}}>Outlet</option>
                                                            <option value="outlet_group" {{($detail['additional_rule_type'] ?? '') == 'outlet_group' ? 'selected': ''}}>Outlet Group Filter</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 select_province">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2 id_province province_total_rule" data-placeholder="Provinsi tempat transaksi" name="detail[{{$index}}][id_province]">
                                                            <option></option>
                                                            @foreach ($province as $item)
                                                                <option value="{{$item['id_province']}}" {{($detail['id_province'] ?? '') == $item['id_province'] ? 'selected': ''}}>{{$item['province_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 select_outlet">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2 id_outlet" data-placeholder="Select Outlet" name="detail[{{$index}}][id_outlet]">
                                                            <option></option>
                                                            @foreach ($outlet as $item)
                                                                <option value="{{$item['id_outlet']}}" {{($detail['id_outlet'] ?? '') == $item['id_outlet'] ? 'selected': ''}}>{{$item['outlet_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 select_outlet_group">
                                                    <div class="input-icon right">
                                                        <select class="form-control select2 id_outlet_group" data-placeholder="Select Outlet Group Filter" name="detail[{{$index}}][id_outlet_group]">
                                                            <option></option>
                                                            @foreach ($outlet_group_filters as $item)
                                                                <option value="{{$item['id_outlet_group']}}" {{($detail['id_outlet_group'] ?? '') == $item['id_outlet_group'] ? 'selected': ''}}>{{$item['outlet_group_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form_switch nominal_transaction_form">
                                                <label class="col-md-3 control-label">
                                                    Transaction Nominal
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Nominal transaksi untuk menyelesaikan quest" data-container="body"></i>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control digit_mask" name="detail[{{$index}}][trx_nominal]" placeholder="Transaction Nominal" value="{{$detail['trx_nominal'] ?? ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form_switch total_transaction_form">
                                                <label class="col-md-3 control-label">
                                                    Transaction Total
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah transaksi untuk menyelesaikan quest" data-container="body"></i>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control digit_mask" name="detail[{{$index}}][trx_total]" placeholder="Transaction Total" value="{{$detail['trx_total'] ?? ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form_switch total_product_form">
                                                <label class="col-md-3 control-label">
                                                    Product Total
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah produk yang harus dibeli untuk menyelesaikan quest" data-container="body"></i>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control digit_mask" name="detail[{{$index}}][product_total]" placeholder="Product Total" value="{{$detail['product_total'] ?? ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form_switch total_outlet_form">
                                                <label class="col-md-3 control-label">
                                                    Outlet Total
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah outlet tempat transaksi untuk menyelesaikan quest" data-container="body"></i>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control digit_mask" name="detail[{{$index}}][different_outlet]" placeholder="Outlet Total" value="{{$detail['different_outlet'] ?? ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form_switch total_province_form">
                                                <label class="col-md-3 control-label">
                                                    Province Total
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Jumlah provinsi tempat transaksi untuk menyelesaikan quest" data-container="body"></i>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control digit_mask" name="detail[{{$index}}][different_province]" placeholder="Province Total" value="{{$detail['different_province'] ?? ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="preview col-md-3 pull-right" style="right: 0;top: 70px; position: sticky">
                            <img src="{{env('STORAGE_URL_VIEW').'img/setting/quest_detail_preview.png'}}" class="img-responsive">
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="javascript:;" class="btn btn-success add" onclick="addRule()">
                            <i class="fa fa-plus"></i> Add New Input
                        </a>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                            <button type="button" class="btn default">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
