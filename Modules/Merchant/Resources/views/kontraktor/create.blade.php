@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
        $('.onlynumber').keypress(function (e) {
            var regex = new RegExp("^[0-9]");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if(check_browser == -1){
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            }else{
                if (regex.test(str) || e.which == 8 ||  e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
                    return true;
                }
            }

            e.preventDefault();
            return false;
        });

        $('#province').change(function() {
            $('#city').empty();
            $('#city').prop('disabled', true);
            $('#district').empty();
            $('#district').prop('disabled', true);
            $('#subdistrict').empty();
            $('#subdistrict').prop('disabled', true);
            $('#merchant_postal_code').val('');

            var isi   = $('#province').val();
            let token = "{{ csrf_token() }}";

            $.ajax({
                type    : "POST",
                url     : "<?php echo url('outlet/get/city')?>",
                data    : "_token="+token+"&id_province="+isi,
                success : function(result) {
                    if (result['status'] == "success") {
                        $('#city').prop('disabled', false);

                        var city           = result['result'];
                        var selectCity = '<option value=""></option>';

                        for (var i = 0; i < city.length; i++) {
                            selectCity += '<option value="'+city[i]['id_city']+'">'+city[i]['city_name']+'</option>';
                        }

                        $('#city').html(selectCity);
                    }
                    else {
                        $('#city').prop('disabled', true);
                    }
                }
            });
        });

        $('#city').change(function() {
            $('#district').empty();
            $('#district').prop('disabled', true);
            $('#subdistrict').empty();
            $('#subdistrict').prop('disabled', true);
            $('#merchant_postal_code').val('');

            var isi   = $('#city').val();
            let token = "{{ csrf_token() }}";

            $.ajax({
                type    : "POST",
                url     : "<?php echo url('outlet/get/district')?>",
                data    : "_token="+token+"&id_city="+isi,
                success : function(result) {
                    if (result['status'] == "success") {
                        $('#district').prop('disabled', false);

                        var district           = result['result'];
                        var selectDistrict = '<option value=""></option>';

                        for (var i = 0; i < district.length; i++) {
                            selectDistrict += '<option value="'+district[i]['id_district']+'">'+district[i]['district_name']+'</option>';
                        }

                        $('#district').html(selectDistrict);
                    }
                    else {
                        $('#district').prop('disabled', true);
                    }
                }
            });
        });

        $('#district').change(function() {
            $('#subdistrict').empty();
            $('#subdistrict').prop('disabled', true);
            $('#merchant_postal_code').val('');

            var isi = $('#district').val();
            let token = "{{ csrf_token() }}";

            $.ajax({
                type    : "POST",
                url     : "<?php echo url('outlet/get/subdistrict')?>",
                data    : "_token="+token+"&id_district="+isi,
                success : function(result) {
                    if (result['status'] == "success") {
                        $('#subdistrict').prop('disabled', false);

                        var subdistrict           = result['result'];
                        var selectSubdistrict = '<option value=""></option>';

                        for (var i = 0; i < subdistrict.length; i++) {
                            selectSubdistrict += '<option value="'+subdistrict[i]['id_subdistrict']+'|'+subdistrict[i]['subdistrict_postal_code']+'">'+subdistrict[i]['subdistrict_name']+'</option>';
                        }

                        $('#subdistrict').html(selectSubdistrict);
                    }
                    else {
                        $('#subdistrict').prop('disabled', true);
                    }
                }
            });
        });

        $('#subdistrict').change(function() {
            var isi = $('#subdistrict').val();
            var isi = isi.split('|');

            $('#merchant_postal_code').val(isi[1]);
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
                <span class="caption-subject font-blue sbold uppercase">New Kontraktor</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('kontraktor/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Related User
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih user yang akan terkait dengan outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select name="id_user" class="form-control select2-multiple" data-placeholder="Select User" required>
                                <option></option>
                                @if (!empty($users))
                                    @foreach($users as $suw)
                                        <option value="{{ $suw['id'] }}">{{ $suw['name'] }} - {{ $suw['phone'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    
                    <input type="hidden" name="outlet_type"  value="Kontraktor">
                            
                    <br>
                    <h3 style="text-align: center">Data Outlet</h3>
                    <hr style="border-top: 2px dashed black;">
                    <br>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Name
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="merchant_name" required placeholder="Outlet Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                License Number
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nomor ijin usaha" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control onlynumber" name="merchant_license_number" required placeholder="Outlet License Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Email
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Alamat email outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" name="merchant_email" placeholder="Outlet Email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Phone
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control onlynumber" maxlength="15" name="merchant_phone" placeholder="Outlet Phone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Province
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi letak outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select id="province" name="id_province" class="form-control select2-multiple" data-placeholder="Select Province" required>
                                <option></option>
                                @if (!empty($province))
                                    @foreach($province as $suw)
                                        <option value="{{ $suw['id_province'] }}">{{ $suw['province_name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                City
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kota letak outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select id="city" name="id_city" class="form-control select2-multiple" data-placeholder="Select City" disabled required>
                                <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Disctrict
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kecamatan outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select id="district" class="form-control select2-multiple" data-placeholder="Select Disctrict" disabled required>
                                <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Subdisctrict
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kelurahan outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select id="subdistrict" name="id_subdistrict" class="form-control select2-multiple" data-placeholder="Select Subdisctrict" disabled required>
                                <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Postal Code
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="merchant_postal_code" name="merchant_postal_code" required placeholder="Postal Code" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Address
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="merchant_address" class="form-control" placeholder="Outlet Address" required></textarea>
                        </div>
                    </div>

                    <br>
                    <h3 style="text-align: center">Data PIC</h3>
                    <hr style="border-top: 2px dashed black;">
                    <br>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                PIC Name
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama PIC" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="merchant_pic_name" required placeholder="PIC Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                PIC ID Card Number
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nomor KTP PIC" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control onlynumber" maxlength="30" name="merchant_pic_id_card_number" required placeholder="PIC ID Card Number">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                PIC Email
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan alamat email PIC" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" name="merchant_pic_email" required placeholder="PIC Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                PIC Phone
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nomor telepon PIC" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control onlynumber" maxlength="15" name="merchant_pic_phone" required placeholder="PIC Phone">
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
