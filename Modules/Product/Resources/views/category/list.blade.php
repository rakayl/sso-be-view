<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-nestable/jquery.nestable.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dd-handle:hover{
            background: #fafafa;
            color: #333;
            cursor: context-menu;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        var i = 1;
        $(document).ready(function() {
            $('[data-switch=true]').bootstrapSwitch();
            var obj = {!! $category !!};
            var output = '';
            var output_action = '';

            function buildItem(item) {

                var html = "<li class='dd-item' data-id='" + item.id_product_category + "' data-parent='"+item.id_parent+"'>";
                html += "<div class='dd-handle dd-nodrag'>" + item.product_category_name + "</div>";
                html += '<input type="hidden" name="position[]" value="'+item.id_product_category+'">';

                if (item.children) {

                    html += "<ol class='dd-list'>";
                    $.each(item.children, function (index, sub) {
                        html += buildItem(sub);
                    });
                    html += "</ol>";

                }
                html += "</li>";

                return html;
            }

            function buildItemAction(item) {

                var html = "<li style='margin:5px 10px;height:30px;list-style-type:none;'>";
                html += '<div class="row">' +
                    '<a href="{{ url("product/category/edit") }}/'+item.id_product_category+'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>' +
                    '<a onclick="deleteCategory(\'' + item.id_product_category + '\',\'' + item.product_category_name + '\')" class="btn btn-sm btn-danger sweetalert-delete" style="margin-left:0.5%"><i class="fa fa-trash"></i></a>' +
                    '<div>';

                if (item.children) {

                    $.each(item.children, function (index, sub) {
                        html += buildItemAction(sub);
                    });

                }
                html += "</li>";

                return html;
            }

            $.each(obj, function (index, item) {
                output += buildItem(item);
                output_action += buildItemAction(item);
            });

            $('#product_category').html(output);
            $('#product_category_action').html(output_action);
        });

        function deleteCategory(id_product_category, product_category_name) {
            swal({
                    title: "Are you sure want to delete category \n" + product_category_name + " ?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete!",
                    closeOnConfirm: false
                },
                function () {
                    var token  	= "{{ csrf_token() }}";
                    $.ajax({
                        type: "POST",
                        url: "{{ url('product/category/delete') }}/"+id_product_category,
                        data: "_token=" + token + "&id_product_category=" + id_product_category,
                        success: function (result) {
                            if (result.status == "success") {
                                swal({
                                    title: 'Success!',
                                    text: 'Deleted category.',
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                                location.reload();
                            } else {
                                swal("Error!", "Fail delete category, category already to use in transaction", "error")
                            }
                        }
                    });
                });
        }

        var array = new Map();
        function addChild(number) {
            var name = $('#product_category_name_'+number).val();
            if(name === ''){
                toastr.warning("Please input category name.");
            }else{
                var html = '<div id="div_parent_'+i+'">' +
                    '<div class="form-group">' +
                    '<label class="col-md-3 control-label">'+name+' <span class="text-danger">*</span></label>' +
                    '<div class="col-md-4">' +
                    '<input class="form-control" type="text" maxlength="200" id="product_category_name_'+i+'" name="data[child]['+i+'][product_category_name]" required placeholder="Enter category name"/>' +
                    '<input class="form-control" type="hidden" name="data[child]['+i+'][parent]" value="'+number+'"/>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<div class="fileinput fileinput-new" data-provides="fileinput">' +
                    '<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 40px; max-height: 40px;"> </div>' +
                    '<div>' +
                    '<span class="btn default btn-file">' +
                    '<span class="fileinput-new" style="font-size: 12px;"> Select Image </span>' +
                    '<span class="fileinput-exists"> <i class="fa fa-pencil"></i> </span>' +
                    '<input type="file" accept="image/png" name="data[child]['+i+'][product_category_image]" class="file" data-type="'+i+'"> </span>' +
                    '<a href="javascript:;" id="removeImage_'+i+'" class="btn red default fileinput-exists" data-dismiss="fileinput"> <i class="fa fa-trash"></i> </a>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-3">';

                var value = 1;
                if(!isNaN(array.get(name))){
                    value = parseInt(array.get(name))+1;
                }
                array.set(name, value);
                if((number != 0 && isNaN(array.get(name))) || number == 0 ){
                    html +='<a class="btn btn-primary btn" onclick="addChild('+i+')">&nbsp;<i class="fa fa-plus-circle"></i> Child </a>';
                }

                html += '<a class="btn btn-danger btn" style="margin-left: 2%" onclick="deleteForm('+i+')">&nbsp;Delete</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                $("#div_parent_"+number).append(html);
                $('[data-switch=true]').bootstrapSwitch();
                i++;
            }
        }

        function deleteForm(number) {
            $('#div_parent_'+number).empty();
            if(!isNaN(array.get('tmp_'+number))){
                var value = parseInt(array.get('tmp_'+number))-1;
                array.set('tmp_'+number, value);
            }
        }

        $(".file").change(function(e) {
            var type      = $(this).data('type');
            var widthImg  = 0;
            var heightImg = 0;
            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();
                var size = file.size/1024;

                image.onload = function() {
                    if (this.width !== this.height) {
                        toastr.warning("Please check dimension of your photo. Recommended dimensions are 1:1");
                        $("#removeImage_"+type).trigger( "click" );
                    }
                    if (this.width > 100 ||  this.height > 100) {
                        toastr.warning("Please check dimension of your photo. The maximum height and width 100px.");
                        $("#removeImage_"+type).trigger( "click" );
                    }
                    if (size > 10) {
                        toastr.warning("The maximum size is 10 KB");
                        $("#removeImage_"+type).trigger( "click" );
                    }
                };
                image.src = _URL.createObjectURL(file);
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

    @if(MyHelper::hasAccess([45], $grantedFeature))
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject sbold uppercase font-blue">New Category Level</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-warning deteksi-trigger">
                    <b><i class="fa fa-warning"></i> Upload Image : width/height maximum 100 px and maximum size is 10 KB.</b>
                </div>
                <form class="form-horizontal" role="form" id="form_create_table" action="{{url('product/category/create')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div id="div_parent_0">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Category Name Parent <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" maxlength="200" id="product_category_name_0" name="data[0][product_category_name]" required placeholder="Enter product category name"/>
                                </div>
                                <div class="col-md-2">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 40px; max-height: 40px;"> </div>
                                        <div>
                                            <span class="btn default btn-file">
                                            <span class="fileinput-new" style="font-size: 12px;"> Select Image </span>
                                            <span class="fileinput-exists"> <i class="fa fa-pencil"></i> </span>
                                            <input type="file" accept="image/png" name="data[0][product_category_image]" class="file" data-type="0"> </span>
                                            <a href="javascript:;" id="removeImage_0" class="btn red default fileinput-exists" data-dismiss="fileinput"> <i class="fa fa-trash"></i> </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="addChild(0)">&nbsp;<i class="fa fa-plus-circle"></i> Child </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Category List</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row">
                <div class="dd" id="nestable3">
                    <ol class='dd-list dd3-list'>
                        <div class="col-md-6">
                            <div id="product_category"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="product_category_action"></div>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection