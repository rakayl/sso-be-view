@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Brand Description',
            tabsize: 2,
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
            height: 120
        });
        $(".file").change(function(e) {
            var type      = $(this).data('jenis');
            var widthImg  = 0;
            var heightImg = 0;
            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (type == "logo_brand") {
                        if ($(".file").val().split('.').pop().toLowerCase() != 'png') {
                            toastr.warning("Please check type of your photo.");
                            $("#removeLogo").trigger( "click" );
                        }
                        if (this.width != 200 || this.height != 200) {
                            toastr.warning("Please check dimension of your photo.");
                            $("#removeLogo").trigger( "click" );
                        }
                    }
                    if (type == "image_brand") {
                        if (this.width != 750 || this.height != 375) {
                            toastr.warning("Please check dimension of your photo.");
                            $("#removeImage").trigger( "click" );
                        }
                    }
                };
                image.src = _URL.createObjectURL(file);
            }
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
                <span class="caption-subject font-dark sbold uppercase font-blue">{{$title}}</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('brand/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">Default Brand
                            <i class="fa fa-question-circle tooltips" data-original-title="Default brand pada produk" data-container="body"></i>
                        </label>
                        <div class="col-md-8" style="margin-top: 0.7%">
                            <div class="icheck-list">
                                <input type="checkbox" class="icheck" name="default_brand_status" @if(!empty($result['default_brand_status'])) checked @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Name
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Nama Brand" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Brand Name" class="form-control" name="name_brand" @if (isset($result['name_brand'])) value="{{ $result['name_brand'] }}" @else value="{{ old('name_brand') }}" @endif required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Brand Status
                            <i class="fa fa-question-circle tooltips" data-original-title="Status brand. Active/inactive" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="Active" data-off-color="default" data-off-text="Inactive" name="brand_active" value="1" @if(old('brand_active',$result['brand_active']??'')) checked @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Brand Visibility
                            <i class="fa fa-question-circle tooltips" data-original-title="Status brand. Visible/Hidden" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="Visible" data-off-color="default" data-off-text="Hidden" name="brand_visibility" value="1" @if(old('brand_visibility',$result['brand_visibility']??'')) checked @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Code
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Kode Brand (Unique)" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Brand Code" class="form-control" name="code_brand" @if (isset($result['code_brand'])) value="{{ $result['code_brand'] }}" disabled @else value="{{ old('code_brand') }}" required @endif>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Logo
                            <span class="required" aria-required="true"> * </span>
                            <br>
                            <span class="required" aria-required="true"> (200*200)</span>
                            <br>
                            <span class="required" aria-required="true"> (Only PNG) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran square digunakan utnuk menjadi logo brand" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                    @if(isset($result['logo_brand']) && $result['logo_brand'] != "")
                                        <img src="{{$result['logo_brand']}}" id="preview_logo_brand" />
                                    @else
                                        <img id="preview_logo_brand" src="https://www.placehold.it/500x500/EFEFEF/AAAAAA"/>
                                    @endif
                                </div>

                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/png" name="logo_brand" class="file" data-jenis="logo_brand" @if(empty($result['logo_brand'])) required @endif> </span>
                                    <a href="javascript:;" id="removeLogo" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label class="col-md-3 control-label">
                            Image
                            <span class="required" aria-required="true"> * </span>
                            <br>
                            <span class="required" aria-required="true"> (750 * 375) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran square digunakan utnuk menjadi logo brand" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                                    @if(isset($result['image_brand']) && $result['image_brand'] != "")
                                        <img src="{{$result['image_brand']}}" id="preview_image_brand" />
                                    @else
                                        <img id="preview_image_brand" src="https://www.placehold.it/750x375/EFEFEF/AAAAAA"/>
                                    @endif
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/*" name="image_brand" class="file" data-jenis="image_brand" @if (!isset($result['name_brand'])) required @endif> </span>
                                    <a href="javascript:;" id="removeImage" class="btn red default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if(isset($result['id_brand']) && $result['id_brand'] != "") <input hidden name="id_brand" value="{{$result['id_brand']}}" src="{{$result['id_brand']}}"> @endif
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection