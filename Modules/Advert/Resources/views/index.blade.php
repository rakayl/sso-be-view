@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script> -->
    <!-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/prices.js')}}"></script>
    <script>
      $( function() {
        $( ".sortable" ).sortable();
        $( ".sortable" ).disableSelection();
      });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            token = '<?php echo csrf_token();?>';

            $('.summernote').summernote({
                placeholder: 'Advert',
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
                            url: "{{url('summernote/picture/delete/advert')}}",
                            success: function(data){
                                // console.log(data);
                            }
                        });
                    }
                }
            });


            function sendFile(file, id){
                token = "<?php echo csrf_token(); ?>";
                var data = new FormData();
                data.append('image', file);
                data.append('_token', token);
                // document.getElementById('loadingDiv').style.display = "inline";
                $.ajax({
                    url : "{{url('summernote/picture/upload/advert')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
                            console.log(url);
                            $('#'+id).summernote('editor.saveRange');
							$('#'+id).summernote('editor.restoreRange');
							$('#'+id).summernote('editor.focus');
                            $('#'+id).summernote('insertImage', url['result']['pathinfo'], url['result']['filename']);
                        }
                        // document.getElementById('loadingDiv').style.display = "none";
                    },
                    error: function(data){
                        // document.getElementById('loadingDiv').style.display = "none";
                    }
                })
            }

            $(".file").change(function(e) {
                var _URL = window.URL || window.webkitURL;

                var image, file;

                if ((file = this.files[0])) {

                    image = new Image();

                    image.onload = function() {
                        // console.log(this.width);
                        // console.log(this.height);

                        if (this.width == 600 && this.height == 300) {
                            // image.src = _URL.createObjectURL(file);
                        }
                        else {
                            toastr.warning("Please check dimension of your photo.");
                            $(this).val("");
                            image.src = _URL.createObjectURL("");
                        }
                    };

                    image.src = _URL.createObjectURL(file);
                }

            });

            $(".delete").click(function() {
                var token = "{{ csrf_token() }}";
                var id    = $(this).data('id');
                var ortu  = $(this).parent().parent();

                $.ajax({
                    type : "POST",
                    url : "{{ url('advert-delete') }}",
                    data : "_token="+token+"&id_advert="+id,
                    success : function(result) {
                        if (result == "success") {
                            toastr.info("Advert has been deleted.");
                            ortu.remove();
                        }
                        else {
                            toastr.warning("Something went wrong. Failed to delete advert.");
                        }
                    }
                });
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
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-blue bold uppercase">Advertise</span>
            </div>
            <ul class="nav nav-tabs">
                <li class="active" id="infoOutlet">
                    <a href="#pictontop" data-toggle="tab" > Picture On Top </a>
                </li>
                <li id="infoOutlet">
                    <a href="#textontop" data-toggle="tab" > Text On Top </a>
                </li>
                <li id="infoOutlet">
                    <a href="#piconbottom" data-toggle="tab" > Picture On Bottom </a>
                </li>
                <li>
                    <a href="#textonbottom" data-toggle="tab"> Text On Bottom </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-2">

                </div>
                <div class="col-md-10">
                    <div class="tab-content">
                        <div class="tab-pane active" id="pictontop">
                            @include('advert::image_top')
                        </div>
                        <div class="tab-pane" id="textontop">
                            @include('advert::top')
                        </div>
                        <div class="tab-pane" id="piconbottom">
                            @include('advert::image_bottom')
                        </div>
                        <div class="tab-pane" id="textonbottom">
                            @include('advert::bottom')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection