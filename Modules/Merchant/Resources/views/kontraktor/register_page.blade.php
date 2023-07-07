@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Description',
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['insert', ['link']],
                    ['misc', ['fullscreen', 'codeview', 'help']], ['height', ['height']]
                ],
                height: 120,
                callbacks: {
                    onKeyup: function (e) {
                        removeValidation();
                    }
                }
            });
        });

        $(".file").change(function(e) {
            var widthImg  = $('#width').val();
            var heightImg = $('#height').val();
            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width != widthImg ||  this.height != heightImg) {
                        toastr.warning("Please check dimension of your photo.");
                        $("#removeImage").trigger( "click" );
                    }
                };
                image.src = _URL.createObjectURL(file);
            }
        });

        function removeValidation(){
            $('#validation').remove();
        }

        $('#myForm').on('submit', function(e) {

            if($('#description').summernote('isEmpty')) {
                $('#validation').remove();
                $('#description').parent().append('<p id="validation" style="color: red;margin-top: -2%">Description can not be empty.</p>');
                e.preventDefault();
                $('#description').focus();
                focusSet = true;
            }
        })
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

    <div class="tab-pane" id="user-profile">
        <div class="row" style="margin-top:20px">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-blue ">
                            <i class="icon-settings font-blue "></i>
                            <span class="caption-subject bold uppercase">Setting Register {{ucfirst($status)}}</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form role="form" id="myForm" class="form-horizontal" action="{{url()->current()}}" method="POST" enctype="multipart/form-data">
                            @if($status == 'introduction')
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Image<span class="required" aria-required="true">* <br>(720*360) </span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                                                <img src="@if(isset($result['image'])){{$result['image']}}@endif" alt="">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 100px;"></div>
                                            <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/*" class="file" name="image" @if(empty($result['image'])) required @endif>
                                        </span>
                                                <a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="width" value="720">
                                <input type="hidden" id="height" value="360">
                            @else
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Image<span class="required" aria-required="true">* <br>(500*500) </span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                <img src="@if(isset($result['image'])){{$result['image']}}@endif" alt="">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                            <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" accept="image/*" class="file" name="image" @if(empty($result['image'])) required @endif>
                                        </span>
                                                <a href="javascript:;" id="removeImage" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="width" value="500">
                                <input type="hidden" id="height" value="500">
                            @endif

                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Title
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" name="title" value="{{$result['title']??''}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Description
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-8">
                                    <textarea title="Your Favourite Subject may be JavaScript..." class="form-control summernote" id="description" name="description" required>{{$result['description']??''}}</textarea>
                                </div>
                            </div>
                            @if($status != 'rejected')
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    Button Text
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input class="form-control" name="button_text" value="{{$result['button_text']??''}}" required>
                                </div>
                            </div>
                            @endif
                            <br>
                            <br>
                            <div class="form-actions" style="text-align:center">
                                {{ csrf_field() }}
                                <button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection