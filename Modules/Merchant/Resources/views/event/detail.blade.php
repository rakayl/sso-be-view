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
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
    <script>
      
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('.datetimepicker').datetimepicker({ 
            format: 'dd M yyyy H:i',
            minDate: today
        });
        $('#province').change(function() {
            $('#city').empty();
            $('#city').prop('disabled', true);
            $('#district').empty();
            $('#district').prop('disabled', true);
            $('#subdistrict').empty();
            $('#subdistrict').prop('disabled', true);
            $('#postal_code').val('');

            var isi   = $('#province').val();
            let token = "{{ csrf_token() }}";

            $.ajax({
                type    : "POST",
                url     : "<?php echo url('outlet/get/city')?>",
                data    : "_token="+token+"&id_province="+isi,
                success : function(result) {
                    if (result['status'] == "success") {
                        console.log(1)
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
            $('#postal_code').val('');

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
            $('#postal_code').val('');

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

            $('#postal_code').val(isi[1]);
        });
        $(".filePhotoCover").change(function(e) {
            var widthImg  = 1080;
            var heightImg = 1920;
            var widthImg2  = 540;
            var heightImg2 = 960;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();
                image.onload = function() {
                    if (this.width == this.height) {
                        // image.src = _URL.createObjectURL(file);
                        //    $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Dimensi Foto Harus 1:1");
                        $('#image').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image');
                        $("#remove_fieldphotocover").trigger( "click" );

                    }
                };
//                image.onload = function() {
////                    if (this.width != widthImg && this.height != heightImg) {
////                        toastr.warning("Please check dimension of your photo.");
//                        $('#imageCover').children('img').attr('src', 'https://www.placehold.it/720x375/EFEFEF/AAAAAA&amp;text=no+image');
//                        $("#remove_fieldphotocover").trigger( "click" );
//
////                    }
//                };

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
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Update Kegiatan</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('event/update/'.$result['id_event']) }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Title
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan title event" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text"  class="form-control"  name="title" value="{{$result['title']??null}}" required placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Deskripsi
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi lengkap event" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="deskripsi"  class="form-control"  placeholder="Deskripsi event" required>{{$result['deskripsi']??null}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Tanggal Mulai Kegiatan
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal lahir dilaksanakan event" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-8">
                                    <div class="input-group date margin-bottom-5">
                                            <input type="text" value="{{date('d M Y H:i',strtotime($result['date']))}}" class="form-control datetimepicker" autocomplete="off" name="date" placeholder="Date Kegiatan" required>
                                            <span class="input-group-btn">
                                                    <button class="btn btn-sm default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                    </button>
                                            </span>
                                    </div>
                            </div>
                    </div>
                    <div class="form-group">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Tanggal Selesai Kegiatan
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tanggal lahir dilaksanakan event" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-8">
                                    <div class="input-group date margin-bottom-5">
                                            <input type="text" value="{{date('d M Y H:i',strtotime($result['end_date']))}}" class="form-control datetimepicker" autocomplete="off" name="end_date" placeholder="Date Kegiatan" required>
                                            <span class="input-group-btn">
                                                    <button class="btn btn-sm default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                    </button>
                                            </span>
                                    </div>
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
                            <select id="province" name="id_province"  class="form-control select2-multiple" data-placeholder="Select Province" required>
                                <option></option>
                                @if (!empty($province))
                                    @foreach($province as $suw)
                                        <option value="{{ $suw['id_province'] }}"  @if($result['id_province']==$suw['id_province']) selected @endif>{{ $suw['province_name'] }}</option>
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
                                <optgroup label="City List">
                                    <option value="{{ $result['id_city'] }}">{{$result['city_name']??null}}</option>
                                </optgroup>
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
                                <optgroup label="Disctrict List">
                                    <option value="{{ $result['id_district'] }}">{{ $result['district_name'] }}</option>
                                </optgroup>
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
                                <optgroup label="Subdisctrict List">
                                    <option value="{{ $result['id_subdistrict'] }}">{{ $result['subdistrict_name'] }}</option>
                                </optgroup>
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
                            <input type="text" class="form-control" id="postal_code" name="postal_code"  value="{{$result['postal_code']??null}}" required placeholder="Postal Code" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Address
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap event" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="address"  class="form-control" placeholder="Kegiatan Address" required>{{$result['address']??null}} </textarea>
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Image Event<span class="required" aria-required="true">* <br> 1080 * 1920 / 540 * 960 </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Ukuran Image ukuran 1080 * 1920 / 540 * 960" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 300px; height: 300px;">
                                    <img src="@if(!empty($result['image_event'])){{$result['image_event']}}@endif" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageCover" style="max-width: 300px; max-height: 300px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="filePhotoCover" id="fieldphotocover" accept="image/*" name="image_event" @if(empty($result['image_event'])) required @endif>
                                    </span>

                                    <a href="javascript:;" id="remove_fieldphotocover" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
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
