@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .zoom-in {
            cursor: zoom-in;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
    <script>
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
                    if (this.width > 200 ||  this.height > 200) {
                        toastr.warning("Please check dimension of your photo. The maximum height and width 200px.");
                        $("#removeImage_"+type).trigger( "click" );
                    }
                    if (size > 30) {
                        toastr.warning("The maximum size is 30 KB");
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
            <a href="/">Order</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Delivery Settings</span>
            <i class="fa fa-circle"></i>
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
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green bold uppercase">Delivery Upload Image</span>
        </div>
    </div>
    <div class="portlet-body">
        <form role="form" class="form-horizontal" action="{{url('transaction/setting/delivery-upload-image/save')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-md-3 control-label">Image Default <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-html="true" data-original-title="gambar default akan muncul ketika gambar logo pada delivery kosong" data-container="body"></i>
                    <div style="color: #e02222;font-size: 12px;margin-top: 4%;">
                        max dimension 200 x 200 <br>
                        max size 30 KB <br>
                    </div>
                </label>
                <div class="col-md-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 2%;">
                        <div class="fileinput-new thumbnail" style="width: 40px; height: 40px;">
                            @if(isset($default_image_delivery) && $default_image_delivery != "")
                                <img src="{{$default_image_delivery}}" id="preview_image_default" />
                            @endif
                        </div>

                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 40px; max-height: 40px;"> </div>
                        <div>
                        <span class="btn default btn-file">
                        <span class="fileinput-new" style="font-size: 12px"> Select image </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" accept="image/*" name="image_default" class="file" data-type="image_default" @if(empty($default_image_delivery)) required @endif> </span>
                            <a href="javascript:;" id="removeImage_image_default" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($delivery as $key => $value)
                <div class="form-group">
                    <label class="col-md-3 control-label">{{ucfirst($value['delivery_method'])}} - {{$value['delivery_name']}}
                        <div style="color: #e02222;font-size: 12px;margin-top: 4%;">
                            max dimension 200 x 200 <br>
                            max size 30 KB <br>
                        </div>
                    </label>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new" data-provides="fileinput" style="margin-top: 2%;">
                            <div class="fileinput-new thumbnail" style="width: 40px; height: 40px;">
                                @if(isset($value['logo']) && $value['logo'] != "")
                                    <img src="{{$value['logo'].'?='.time()}}" id="preview_{{$value['code']}}" />
                                @endif
                            </div>

                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 40px; max-height: 40px;"> </div>
                            <div>
                                <span class="btn default btn-file">
                                <span class="fileinput-new" style="font-size: 12px"> Select image </span>
                                <span class="fileinput-exists"> Change </span>
                                <input type="file" accept="image/*" name="images[{{$value['code']}}]" class="file" data-type="{{$value['code']}}"> </span>
                                <a href="javascript:;" id="removeImage_{{$value['code']}}" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="form-actions" style="margin-top: 5%">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-4"><button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button></div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
