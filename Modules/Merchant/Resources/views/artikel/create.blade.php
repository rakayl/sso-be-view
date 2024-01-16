@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
	
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/global.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        $(".file-splash").change(function(e) {
                var widthImg  = 1080;
		var heightImg = 1920;
                var widthImg2  = 540;
		var heightImg2 = 960;
		var _URL = window.URL || window.webkitURL;
		var image, file;

		if ((file = this.files[0])) {
			image = new Image();

			image.src = _URL.createObjectURL(file);
		}

	});
       
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          
          $('.summernote').summernote({
        placeholder: 'Setting',
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
        callbacks: {
            onImageUpload: function(files){
                sendFile(files[0], $(this).attr('id'));
            },
            onMediaDelete: function(target){
                var name = target[0].src;
                token = "<?php echo csrf_token(); ?>";
                $.ajax({
                    type: 'post',
                    data: 'filename='+name+'&_token='+token,
                    url: "{{url('summernote/picture/delete/setting')}}",
                    success: function(data){
                        // console.log(data);
                    }
                });
            }
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
                <span class="caption-subject font-blue sbold uppercase">New Artikel</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('artikel/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Title
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan title artikel" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="title" required placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Category
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan title category" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="category" required placeholder="Category">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Image
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Foto artikel" data-container="body"></i>
                            </label>
                        </div>
                        <div class="fileinput fileinput-new col-md-8" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-new thumbnail">
                                       <img src="https://www.placehold.it/200x100/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="div_splash" style="max-width: 250px; max-height: 250px;"></div>
                                <div>
                                        <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" class="file-splash" id="field_splash" accept="image/*" name="image">
                                        </span>
                                        <a href="javascript:;" id="removeSplash" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Category
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan title category" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea class="form-control summernote" id="id_text" name="content"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
