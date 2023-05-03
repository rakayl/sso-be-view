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
        $(document).ready(function() {
            $('.select2').select2();
            $('[data-switch=true]').bootstrapSwitch();
            $('#btn-submit').on('click', function(event) {
                if(document.getElementById('auto_generate_pin').checked == false){
                    if($('#pin1').val() !== $('#pin2').val()) {
                        Swal.fire(
                            "Woops!",
                            'Password didn\'t match' ,
                            "error"
                        )
                        event.preventDefault();
                        event.stopPropagation();
                    }
                }


                const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(!re.test($('#input-email').val())){
                    Swal.fire(
                        "Woops!",
                        'Format email is not valid' ,
                        "error"
                    )
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        });

        function changeLevel(value){
            if(value == 'User Franchise'){
                $("#select_outlet").show();
            }else{
                $("#select_outlet").hide();
            }
        }

        function changeResetPin() {
            if(document.getElementById('reset_pin').checked){
                $("#div_password").hide();
                $('#pin1').prop('required', false);
                $('#pin2').prop('required', false);
            }else{
                $("#div_password").show();
                $('#pin1').prop('required', true);
                $('#pin2').prop('required', true);
            }
        }

        $('#input-username').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z0-9_-]*$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            if (regex.test(str) || e.which == 8) {
                return true;
            }

            e.preventDefault();
            return false;
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
                <span class="caption-subject sbold uppercase font-blue">User Mitra Detail</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{url('user/user-franchise/update')}}/{{$result['id_user_franchise']}}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-3">Username <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan username (unique)" data-container="body"></i></label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" id="input-username" name="username" value="{{$result['username']}}" placeholder="Enter username here"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-3">Email <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan email (tidak unique)" data-container="body"></i></label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="email" value="{{$result['email']}}" id="input-email" required placeholder="Enter email here"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-3">Name <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama" data-container="body"></i></label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" name="name" value="{{$result['name']}}" required placeholder="Enter name here"/>
                        </div>
                    </div>
                    <div class="form-group" id="select_outlet" @if($result['level'] == 'Super Admin') style="display: none" @endif>
                        <label for="example-search-input" class="control-label col-md-3">Assign to outlet <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih outlet yang akan diassign untuk akun yang akan dibuat" data-container="body"></i>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control select2" name="id_outlet" id="select-brand" required>
                                <option value="" selected disabled>Search Outlet</option>
                                @foreach($outlets as $val)
                                    <option value="{{$val['id_outlet']}}" @if($result['id_outlet'] == $val['id_outlet']) selected @endif>{{$val['outlet_code']}} - {{$val['outlet_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Status<span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih status user sebagai Active/Inactive" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <input data-switch="true" type="checkbox" name="user_franchise_status" data-on-text="Active" data-off-text="Inactive" {{$result['user_franchise_status'] ==  'Active' || empty($result['user_franchise_status'])? 'checked' : ''}}/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-md-3">Reset Password <span class="required" aria-required="true">*</span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Jika di centang maka password akan di reset otomatis oleh sistem" data-container="body"></i>
                        </label>
                        <div class="col-md-6">
                            <label class="mt-checkbox mt-checkbox-outline">
                                <input type="checkbox" name="reset_pin" id="reset_pin" class="same checkbox-product-price" onclick="changeResetPin()"/>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div id="div_password">
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-3">Password
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan password yang akan digunakan untuk login" data-container="body"></i>
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" maxlength="6" type="password" name="pin" id="pin1" placeholder="Enter password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="example-search-input" class="control-label col-md-3">Re-type Password
                                <i class="fa fa-question-circle tooltips" data-original-title="Ketik ulang password yang akan digunakan untuk login" data-container="body"></i>
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" maxlength="6" type="password" name="pin2" id="pin2"  placeholder="Re-type password"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="example-search-input" class="control-label col-md-3">Input Your Pin <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input class="form-control" type="password" maxlength="6" name="password_admin" required placeholder="Enter your pin here"/>
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