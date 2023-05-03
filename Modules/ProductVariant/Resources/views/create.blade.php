@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>

    <script>
        var i = 1;
        $(document).ready(function() {
            // library initialization
            $('[data-switch=true]').bootstrapSwitch();
        });

        function addChild(number) {
            var name = $('#product_variant_name_'+number).val();
            if(name === ''){
                toastr.warning("Please input variant name.");
            }else{
                var html = '<div id="div_parent_'+i+'">' +
                    '<div class="form-group">' +
                    '<label class="col-md-2 control-label">'+name+' <span class="text-danger">*</span></label>' +
                    '<div class="col-md-4">' +
                    '<input class="form-control" type="text" maxlength="200" id="product_variant_name_'+i+'" name="data[child]['+i+'][product_variant_name]" required placeholder="Enter variant name"/>' +
                    '<input class="form-control" type="hidden" name="data[child]['+i+'][parent]" value="'+number+'"/>' +
                    '</div>' +
                    '<div class="col-md-3">' +
                    '<input data-switch="true" type="checkbox" name="data[child]['+i+'][product_variant_visibility]" data-on-text="Visible" data-off-text="Hidden" checked/>' +
                    '</div>' +
                    '<div class="col-md-3" style="margin-left: -4%">' +
                    '<a class="btn btn-primary btn" onclick="addChild('+i+')">&nbsp;<i class="fa fa-plus-circle"></i> Child </a>' +
                    '<a class="btn btn-danger btn" style="margin-left: 2%" onclick="deleteForm('+i+')">&nbsp;<i class="fa fa-trash"></i></a>' +
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
                <span class="caption-subject sbold uppercase font-blue">New Variant</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" id="form_create_table" action="{{url('product-variant/store')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-body">
                    <div id="div_parent_0">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Variant Name Parent <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" maxlength="200" id="product_variant_name_0" name="data[0][product_variant_name]" required placeholder="Enter variant name"/>
                            </div>
                            <div class="col-md-3">
                                <input data-switch="true" type="checkbox" name="data[0][product_variant_visibility]" data-on-text="Visible" data-off-text="Hidden" checked/>
                            </div>
                            <div class="col-md-3" style="margin-left: -4%;">
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
@endsection