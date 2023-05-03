<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');

?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('.price').inputmask("numeric", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 0,
            autoGroup: true,
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });

        $('#checkbox-variant').on('ifChanged', function(event) {
            if(this.checked) {
                $('#nav-prod-variant').show();
                $("input[name=product_global_price]").val('');
                $("input[name=product_global_price]").prop('disabled', true);
                $('input[name=product_global_price]').prop('required',false);
            }else{
                $('#nav-prod-variant').hide();
                $("input[name=product_global_price]").val($("#old_global_price").val());
                $("input[name=product_global_price]").prop('disabled', false);
                $('input[name=product_global_price]').prop('required',true);
            }
        });

        $('#select2-product-variant').change(function(e) {
            var selected = $(e.target).val();
            if(selected !== null){
                var last = selected[selected.length-1];
                var cek = 0;
                for(var i=0;i<selected.length;i++){
                    var split = selected[i].split("|");
                    var split2 = last.split("|");

                    if(split[0] === split2[1]){
                        cek = 1;
                        selected.splice(i, 1);
                    }
                }
                if(cek === 1){
                    $("#select2-product-variant").val(selected).trigger('change');
                }
            }
        });

        var row = "{{$count}}";
        function addProductVariantGroup() {
            var product_variant = $('#select2-product-variant').val();
            var product_variant_price = $('#product-variant-group-price').val();
            var product_variant_group_code = $('#product-variant-group-code').val();
            var product_variant_group_id = $('#product-variant-group-id').val();
            var text = $('#select2-product-variant option:selected').toArray().map(item => item.text).join();
            var visibility = $('input[name="product_variant_group_visibility"]:checked').val();
            var msg_error = '';

            if(product_variant.length <= 0){
                msg_error += '-Please select one or more product variant <br>';
            }

            var check_level = '';
            var id = [];
            for(var i=0;i<product_variant.length;i++){
                var split = product_variant[i].split("|");
                id.push(split[0]);
                if(check_level == split[1]){
                    msg_error += '-Can not select same level in product variant group<br>';
                }
                check_level = split[1];
            }

            var checkSameCombination = 0;
            $('#table-product-variant > tbody  > tr').each(function(index, tr) {
                if($('#product-variant-'+index).val()){
                    var arrProdVariantFromTable = $('#product-variant-'+index).val().split(",");
                    var flag = 0;
                    for(var i=0;i<arrProdVariantFromTable.length;i++){
                        if(id.indexOf(arrProdVariantFromTable[i]) >= 0){
                            flag++;
                        }
                    }
                    if(flag > 1){
                        checkSameCombination = 1;
                    }
                }
            });

            if(checkSameCombination === 1){
                msg_error += '-Combination "'+text+'" already exist<br>';
            }

            if(product_variant_group_code === ''){
                msg_error += '-Please input code <br>';
            }

            if(product_variant_price === ''){
                msg_error += '-Please input price <br>';
            }

            if(msg_error !== ""){
                toastr.warning(msg_error);
            }else{
                var html = '';
                html += '<tr>';
                html += '<td>'+text+'</td>';
                html += '<td>'+product_variant_group_code+'</td>';
                html += '<td>'+product_variant_price+'</td>';
                html += '<td>'+visibility+'</td>';
                if(product_variant_group_id){
                    html += '<td><a  onclick="deleteRowProductVariant(this,'+product_variant_group_id+')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>' +
                        '<a  onclick="editRowProductVariant(this,'+row+')" data-toggle="confirmation" class="btn btn-sm btn-primary" style="margin-left: 2%"><i class="fa fa-pen"></i> Edit</a></td>';
                }else{
                    html += '<td><a  onclick="deleteRowProductVariant(this)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>' +
                        '<a  onclick="editRowProductVariant(this,'+row+')" data-toggle="confirmation" class="btn btn-sm btn-primary" style="margin-left: 2%"><i class="fa fa-pen"></i> Edit</a></td>';
                }

                html += '<input type="hidden" id="product-variant-'+row+'" name="data['+row+'][id]" value="'+id+'">';
                html += '<input type="hidden" id="product-variant-edit-'+row+'" name="data['+row+'][id-edit]" value="'+product_variant+'">';
                html += '<input type="hidden" id="product-variant-group-code-'+row+'" name="data['+row+'][code]" value="'+product_variant_group_code+'">';
                html += '<input type="hidden" id="product-variant-price-'+row+'" name="data['+row+'][price]" value="'+product_variant_price+'">';
                html += '<input type="hidden" id="product-variant-group-id-'+row+'" name="data['+row+'][group_id]" value="'+product_variant_group_id+'">';
                html += '<input type="hidden" id="product-variant-group-visibility-'+row+'" name="data['+row+'][visibility]" value="'+visibility+'">';
                html += '</tr>';

                $("#select2-product-variant").val(null).trigger('change');
                $('#product-variant-group-price').val('');
                $('#product-variant-group-code').val('');
                $('#product-variant-group-id').val('');

                $( "#product-variant-group-body" ).append(html);
                row++;

                var arr_tmp = [];
                $("#table-product-variant > tbody > tr").each(function(index, tr) {
                    var price = document.getElementById("table-product-variant").rows[index+1].cells[1].innerHTML;
                    arr_tmp.push(price);
                });

                var min_price = Math.min.apply(Math,arr_tmp);
                $('#product_base_price_pvg').val(min_price);
            }
        }

        function deleteRowProductVariant(content, id = null) {
            if(confirm('Are you sure you want to delete this product variant group?')) {

                if(id !== null){
                    var token  = "{{ csrf_token() }}";
                    $.ajax({
                        type : "POST",
                        url : "{{ url('product/product-variant-group/delete') }}",
                        data : "_token="+token+"&id_product_variant_group="+id,
                        success : function(result) {
                            if (result.status == "success") {
                                $(content).parent().parent('tr').remove();
                                toastr.info("Successfully delete the product variant group");
                            }
                            else {
                                toastr.warning("Something went wrong. Failed to delete product variant group.");
                            }
                        }
                    });
                }else{
                    $(content).parent().parent('tr').remove();
                    toastr.info("Successfully delete the product variant");
                }
            }
        }

        function editRowProductVariant(content,id) {
            var product_variant = $('#select2-product-variant').val();
            var product_variant_price = $('#product-variant-group-price').val();
            var product_variant_group_code = $('#product-variant-group-code').val();

            if(product_variant !== null || product_variant_price !== "" || product_variant_group_code !== ""){
                toastr.warning("Please complete your edit process");
            }else{
                var data_id = $('#product-variant-edit-'+id).val().split(',');
                var data_price = $('#product-variant-price-'+id).val();
                var group_id = $('#product-variant-group-id-'+id).val();
                var code = $('#product-variant-group-code-'+id).val();
                var visibility = $('#product-variant-group-visibility-'+id).val();

                if(visibility == 'Visible'){
                    document.getElementById("radio-variant-visibility1").checked = true;
                    document.getElementById("radio-variant-visibility2").checked = false;
                }else{
                    document.getElementById("radio-variant-visibility1").checked = false;
                    document.getElementById("radio-variant-visibility2").checked = true;
                }

                $("#select2-product-variant").val(data_id).trigger('change');
                $('#product-variant-group-price').val(data_price);
                $('#product-variant-group-id').val(group_id);
                $('#product-variant-group-code').val(code);
                $(content).parent().parent('tr').remove();
            }
        }

        function submitProductVariant() {
            var product_variant = $('#select2-product-variant').val();
            var product_variant_price = $('#product-variant-group-price').val();
            var product_variant_group_code = $('#product-variant-group-code').val();

            if(product_variant !== null || product_variant_price !== "" || product_variant_group_code !== ""){
                toastr.warning("Please complete your edit process");
            }else{
                var tbody = $("#table-product-variant tbody");

                if (tbody.children().length == 0) {
                    toastr.warning("Please add 1 or more product variant group.");
                }else{
                    $( "#form_product_variant_group" ).submit();
                }
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

    <a href="{{url('product-variant-group/list')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Product Variant ({{$product_code}} - {{$products[0]['product_name']}})</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" id="form_product_variant_group" action="{{url('product-variant-group/edit/'.$product_code)}}" method="POST">
                {{ csrf_field() }}
                <div class="form-body">
                    <div class="form-group">
                        <label  class="col-md-3 control-label">Product Variant <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <select class="form-control select2" id="select2-product-variant" multiple="multiple" style="width: 100%">
                                <?php
                                $declaration = [];
                                foreach($product_variant as $key=>$val){
                                    if(!empty($val['product_variant_parent'])){
                                        $declaration[$val['product_variant_parent']['product_variant_name']][] = [
                                            'id_parent' => $val['id_parent'],
                                            'id_product_variant' => $val['id_product_variant'],
                                            'product_variant_name' => $val['product_variant_name']
                                        ];
                                    }
                                }
                                ?>
                                @foreach($declaration as $key=>$val)
                                    <optgroup label="{{$key}}">
                                        @foreach($val as $child)
                                            <option value="{{$child['id_product_variant']}}|{{$child['id_parent']}}">{{$child['product_variant_name']}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-md-3 control-label">Code <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input class="form-control" id="product-variant-group-code" placeholder="Product Variant Group Code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-md-3 control-label">Price <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input class="form-control price" maxlength="11" id="product-variant-group-price" placeholder="Price Product Variant Group">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Visible <span class="text-danger">*</span>
                        </label>
                        <div class="input-icon right">
                            <div class="col-md-2">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio-variant-visibility1" name="product_variant_group_visibility" class="md-radiobtn req-type" value="Visible" checked>
                                        <label for="radio-variant-visibility1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Visible</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio-variant-visibility2" name="product_variant_group_visibility" class="md-radiobtn req-type" value="Hidden">
                                        <label for="radio-variant-visibility2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Hidden </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="product-variant-group-id" value="">
                    <input type="hidden" id="product-variant-group-code" name="product_variant_group_code" value="">
                    <input type="hidden" id="product-variant-group-visibility" name="product_variant_group_visibility" value="">
                    <input type="hidden" id="product_base_price_pvg" name="product_base_price_pvg" value="">

                    <div class="form-group row">
                        <label  class="col-md-3 col-form-label"></label>
                        <div class="col-md-4">
                            <a onclick="addProductVariantGroup()" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add Product Variant Group</a>
                        </div>
                    </div>
                    <div style="margin-top: 5%">
                        <table class="table table-bordered table-hover" style="width: 70%" id="table-product-variant">
                            <thead>
                            <th>Product Variant</th>
                            <th>Code</th>
                            <th>Price</th>
                            <th>Visibility</th>
                            <th>Action</th>
                            </thead>
                            <tbody id="product-variant-group-body">
                            @foreach($product_variant_group as $key=>$val)
                                <tr>
                                    <td>
                                        <?php
                                        $arr = array_column($val['product_variant_pivot'], 'product_variant_name');
                                        $name = implode(',',$arr);
                                        echo $name;
                                        ?>
                                    </td>
                                    <td>{{$val['product_variant_group_code']}}</td>
                                    <td>{{number_format($val['product_variant_group_price'],0,",",".")}}</td>
                                    <td>{{$val['product_variant_group_visibility']}}</td>
                                    <td>
                                        <a  onclick="deleteRowProductVariant(this, {{$val['id_product_variant_group']}})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                        <a  onclick="editRowProductVariant(this,{{$key}})" class="btn btn-sm btn-primary" style="margin-left: 2%"><i class="fa fa-pen"></i> Edit</a>
                                    </td>
                                    <?php
                                    $tmp = [];
                                    foreach ($val['product_variant_pivot'] as $p){
                                        $tmp[] = $p['id_product_variant'].'|'.$p['id_parent'];
                                    }
                                    $id_edit = implode(',',$tmp);
                                    $arr_id = array_column($val['product_variant_pivot'], 'id_product_variant');
                                    $id = implode(',',$arr_id);
                                    ?>
                                    <input type="hidden" id="product-variant-{{$key}}" name="data[{{$key}}][id]" value="{{$id}}">
                                    <input type="hidden" id="product-variant-edit-{{$key}}" name="data[{{$key}}][id-edit]" value="{{$id_edit}}">
                                    <input type="hidden" id="product-variant-group-code-{{$key}}" name="data[{{$key}}][code]" value="{{$val['product_variant_group_code']}}">
                                    <input type="hidden" id="product-variant-price-{{$key}}" name="data[{{$key}}][price]" value="{{(int)$val['product_variant_group_price']}}">
                                    <input type="hidden" id="product-variant-group-visibility-{{$key}}" name="data[{{$key}}][visibility]" value="{{$val['product_variant_group_visibility']}}">
                                    <input type="hidden" id="product-variant-group-id-{{$key}}" name="data[{{$key}}][group_id]" value="{{$val['id_product_variant_group']}}">
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-9">
                        <button onclick="submitProductVariant()" class="btn btn-success mr-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection