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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
    .btn-toggle {
        margin: 0 4rem;
        padding: 0;
        position: relative;
        border: none;
        height: 1.5rem;
        width: 3rem;
        border-radius: 1.5rem;
        color: #6b7381;
        background: #bdc1c8;
    }
    .btn-toggle:focus,
    .btn-toggle.focus,
    .btn-toggle:focus.active,
    .btn-toggle.focus.active {
        outline: none;
    }
    .btn-toggle:before,
    .btn-toggle:after {
        line-height: 1.5rem;
        width: 4rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: absolute;
        bottom: 0;
        transition: opacity 0.25s;
    }
    .btn-toggle:before {
        content: "Not Allow";
        left: -4rem;
    }
    .btn-toggle:after {
        content: "Allow";
        right: -4rem;
        opacity: 0.5;
    }
    .btn-toggle > .handle {
        position: absolute;
        top: 0.1875rem;
        left: 0.1875rem;
        width: 1.125rem;
        height: 1.125rem;
        border-radius: 1.125rem;
        background: #fff;
        transition: left 0.25s;
    }
    .btn-toggle.active {
        transition: background-color 0.25s;
    }
    .btn-toggle.active > .handle {
        left: 1.6875rem;
        transition: left 0.25s;
    }
    .btn-toggle.active:before {
        opacity: 0.5;
    }
    .btn-toggle.active:after {
        opacity: 1;
    }
    .btn-toggle.btn-sm:before,
    .btn-toggle.btn-sm:after {
        line-height: -0.5rem;
        color: #fff;
        letter-spacing: 0.75px;
        left: 0.4125rem;
        width: 2.325rem;
    }
    .btn-toggle.btn-sm:before {
        text-align: right;
    }
    .btn-toggle.btn-sm:after {
        text-align: left;
        opacity: 0;
    }
    .btn-toggle.btn-sm.active:before {
        opacity: 0;
    }
    .btn-toggle.btn-sm.active:after {
        opacity: 1;
    }
    .btn-toggle.btn-xs:before,
    .btn-toggle.btn-xs:after {
        display: none;
    }
    .btn-toggle:before,
    .btn-toggle:after {
        color: #6b7381;
    }
    .btn-toggle.active {
        background-color: #29b5a8;
    }
    .btn-toggle.btn-lg {
        margin: 0 5rem;
        padding: 0;
        position: relative;
        border: none;
        height: 2.5rem;
        width: 5rem;
        border-radius: 2.5rem !important;
    }
    .btn-toggle.btn-lg:focus,
    .btn-toggle.btn-lg.focus,
    .btn-toggle.btn-lg:focus.active,
    .btn-toggle.btn-lg.focus.active {
        outline: none;
    }
    .btn-toggle.btn-lg:before,
    .btn-toggle.btn-lg:after {
        line-height: 2.5rem;
        width: 5rem;
        text-align: center;
        font-weight: 600;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: absolute;
        bottom: 0;
        transition: opacity 0.25s;
    }
    .btn-toggle.btn-lg:before {
        content: "Inactive";
        left: -7rem;
    }
    .btn-toggle.btn-lg:after {
        content: "Active";
        right: -6rem;
        opacity: 0.5;
    }
    .btn-toggle.btn-lg > .handle {
        position: absolute;
        top: 0.3125rem;
        left: 0.3125rem;
        width: 1.875rem;
        height: 1.875rem;
        border-radius: 1.875rem !important;
        background: #fff;
        transition: left 0.25s;
    }
    .btn-toggle.btn-lg.active {
        transition: background-color 0.25s;
    }
    .btn-toggle.btn-lg.active > .handle {
        left: 2.8125rem;
        transition: left 0.25s;
    }
    .btn-toggle.btn-lg.active:before {
        opacity: 0.5;
    }
    .btn-toggle.btn-lg.active:after {
        opacity: 1;
    }
    .btn-toggle.btn-lg.btn-sm:before,
    .btn-toggle.btn-lg.btn-sm:after {
        line-height: 0.5rem;
        color: #fff;
        letter-spacing: 0.75px;
        left: 0.6875rem;
        width: 3.875rem;
    }
    .btn-toggle.btn-lg.btn-sm:before {
        text-align: right;
    }
    .btn-toggle.btn-lg.btn-sm:after {
        text-align: left;
        opacity: 0;
    }
    .btn-toggle.btn-lg.btn-sm.active:before {
        opacity: 0;
    }
    .btn-toggle.btn-lg.btn-sm.active:after {
        opacity: 1;
    }
    .btn-toggle.btn-lg.btn-xs:before,
    .btn-toggle.btn-lg.btn-xs:after {
        display: none;
    }
    .btn-toggle.btn-sm {
        margin: 0 0.5rem;
        padding: 0;
        position: relative;
        border: none;
        height: 1.5rem;
        width: 3rem;
        border-radius: 1.5rem;
    }
    .btn-toggle.btn-sm:focus,
    .btn-toggle.btn-sm.focus,
    .btn-toggle.btn-sm:focus.active,
    .btn-toggle.btn-sm.focus.active {
        outline: none;
    }
    .btn-toggle.btn-sm:before,
    .btn-toggle.btn-sm:after {
        line-height: 1.5rem;
        width: 0.5rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.55rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: absolute;
        bottom: 0;
        transition: opacity 0.25s;
    }
    .btn-toggle.btn-sm:before {
        content: "Off";
        left: -0.5rem;
    }
    .btn-toggle.btn-sm:after {
        content: "On";
        right: -0.5rem;
        opacity: 0.5;
    }
    .btn-toggle.btn-sm > .handle {
        position: absolute;
        top: 0.1875rem;
        left: 0.1875rem;
        width: 1.125rem;
        height: 1.125rem;
        border-radius: 1.125rem;
        background: #fff;
        transition: left 0.25s;
    }
    .btn-toggle.btn-sm.active {
        transition: background-color 0.25s;
    }
    .btn-toggle.btn-sm.active > .handle {
        left: 1.6875rem;
        transition: left 0.25s;
    }
    .btn-toggle.btn-sm.active:before {
        opacity: 0.5;
    }
    .btn-toggle.btn-sm.active:after {
        opacity: 1;
    }
    .btn-toggle.btn-sm.btn-sm:before,
    .btn-toggle.btn-sm.btn-sm:after {
        line-height: -0.5rem;
        color: #fff;
        letter-spacing: 0.75px;
        left: 0.4125rem;
        width: 2.325rem;
    }
    .btn-toggle.btn-sm.btn-sm:before {
        text-align: right;
    }
    .btn-toggle.btn-sm.btn-sm:after {
        text-align: left;
        opacity: 0;
    }
    .btn-toggle.btn-sm.btn-sm.active:before {
        opacity: 0;
    }
    .btn-toggle.btn-sm.btn-sm.active:after {
        opacity: 1;
    }
    .btn-toggle.btn-sm.btn-xs:before,
    .btn-toggle.btn-sm.btn-xs:after {
        display: none;
    }
    .btn-toggle.btn-xs {
        margin: 0 0;
        padding: 0;
        position: relative;
        border: none;
        height: 1rem;
        width: 2rem;
        border-radius: 1rem;
    }
    .btn-toggle.btn-xs:focus,
    .btn-toggle.btn-xs.focus,
    .btn-toggle.btn-xs:focus.active,
    .btn-toggle.btn-xs.focus.active {
        outline: none;
    }
    .btn-toggle.btn-xs:before,
    .btn-toggle.btn-xs:after {
        line-height: 1rem;
        width: 0;
        text-align: center;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: absolute;
        bottom: 0;
        transition: opacity 0.25s;
    }
    .btn-toggle.btn-xs:before {
        content: "Off";
        left: 0;
    }
    .btn-toggle.btn-xs:after {
        content: "On";
        right: 0;
        opacity: 0.5;
    }
    .btn-toggle.btn-xs > .handle {
        position: absolute;
        top: 0.125rem;
        left: 0.125rem;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 0.75rem;
        background: #fff;
        transition: left 0.25s;
    }
    .btn-toggle.btn-xs.active {
        transition: background-color 0.25s;
    }
    .btn-toggle.btn-xs.active > .handle {
        left: 1.125rem;
        transition: left 0.25s;
    }
    .btn-toggle.btn-xs.active:before {
        opacity: 0.5;
    }
    .btn-toggle.btn-xs.active:after {
        opacity: 1;
    }
    .btn-toggle.btn-xs.btn-sm:before,
    .btn-toggle.btn-xs.btn-sm:after {
        line-height: -1rem;
        color: #fff;
        letter-spacing: 0.75px;
        left: 0.275rem;
        width: 1.55rem;
    }
    .btn-toggle.btn-xs.btn-sm:before {
        text-align: right;
    }
    .btn-toggle.btn-xs.btn-sm:after {
        text-align: left;
        opacity: 0;
    }
    .btn-toggle.btn-xs.btn-sm.active:before {
        opacity: 0;
    }
    .btn-toggle.btn-xs.btn-sm.active:after {
        opacity: 1;
    }
    .btn-toggle.btn-xs.btn-xs:before,
    .btn-toggle.btn-xs.btn-xs:after {
        display: none;
    }
    .btn-toggle.btn-secondary {
        color: #6b7381;
        background: #bdc1c8;
    }
    .btn-toggle.btn-secondary:before,
    .btn-toggle.btn-secondary:after {
        color: #6b7381;
    }
    .btn-toggle.btn-secondary.active {
        background-color: #ff8300;
    }
    </style>

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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>
    <script>
    $( document ).ready(function() {
        Dropzone.options.myDropzone = {
            maxFilesize: 12,
            acceptedFiles: "image/*",
            parallelUploads: 1,
            init: function () {
                this.on("thumbnail", function(file) {
                    if (file.width == 720 || file.height == 360) {
                        file.acceptDimensions();
                    }
                    else {
                        file.rejectDimensions();
                        this.removeFile(file)
                    }
                });
            },
            accept: function(file, done) {
                filename = file.name.split('.')
                file.acceptDimensions = done;
                file.rejectDimensions = function() { 
                    toastr.warning("Please check dimension of your photo dimension " + filename[0])
                };
            },
            success: function(file, response) 
            {
                console.log(response)
                if (response.status == 'success') {
                    filename = file.name.split('.')
                    $("#"+filename[0]).replaceWith('<td id="'+filename[0]+'"><img style="width: 150px; height: 75px;" src="'+response.result.url_product_photo+'" alt=""></td>');
                    toastr.success("Photo has been updated.")
                } else {
                    toastr.warning("Make sure name file same as Product Code.")
                    this.removeFile(file)
                }
            },
            error: function(file, response)
            {
                toastr.warning("Make sure you have right access.")
                this.removeFile(file)
            }
        };

        $.ajax({
            type : "GET",
            url : "{{ url('product/image/override') }}",
            data : {
                _token : "{{ csrf_token() }}"
            },
            success : function(result) {
                if (result.status == "success") {
                    if(result.result == 'true'){
                        $('#checkbox1').prop('checked', true);
                    } else {
                        $('#checkbox1').prop('checked', false);
                    }
                }
            }
        });
    });
    
    $('#checkbox1').on('click', function(e){
        var state = null;
        if($(this).is(":checked")){
            state = false
        } else {
            state = true
        }
        $.ajax({
            type : "POST",
            url : "{{ url('product/image/override') }}",
            data : {
                _token : "{{ csrf_token() }}",
                state : state,
            },
            success : function(result) {
                if (result.status == "success") {
                    toastr.info("Override status has been updated.");
                    if(result.result == 1){
                        $('#checkbox1').prop('checked', true);
                    } else {
                        $('#checkbox1').prop('checked', false);
                    }
                }
                else {
                    toastr.warning("Failed Update Override");
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

    @php
        $url = explode('/', url()->current());
    @endphp
    @if (end($url) == 'detail')
        
        <div class="portlet light bordered">
            <div class="row">
                <div class="col-md-12">
                    <div class="m-heading-1 border-green m-bordered">
                        <h4>Dropzone Product Image</h4>
                        <p> Untuk melakukan perubahan image detail pada product, anda hanya perlu melakukan drop image yang ingin di ganti atau di tambahkan </p>
                        <p>
                            <span class="label label-warning">NOTE:</span> &nbsp; Pastikan nama file sesuai dengan product code. Jika product code PR-001, maka nama file gambar PR-001.jpg dan pastikan ukuran gambar 720px X 360px. </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="m-heading-1 border-green m-bordered">
                        <h4>Override Product Image</h4>
                        <p> Ovveride diaktifkan agar data gambar sebelumnya tidak menjadi sampah di dalam storage </p>
                        <p>
                            <br>
                        <div class="md-checkbox">
                            <input type="checkbox" id="checkbox1" name="yearly" class="md-checkboxbtn" >
                            <label for="checkbox1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Override Image </label>
                            </label>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-12">
                    <form action="{{ url()->current() }}" method="POST" class="dropzone dropzone-file-area dz-clickable" id="my-dropzone" style="width: 600px; margin-top: 50px;">
                        {{ csrf_field() }}
                        <h3 class="sbold">Drop files here or click to upload</h3>
                        <p> Image Pixel 720 X 360. </p>
                    <div class="dz-default dz-message"><span></span></div></form>
                </div>
            </div>
        </div>
    @endif

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">List Product Detail Image</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                <thead>
                    <tr>
                        <th> No </th>
                        <th> Code </th>
                        <th> Name </th>
                        <th> Image </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($product))
                        @foreach($product as $key => $value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value['product_code'] }}</td>
                                <td>{{ $value['product_name'] }}</td>
                                @if (empty($value['product_photo_detail']))
                                    <td id="{{$value['product_code']}}">No Image</td>
                                @else
                                    <td id="{{$value['product_code']}}"><img style="width: 150px;height:75px" src="{{ env('STORAGE_URL_API') }}{{$value['product_photo_detail'] }}" alt=""></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>



@endsection