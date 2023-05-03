@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script>
        @if(isset($result['bundling_periode_day'][0]['time_start']))
            $('.timepicker-24').timepicker({
                autoclose: true,
                minuteStep: 5,
                showSeconds: false,
                showMeridian: false
            });
        @endif
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

        $(".form_datetime").datetimepicker({
            format: "d-M-yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            minuteStep:1
        });

        $("#fieldphoto").change(function(e) {
            var widthImg  = 300;
            var heightImg = 300;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                        //    $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $('#imageproduct').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA');
                        $('#fieldphoto').val("");

                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });

        $("#fieldphotoDetail").change(function(e) {
            var widthImg  = 720;
            var heightImg = 360;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width != widthImg || this.height != heightImg) {
                        toastr.warning("Please check dimension of your photo.");
                        $('#imageproductDetail').children('img').attr('src', 'https://www.placehold.it/720x360/EFEFEF/AAAAAA');
                        $('#fieldphotoDetail').val("");
                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });

        var tmpBrand = new Map();
        var i='{{$count_list_product}}';
        function addProduct() {
            var brands = <?php echo json_encode($brands)?>;
            var html = '';
            html += '<div id="product_'+i+'">';
            html += '<hr style="border-top: 2px dashed;">';
            html += '<div class="row">';
            html += '<div class="col-md-6">';
            html += '<div class="form-group">';
            html += '<label for="multiple" class="control-label col-md-4">Brand <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<select  class="form-control select2 select2-multiple-product brands" name="data_product['+i+'][id_brand]" id="brand_'+i+'" data-placeholder="Select brand" required onchange="loadProduct(this.value, '+i+')">';
            html += '<option></option>';
            for(var j=0;j<brands.length;j++){
                html += '<option value='+brands[j].id_brand+'>'+brands[j].name_brand+'</option>';
            }
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label for="multiple" class="control-label col-md-4">Product <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][id_product]" id="select_product_'+i+'" data-placeholder="Select product" required disabled onchange="loadProductVariant(this.value, '+i+')">';
            html += '<option></option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label for="multiple" class="control-label col-md-4">Product Variant</label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][id_product_variant_group]" id="product_variant_'+i+'" data-placeholder="Select product variant" disabled onchange="loadPrice('+i+', null, this.value)">';
            html += '<option></option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-4 control-label">Global Price</label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<input type="text" placeholder="Global Price" id="global_price_'+i+'" class="form-control" disabled>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-4 control-label">Quantity <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-8">';
            html += '<div class="input-icon right">';
            html += '<input type="text" placeholder="Quantity" class="form-control" name="data_product['+i+'][qty]" required>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-6">';
            html += '<div class="form-group">';
            html += '<label for="multiple" class="control-label col-md-5">Discount Type <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<select  class="form-control select2 select2-multiple-product" name="data_product['+i+'][discount_type]" data-placeholder="Select discount type" required onchange="changeDisableMaxDiscoint(this.value, '+i+')">';
            html += '<option></option>';
            html += '<option value="Percent">Percent</option>';
            html += '<option value="Nominal">Nominal</option>';
            html += '</select>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-5 control-label">Discount Per Item<span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Diskon berlaku untuk 1 item" data-container="body"></i></label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<input type="text" placeholder="Discount" class="form-control" name="data_product['+i+'][discount]" id="discount_per_item_'+i+'" required>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-5 control-label">Max Discount Per Item <span class="required" aria-required="true"> * </span>';
            html += '<i class="fa fa-question-circle tooltips" data-original-title="Maksimum diskon untuk setiap item" data-container="body"></i>';
            html += '</label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_'+i+'" name="data_product['+i+'][maximum_discount]" disabled>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-5 control-label">Charged Central <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<div class="input-group">';
            html += '<input type="text" placeholder="Charged Central" class="form-control" name="data_product['+i+'][charged_central]" required>';
            html += '<span class="input-group-addon">%</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="form-group">';
            html += '<label class="col-md-5 control-label">Charged Outlet <span class="required" aria-required="true"> * </span></label>';
            html += '<div class="col-md-7">';
            html += '<div class="input-icon right">';
            html += '<div class="input-group">';
            html += '<input type="text" placeholder="Charged Outlet" class="form-control" name="data_product['+i+'][charged_outlet]" required>';
            html += '<span class="input-group-addon">%</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div style="text-align: right"><a class="btn red" onclick="deleteProduct('+i+')">Delete Product <i class="fa fa-trash"></i></a></div>';
            html += '</div>';

            $("#list_product").append(html);
            $('.select2-multiple-product').select2({
                'placeholder':$(this).data('placeholder')
            });
            i++;
        }

        function deleteProduct(id, id_bundling_product = null) {
            var check = $("#available_outlet").select2("val");

            if(check !== 'null' && check !== null && check !== ""){
                if(confirm("Are you sure delete this product? \nIf you delete this product, field outlet available will be reset?")){
                    if(id_bundling_product){
                        var token  = "{{ csrf_token() }}";
                        $.ajax({
                            type: "POST",
                            url: "{{url('product-bundling/delete-product')}}",
                            data : {
                                "_token" : token,
                                "id_bundling_product" : id_bundling_product
                            },
                            success: function(result){
                                if(result.status == 'success'){
                                    $("#product_"+id).remove();
                                    toastr.info("Success delete bundling product.");
                                }else{
                                    toastr.warning("Failed delete bundling product, bundling product already use.");
                                }
                            },
                            error : function(result) {
                                toastr.warning("Failed delete bundling product.");
                            }
                        });
                    }else{
                        $("#product_"+id).remove();
                        tmpBrand.delete('brand_'+id);
                        loadOutlet();
                    }
                }
            }else{
                if(confirm("Are you sure delete this product?")) {
                    $("#product_"+id).remove();
                }
            }
        }

        $('.brands').on("select2:selecting", function(e) {
            var id = this.id;
            var list_count = id.split('_')[1];
            var check = $("#available_outlet").select2("val");
            var prev_id_brand = $("#brand_"+list_count).val();
            $("#global_price_"+id).val('');
            $("#product_variant_"+id).empty();

            if(check !== 'null' && check !== null && check !== ""){
                if(confirm("Are you sure change this brand? \nIf you change this brand, field outlet available will be reset?")){
                    $("#available_outlet").empty();
                }else{
                    e.preventDefault();
                }
            }
        });

        function loadOutlet() {
            $("#available_outlet").empty();
            $("#available_outlet").append('<option></option>');
            $("#available_outlet").append('<option value="all">All Outlet</option>');
            var token  = "{{ csrf_token() }}";
            var brands = Array.from(tmpBrand, ([name, value]) => ({ value }));
            var brand_tmp  = <?php echo $brand_tmp?>;

            $.ajax({
                type: "POST",
                url: "{{url('product-bundling/outlet-available')}}",
                data : {
                    "_token" : token,
                    "brands" : brands,
                    "brand_tmp" : brand_tmp
                },
                success: function(result){
                    if(result.status == 'success'){
                        var data = result.result;
                        var length = result.result.length;
                        for(var i=0;i<length;i++){
                            $("#available_outlet").append('<option value="'+data[i].id_outlet+'">'+data[i].outlet_code+' - '+data[i].outlet_name+'</option>');
                        }
                    }
                },
                error : function(result) {
                    toastr.warning("Failed get data outlet.");
                }
            });
        }

        function loadProduct(id_brand, list_count) {
            $("#select_product_"+list_count).prop('disabled', true);
            $("#global_price_"+list_count).val('');
            $("#select_product_"+list_count).empty();
            $("#select_product_"+list_count).append('<option></option>');
            var token  = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{url('product-bundling/product-brand')}}",
                data : {
                    "_token" : token,
                    "id_brand" : id_brand
                },
                success: function(result){
                    if(result.status == 'success'){
                        var data = result.result;
                        var length = result.result.length;
                        for(var i=0;i<length;i++){
                            $("#select_product_"+list_count).append('<option value="'+data[i].id_product+'">'+data[i].product_code+' - '+data[i].product_name+'</option>');
                        }
                        $("#select_product_"+list_count).prop('disabled', false);
                    }else{
                        $("#select_product_"+list_count).prop('disabled', true);
                    }
                    var key_name = "brand_"+list_count;
                    tmpBrand.set(key_name, id_brand);
                    loadOutlet();
                },
                error : function(result) {
                    $("#select_product_"+list_count).prop('disabled', true);
                    toastr.warning("Failed get data product.");
                }
            });
        }

        function loadProductVariant(id_product, list_count) {
            $("#global_price_"+list_count).val('');
            $("#product_variant_"+list_count).empty();
            $("#product_variant_"+list_count).append('<option></option>');
            $.ajax({
                type: "GET",
                url: "{{url('product-variant-group/ajax')}}/"+id_product,
                success: function(result){
                    var length = result.length;
                    if(length > 0){
                        $("#product_variant_"+list_count).prop('disabled', false);
                        for(var i=0;i<length;i++){
                            $("#product_variant_"+list_count).append('<option value="'+result[i].id_product_variant_group+'">'+result[i].product_variant_group_name+'</option>');
                        }
                    }else{
                        loadPrice(list_count, id_product, null);
                        $("#product_variant_"+list_count).prop('disabled', true);
                    }
                },
                error : function(result) {
                    $("#product_variant_"+list_count).prop('disabled', true);
                    toastr.warning("Failed get data product variant.");
                }
            });
        }

        function loadPrice(id_element, id_product, id_product_variant_group) {
            $("#global_price_"+id_element).val('');
            var token  = "{{ csrf_token() }}";

            $.ajax({
                type: "POST",
                url: "{{url('product-bundling/global-price')}}",
                data : {
                    "_token" : token,
                    "id_product" : id_product,
                    "id_product_variant_group" : id_product_variant_group
                },
                success: function(result){
                    if(result.status == 'success'){
                        $("#global_price_"+id_element).val(result.result.price);
                    }else{
                        toastr.warning("Failed get global price.");
                    }
                },
                error : function(result) {
                    toastr.warning("Failed get global price.");
                }
            });
        }

        function changeDisableMaxDiscoint(value, list_count) {
            $("#discount_per_item_"+list_count).val('');
            $("#maximum_discount_"+list_count).val('');
            if(value == 'Percent'){
                $("#maximum_discount_"+list_count).prop('disabled', false);
                $("#maximum_discount_"+list_count).prop('required', true);
            }else{
                $("#maximum_discount_"+list_count).prop('disabled', true);
                $("#maximum_discount_"+list_count).prop('required', false);
            }
        }

        var period_type = '{{$result['bundling_specific_day_type']}}';
        var tmp_day = <?php echo json_encode(array_column($result['bundling_periode_day'], 'day'))?>;
        var tmp_date = <?php echo json_encode(array_column($result['bundling_periode_day'], 'day'))?>;
        function changeSpecificDay(value) {
            $("#day").prop('disabled', true);
            $("#day").empty();
            $("#day").append('<option></option>');
            if(value == 'not_specific_day'){
                $("#day").prop('disabled', true);
                $("#day").prop('required', false);
                $("#time_start").prop('readonly', true);
                $("#time_end").prop('readonly', true);
                $("#time_start").prop('required', false);
                $("#time_end").prop('required', false);
                $("#time_start").val('');
                $("#time_end").val('');
                $('#time_start').data('timepicker').remove();
                $('#time_end').data('timepicker').remove();
            }else if(value == 'Day'){

                if(tmp_day.length > 0 && period_type == 'Day'){
                    var day = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    for(var j=0;j<day.length;j++){
                        if(tmp_day.indexOf(day[j]) >= 0){
                            $("#day").append('<option value="'+day[j]+'" selected>'+day[j]+'</option>');
                        }else{
                            $("#day").append('<option value="'+day[j]+'">'+day[j]+'</option>');
                        }
                    }
                }else{
                    $("#day").append('<option value="Sunday">Sunday</option>');
                    $("#day").append('<option value="Monday">Monday</option>');
                    $("#day").append('<option value="Tuesday">Tuesday</option>');
                    $("#day").append('<option value="Wednesday">Wednesday</option>');
                    $("#day").append('<option value="Thursday">Thursday</option>');
                    $("#day").append('<option value="Friday">Friday</option>');
                    $("#day").append('<option value="Saturday">Saturday</option>');
                }

                $("#day").prop('disabled', false);
                $("#day").prop('required', true);
                $('.timepicker-24').timepicker({
                    autoclose: true,
                    minuteStep: 5,
                    showSeconds: false,
                    showMeridian: false
                });
                $("#time_start").prop('readonly', false);
                $("#time_end").prop('readonly', false);
                $("#time_start").prop('required', true);
                $("#time_end").prop('required', true);
            }else if(value == 'Date'){
                if(tmp_date.length > 0 && period_type == 'Date'){
                    for (var i= 1;i<=31;i++){
                        if(tmp_date.indexOf(i.toString()) >= 0){
                            $("#day").append('<option value="'+i+'" selected>'+i+'</option>');
                        }else{
                            $("#day").append('<option value="'+i+'">'+i+'</option>');
                        }
                    }
                }else{
                    for (var i= 1;i<=31;i++){
                        $("#day").append('<option value="'+i+'">'+i+'</option>');
                    }
                }

                $("#day").prop('disabled', false);
                $("#day").prop('required', true);
                $('.timepicker-24').timepicker({
                    autoclose: true,
                    minuteStep: 5,
                    showSeconds: false,
                    showMeridian: false
                });
                $("#time_start").prop('readonly', false);
                $("#time_end").prop('readonly', false);
                $("#time_start").prop('required', true);
                $("#time_end").prop('required', true);
            }
        }

        function changeOutletType(value) {
            if(value == 'Selected Outlet'){
                document.getElementById('div_selected_outlet').style.display = 'block';
                document.getElementById('div_outlet_group_filter').style.display = 'none';
                $("#available_outlet_group_filter").prop('required', false);
                $("#available_outlet").prop('required', true);
            }else if(value == 'Outlet Group Filter'){
                document.getElementById('div_selected_outlet').style.display = 'none';
                document.getElementById('div_outlet_group_filter').style.display = 'block';
                $("#available_outlet_group_filter").prop('required', true);
                $("#available_outlet").prop('required', false);
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

    <a href="{{url('product-bundling')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">{{$sub_title}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('product-bundling/update')}}/{{$result['id_bundling']}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundling ID <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Bundling ID (unique)" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Bundling ID" class="form-control" value="{{ $result['bundling_code'] }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundling Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Bundling name" class="form-control" name="bundling_name" value="{{ $result['bundling_name']}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundling Category <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Category bundling" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="id_bundling_category" data-placeholder="Select category" required>
                                    <option></option>
                                    @foreach($category as $c)
                                        <option value="{{$c['id_bundling_category']}}" @if($result['id_bundling_category'] == $c['id_bundling_category']) selected @endif>{{$c['bundling_category_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundling Promo Status <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product" name="bundling_promo_status" data-placeholder="Select discount type" required>
                                    <option></option>
                                    <option value="1" @if($result['bundling_promo_status'] == 1) selected @endif>Include For Promo</option>
                                    <option value="0" @if($result['bundling_promo_status'] == 0) selected @endif>Not Include For Promo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Bundling Periode <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Produk bandling akan muncul pada aplikasi berdasarkan periode yang dipilih" data-container="body"></i></label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="bundling_start" value="{{date('d-M-Y H:i', strtotime($result['start_date']))}}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal mulai Product Bundling" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="form_datetime form-control" name="bundling_end" value="{{date('d-M-Y H:i', strtotime($result['end_date']))}}" required autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                        <button class="btn default" type="button">
                                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal berakhir Product Bundling" data-container="body"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Specific Day Type
                            <i class="fa fa-question-circle tooltips" data-original-title="Produk bundling akan tampil berdasarkan hari yang dipilih sesuai periode, jika 'specific date' tidak diisi, maka bundling akan muncul selama periode berlangsung" data-container="body"></i></label>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product"  name="bundling_specific_day_type" data-placeholder="Select day type" onchange="changeSpecificDay(this.value)">
                                    <option></option>
                                    <option value="not_specific_day" @if(empty($result['bundling_specific_day_type'])) selected @endif>All Day</option>
                                    <option value="Day" @if($result['bundling_specific_day_type'] == "Day") selected @endif>Day</option>
                                    <option value="Date" @if($result['bundling_specific_day_type'] == "Date") selected @endif>Date</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Day / Date</label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product"  multiple data-placeholder="Select day or date" name="day_date[]" id="day"  @if(empty($result['bundling_periode_day'])) disabled @else required @endif>
                                    <option></option>
                                    @if(!empty($result['bundling_periode_day']))
                                        <?php
                                        $arr = array_column($result['bundling_periode_day'], 'day');
                                        ?>
                                        @if($result['bundling_specific_day_type'] == "Day")
                                            <option value="Sunday" @if(in_array("Sunday", $arr)) selected @endif>Sunday</option>
                                            <option value="Monday" @if(in_array("Monday", $arr)) selected @endif>Monday</option>
                                            <option value="Tuesday" @if(in_array("Tuesday", $arr)) selected @endif>Tuesday</option>
                                            <option value="Wednesday" @if(in_array("Wednesday", $arr)) selected @endif>Wednesday</option>
                                            <option value="Thursday" @if(in_array("Thursday", $arr)) selected @endif>Thursday</option>
                                            <option value="Friday" @if(in_array("Friday", $arr)) selected @endif>Friday</option>
                                            <option value="Saturday" @if(in_array("Saturday", $arr)) selected @endif>Saturday</option>
                                        @else
                                            @for($i=1;$i<=31;$i++)
                                                <option value="{{$i}}" @if(in_array($i, $arr)) selected @endif>{{$i}}</option>
                                            @endfor
                                        @endif
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3"></label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="timepicker-24 form-control" name="time_start" value="{{(isset($result['bundling_periode_day'][0]['time_start']) ? date('H:i', strtotime($result['bundling_periode_day'][0]['time_start'])) : "")}}" id="time_start" @if(!isset($result['bundling_periode_day'][0]['time_start'])) readonly @endif>
                                    <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-question-circle tooltips" data-original-title="Waktu mulai Product Bundling" data-container="body"></i>
                                            </button>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <div class="input-group">
                                    <input type="text" class="timepicker-24 form-control" name="time_end" value="{{(isset($result['bundling_periode_day'][0]['time_end']) ? date('H:i', strtotime($result['bundling_periode_day'][0]['time_end'])) : "")}}" id="time_end" @if(!isset($result['bundling_periode_day'][0]['time_end'])) readonly @endif>
                                    <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-question-circle tooltips" data-original-title="Waktu berakhir Product Bundling" data-container="body"></i>
                                            </button>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Photo <span class="required" aria-required="true">* <br>(300*300) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                    <img src="@if(isset($result['image'])){{$result['image']}}@endif" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo" @if(empty($result['image'])) required @endif>
                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Photo Detail <span class="required" aria-required="true">* <br>(720 * 360)</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="height: 150px;">
                                    <img src="@if(isset($result['image_detail'])){{$result['image_detail']}}@endif" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageproductDetail" style="max-height: 2000px;max-width: 250px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="file" id="fieldphotoDetail" accept="image/*" name="photo_detail" @if(empty($result['image_detail'])) required @endif>
                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Description<span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <textarea name="bundling_description" id="text_pro" class="form-control">{{$result['bundling_description']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="text-align: center"><h3>List Product</h3></div>
                    <hr>
                    <div id="list_product">

                        @foreach($result['bundling_product'] as $index=>$bp)
                            <div id="product_{{$index}}">
                                @if($index > 0) <hr style="border-top: 2px dashed;"> @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Brand <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 brands select2-multiple-product" name="data_product[{{$index}}][id_brand]" id="brand_{{$index}}" data-placeholder="Select brand" required onchange="loadProduct(this.value, '{{$index}}')" disabled>
                                                        <option></option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand['id_brand']}}" @if($brand['id_brand'] == $bp['id_brand']) selected @endif>{{$brand['name_brand']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Product <span class="required" aria-required="true"> * </span></label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[{{$index}}][id_product]" id="select_product_{{$index}}" data-placeholder="Select product" required disabled onchange="loadProductVariant(this.value, '{{$index}}')" disabled>
                                                        <option></option>
                                                        @foreach($bp['products'] as $product)
                                                            <option value="{{$product['id_product']}}" @if($product['id_product'] == $bp['id_product']) selected @endif>{{$product['product_code']}} - {{$product['product_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" name="data_product[{{$index}}][id_product]" value="{{$bp['id_product']}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Product Variant</label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[{{$index}}][id_product_variant_group]" id="product_variant_{{$index}}" data-placeholder="Select product variant" @if(empty($bp['id_product_variant_group'])) disabled @endif onchange="loadPrice('{{$index}}', null, this.value)" disabled>
                                                        <option></option>
                                                        @foreach($bp['product_variant'] as $pv)
                                                            <option value="{{$pv['id_product_variant_group']}}" @if($pv['id_product_variant_group'] == $bp['id_product_variant_group']) selected @endif>{{$pv['product_variant_group_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" name="data_product[{{$index}}][id_product_variant_group]" value="{{$bp['id_product_variant_group']}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Global Price
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Global Price" id="global_price_{{$index}}" class="form-control" value="{{$bp['price']}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Quantity <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Quantity" class="form-control" name="data_product[{{$index}}][qty]" value="{{$bp['bundling_product_qty']}}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-5">Discount Type <span class="required" aria-required="true"> * </span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[{{$index}}][discount_type]" data-placeholder="Select discount type" required onchange="changeDisableMaxDiscoint(this.value, '{{$index}}')">
                                                        <option></option>
                                                        <option value="Percent" @if($bp['bundling_product_discount_type'] == 'Percent') selected @endif>Percent</option>
                                                        <option value="Nominal" @if($bp['bundling_product_discount_type'] == 'Nominal') selected @endif>Nominal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Discount Per Item <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Diskon berlaku untuk 1 item" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Discount" class="form-control" name="data_product[{{$index}}][discount]" id="discount_per_item_{{$index}}" @if($bp['bundling_product_discount_type'] == 'Nominal') value="{{(int)$bp['bundling_product_discount']}}" @else value="{{$bp['bundling_product_discount']}}" @endif required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Max Discount Per Item <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Maksimum diskon untuk setiap item, silahkan isi dengan angka 0 jika tidak ingin menggunakan maximum discount" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_{{$index}}" name="data_product[{{$index}}][maximum_discount]" @if($bp['bundling_product_discount_type'] != 'Percent') disabled @endif value="{{(int)$bp['bundling_product_maximum_discount']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Charged Central <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" placeholder="Charged Central" class="form-control" name="data_product[{{$index}}][charged_central]" value="{{$bp['charged_central']}}" required>
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Charged Outlet <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" placeholder="Charged Outlet" class="form-control" name="data_product[{{$index}}][charged_outlet]" value="{{$bp['charged_outlet']}}" required>
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align: right"><a class="btn red" onclick="deleteProduct('{{$index}}', '{{$bp['id_bundling_product']}}')">Delete Product <i class="fa fa-trash"></i></a></div>
                                <input type="hidden" name="data_product[{{$index}}][id_bundling_product]" value="{{$bp['id_bundling_product']}}">
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div style="text-align: right">
                        <a class="btn green" onclick="addProduct()">Add Product <i class="fa fa-plus-circle"></i></a>
                    </div>
                    <br>
                    <div style="text-align: center"><h3>Outlet Available</h3></div>
                    <hr>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-4 control-label">
                                Type
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah outlet available mau berdasarkan selected outlet atau outlet group filter" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios4" name="outlet_available_type" class="md-radiobtn filterType" value="Selected Outlet" required onclick="changeOutletType(this.value)" @if(empty($selected_outlet_group_filter)) checked @endif>
                                    <label for="optionsRadios4">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Selected Outlet</label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios5" name="outlet_available_type" class="md-radiobtn filterType" value="Outlet Group Filter" required onclick="changeOutletType(this.value)" @if(!empty($selected_outlet_group_filter)) checked @endif>
                                    <label for="optionsRadios5">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Outlet Group Filter</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" @if(!empty($selected_outlet_group_filter)) style="display:none;" @endif  id="div_selected_outlet">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Selected Outlet
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang available untuk product bundling yang akan dibuat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2-multiple" data-placeholder="Select" name="id_outlet[]" id="available_outlet" multiple>
                                @if($result['all_outlet'])
                                    <option value="all" selected>All Outlet</option>
                                    @foreach($outlets as $o)
                                        <option value="{{$o['id_outlet']}}">{{$o['outlet_code']}} - {{$o['outlet_name']}}</option>
                                    @endforeach
                                @else
                                    <option value="all">All Outlet</option>
                                    @foreach($outlets as $o)
                                        <option value="{{$o['id_outlet']}}" @if(in_array($o['id_outlet'], $selected_outlet)) selected @endif>{{$o['outlet_code']}} - {{$o['outlet_name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group" @if(empty($selected_outlet_group_filter)) style="display:none;" @endif id="div_outlet_group_filter">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Outlet Group Filter
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet group filter untuk product bundling yang akan dibuat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2-multiple" data-placeholder="Select" name="id_outlet_group[]" id="available_outlet_group_filter" multiple>
                                <option></option>
                                @foreach($outlet_group_filter as $ogf)
                                    <option value="{{$ogf['id_outlet_group']}}" @if(in_array($ogf['id_outlet_group'], $selected_outlet_group_filter)) selected @endif>{{$ogf['outlet_group_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>                
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection