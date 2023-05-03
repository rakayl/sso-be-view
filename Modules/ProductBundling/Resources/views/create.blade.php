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
        var i = 0;
        var outlet_selected = <?php echo json_encode(old('id_outlet'))?>;
        $(document).ready(function() {
            var data_product = <?php echo json_encode((empty(old('data_product')) ? [] : array_values(old('data_product'))))?>;
            if(data_product && data_product.length > 0){
                i=data_product.length + 1;
                for(var a=0;a<data_product.length;a++){
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
                        if(data_product[a].id_brand == brands[j].id_brand){
                            html += '<option value='+brands[j].id_brand+' selected>'+brands[j].name_brand+'</option>';
                        }else{
                            html += '<option value='+brands[j].id_brand+'>'+brands[j].name_brand+'</option>';
                        }
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
                    html += '<input type="text" placeholder="Quantity" class="form-control" name="data_product['+i+'][qty]" value="'+data_product[a].qty+'" required>';
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
                    if(data_product[a].discount_type == 'Percent'){
                        html += '<option value="Percent" selected>Percent</option>';
                        html += '<option value="Nominal">Nominal</option>';
                    }else{
                        html += '<option value="Percent">Percent</option>';
                        html += '<option value="Nominal" selected>Nominal</option>';
                    }

                    html += '</select>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-5 control-label">Discount Per Item<span class="required" aria-required="true"> * </span><i class="fa fa-question-circle tooltips" data-original-title="Diskon berlaku untuk 1 item" data-container="body"></i></label>';
                    html += '<div class="col-md-7">';
                    html += '<div class="input-icon right">';
                    html += '<input type="text" placeholder="Discount" class="form-control" name="data_product['+i+'][discount]" value="'+data_product[a].discount+'" required>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-5 control-label">Max Discount Per Item <span class="required" aria-required="true"> * </span>';
                    html += '<i class="fa fa-question-circle tooltips" data-original-title="Maksimum diskon untuk setiap item" data-container="body"></i>';
                    html += '</label>';
                    html += '<div class="col-md-7">';
                    html += '<div class="input-icon right">';
                    if(data_product[a].discount_type == 'Percent'){
                        html += '<input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_'+i+'" name="data_product['+i+'][maximum_discount]" value="'+data_product[a].maximum_discount+'">';
                    }else{
                        html += '<input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_'+i+'" name="data_product['+i+'][maximum_discount]" disabled>';
                    }

                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-md-5 control-label">Charged Central <span class="required" aria-required="true"> * </span></label>';
                    html += '<div class="col-md-7">';
                    html += '<div class="input-icon right">';
                    html += '<div class="input-group">';
                    html += '<input type="text" placeholder="Charged Central" class="form-control" name="data_product['+i+'][charged_central]" value="'+data_product[a].charged_central+'" required>';
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
                    html += '<input type="text" placeholder="Charged Outlet" class="form-control" name="data_product['+i+'][charged_outlet]" value="'+data_product[a].charged_outlet+'" required>';
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
                    loadProduct(data_product[a].id_brand, i, data_product[a].id_product);
                    loadProductVariant(data_product[a].id_product, i, data_product[a].id_product_variant_group);
                    if(data_product[a].id_product_variant_group){
                        loadPrice(i, null, data_product[a].id_product_variant_group);
                    }else{
                        loadPrice(i, data_product[a].id_product, null);
                    }
                    var key_name = "brand_"+i;
                    tmpBrand.set(key_name, data_product[a].id_brand);
                    i++;
                }
                if(outlet_selected){
                    loadOutlet(outlet_selected);
                }else{
                    loadOutlet();
                }

            }else{
                i=1;
            }
        });

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

        var tmpBrand = new Map();
        function deleteProduct(id) {
            var check = $("#available_outlet").select2("val");

            if(check !== 'null' && check !== null && check !== ""){
                if(confirm("Are you sure delete this product? \nIf you delete this product, field outlet available will be reset?")){
                    $("#product_"+id).remove();
                    tmpBrand.delete('brand_'+id);
                    loadOutlet();
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

        function loadOutlet(selected_outlet = []) {
            $("#available_outlet").empty();
            $("#available_outlet").append('<option></option>');
            if(selected_outlet.length > 0 && selected_outlet.indexOf('all') >= 0){
                $("#available_outlet").append('<option value="all" selected>All Outlet</option>');
            }else{
                $("#available_outlet").append('<option value="all">All Outlet</option>');
            }
            var token  = "{{ csrf_token() }}";
            var brands = Array.from(tmpBrand, ([name, value]) => ({ value }));

            $.ajax({
                type: "POST",
                url: "{{url('product-bundling/outlet-available')}}",
                data : {
                    "_token" : token,
                    "brands" : brands
                },
                success: function(result){
                    if(result.status == 'success'){
                        var data = result.result;
                        var length = result.result.length;
                        for(var i=0;i<length;i++){
                            if(selected_outlet.length > 0 && selected_outlet.indexOf(data[i].id_outlet.toString()) >= 0){
                                $("#available_outlet").append('<option value="'+data[i].id_outlet+'" selected>'+data[i].outlet_code+' - '+data[i].outlet_name+'</option>');
                            }else{
                                $("#available_outlet").append('<option value="'+data[i].id_outlet+'">'+data[i].outlet_code+' - '+data[i].outlet_name+'</option>');
                            }
                        }
                    }
                },
                error : function(result) {
                    toastr.warning("Failed get data outlet.");
                }
            });
        }

        function loadProduct(id_brand, list_count, id_product = null) {
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
                            if(data[i].id_product == id_product){
                                $("#select_product_"+list_count).append('<option value="'+data[i].id_product+'" selected>'+data[i].product_code+' - '+data[i].product_name+'</option>');
                            }else{
                                $("#select_product_"+list_count).append('<option value="'+data[i].id_product+'">'+data[i].product_code+' - '+data[i].product_name+'</option>');
                            }
                        }
                        $("#select_product_"+list_count).prop('disabled', false);
                    }
                    var key_name = "brand_"+list_count;
                    tmpBrand.set(key_name, id_brand);
                    if(!id_product){
                        loadOutlet();
                    }
                },
                error : function(result) {
                    toastr.warning("Failed get data product.");
                }
            });
        }

        function loadProductVariant(id_product, list_count, id_product_variant_group) {
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
                            if(result[i].id_product_variant_group == id_product_variant_group){
                                $("#product_variant_"+list_count).append('<option value="'+result[i].id_product_variant_group+'" selected>'+result[i].product_variant_group_name+'</option>');
                            }else{
                                $("#product_variant_"+list_count).append('<option value="'+result[i].id_product_variant_group+'">'+result[i].product_variant_group_name+'</option>');
                            }
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
                $("#day").append('<option value="Sunday">Sunday</option>');
                $("#day").append('<option value="Monday">Monday</option>');
                $("#day").append('<option value="Tuesday">Tuesday</option>');
                $("#day").append('<option value="Wednesday">Wednesday</option>');
                $("#day").append('<option value="Thursday">Thursday</option>');
                $("#day").append('<option value="Friday">Friday</option>');
                $("#day").append('<option value="Saturday">Saturday</option>');
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
                for (var i= 1;i<=31;i++){
                    $("#day").append('<option value="'+i+'">'+i+'</option>');
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

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">New Product Bundling</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('product-bundling/store')}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundling ID <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Bundling ID (unique)" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Bundling ID" class="form-control" name="bundling_code" value="{{ old('bundling_code') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundling Name <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="input-icon right">
                                <input type="text" placeholder="Bundling name" class="form-control" name="bundling_name" value="{{ old('bundling_name') }}" required>
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
                                        <option value="{{$c['id_bundling_category']}}" @if(old('id_bundling_category') == $c['id_bundling_category']) selected @endif>{{$c['bundling_category_name']}}</option>
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
                                    <option value="1" @if(old('bundling_promo_status') == "1") selected @endif>Include For Promo</option>
                                    <option value="0" @if(old('bundling_promo_status') == "0") selected @endif>Not Include For Promo</option>
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
                                    <input type="text" class="form_datetime form-control" name="bundling_start" value="{{ old('bundling_start') }}" required autocomplete="off">
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
                                    <input type="text" class="form_datetime form-control" name="bundling_end" value="{{ old('bundling_end') }}" required autocomplete="off">
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
                                    <option value="not_specific_day" @if(old('bundling_specific_day_type') == "not_specific_day") selected @endif>All Day</option>
                                    <option value="Day" @if(old('bundling_specific_day_type') == "Day") selected @endif>Day</option>
                                    <option value="Date" @if(old('bundling_specific_day_type') == "Date") selected @endif>Date</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Day / Date</label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <select  class="form-control select2 select2-multiple-product"  multiple data-placeholder="Select day or date" name="day_date[]" id="day"  @if(empty(old('day_date'))) disabled @else required @endif>
                                    <option></option>
                                    @if(!empty(old('day_date')))
                                        @if(old('bundling_specific_day_type') == "Day")
                                            <option value="Sunday" @if(in_array("Sunday", old('day_date'))) selected @endif>Sunday</option>
                                            <option value="Monday" @if(in_array("Monday", old('day_date'))) selected @endif>Monday</option>
                                            <option value="Tuesday" @if(in_array("Tuesday", old('day_date'))) selected @endif>Tuesday</option>
                                            <option value="Wednesday" @if(in_array("Wednesday", old('day_date'))) selected @endif>Wednesday</option>
                                            <option value="Thursday" @if(in_array("Thursday", old('day_date'))) selected @endif>Thursday</option>
                                            <option value="Friday" @if(in_array("Friday", old('day_date'))) selected @endif>Friday</option>
                                            <option value="Saturday" @if(in_array("Saturday", old('day_date'))) selected @endif>Saturday</option>
                                        @else
                                            @for($i=1;$i<=31;$i++)
                                                <option value="{{$i}}" @if(in_array($i, old('day_date'))) selected @endif>{{$i}}</option>
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
                                    <input type="text" class="timepicker-24 form-control" name="time_start" id="time_start" readonly>
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
                                    <input type="text" class="timepicker-24 form-control" name="time_end" id="time_end" readonly>
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
                                <img src="https://www.placehold.it/300x300/EFEFEF/AAAAAA" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageproduct" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="file" id="fieldphoto" accept="image/*" name="photo" required>
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
                                    <img id="preview_image" src="https://www.placehold.it/720x360/EFEFEF/AAAAAA"/>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageproductDetail" style="max-height: 2000px;max-width: 250px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="file" id="fieldphotoDetail" accept="image/*" name="photo_detail" required>
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
                                <textarea name="bundling_description" id="text_pro" class="form-control">{{ old('bundling_description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="text-align: center"><h3>List Product</h3></div>
                    <hr>
                    <div id="list_product">
                        @if(empty(old('data_product')))
                            <div id="product_0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Brand <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 brands select2-multiple-product" name="data_product[0][id_brand]" id="brand_0" data-placeholder="Select brand" required onchange="loadProduct(this.value, 0)">
                                                        <option></option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand['id_brand']}}">{{$brand['name_brand']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Product <span class="required" aria-required="true"> * </span></label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[0][id_product]" id="select_product_0" data-placeholder="Select product" required disabled onchange="loadProductVariant(this.value, 0)">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-4">Product Variant</label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[0][id_product_variant_group]" id="product_variant_0" data-placeholder="Select product variant" onchange="loadPrice(0, null, this.value)" disabled>
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Global Price
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Global Price" id="global_price_0" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Quantity <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Quantity" class="form-control" name="data_product[0][qty]" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="multiple" class="control-label col-md-5">Discount Type <span class="required" aria-required="true"> * </span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <select  class="form-control select2 select2-multiple-product" name="data_product[0][discount_type]" data-placeholder="Select discount type" required onchange="changeDisableMaxDiscoint(this.value, 0)">
                                                        <option></option>
                                                        <option value="Percent">Percent</option>
                                                        <option value="Nominal">Nominal</option>
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
                                                    <input type="text" placeholder="Discount" class="form-control" name="data_product[0][discount]" id="discount_per_item_0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Max Discount Per Item <span class="required" aria-required="true"> * </span>
                                                <i class="fa fa-question-circle tooltips" data-original-title="Maksimum diskon untuk setiap item, silahkan isi dengan angka 0 jika tidak ingin menggunakan maximum discount" data-container="body"></i>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <input type="text" placeholder="Max Discount Per Item" class="form-control" id="maximum_discount_0" name="data_product[0][maximum_discount]" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Charged Central <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <div class="input-group">
                                                        <input type="text" placeholder="Charged Central" class="form-control" name="data_product[0][charged_central]" required>
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
                                                        <input type="text" placeholder="Charged Outlet" class="form-control" name="data_product[0][charged_outlet]" required>
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                    <input type="radio" id="optionsRadios4" name="outlet_available_type" class="md-radiobtn filterType" value="Selected Outlet" required onclick="changeOutletType(this.value)" @if(old('outlet_available_type') == 'Selected Outlet' || empty(old('outlet_available_type'))) checked @endif>
                                    <label for="optionsRadios4">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Selected Outlet</label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios5" name="outlet_available_type" class="md-radiobtn filterType" value="Outlet Group Filter" required onclick="changeOutletType(this.value)" @if(old('outlet_available_type') == 'Outlet Group Filter') checked @endif>
                                    <label for="optionsRadios5">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Outlet Group Filter</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" @if(old('outlet_available_type') == 'Outlet Group Filter') style="display:none;" @endif  id="div_selected_outlet">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Selected Outlet
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang available untuk product bundling yang akan dibuat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control select2-multiple" data-placeholder="Select" name="id_outlet[]" id="available_outlet" multiple>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" @if(old('outlet_available_type') == 'Selected Outlet' || empty(old('outlet_available_type'))) style="display:none;" @endif id="div_outlet_group_filter">
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
                                    <option value="{{$ogf['id_outlet_group']}}" @if(in_array($ogf['id_outlet_group'], old('id_outlet_group')??[])) selected @endif>{{$ogf['outlet_group_name']}}</option>
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