@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
@endsection
@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>

    <script>
        $('.date-picker').datepicker({
            format: 'dd M yyyy'
        });
        $('.onlynumber').keypress(function(e) {
            var regex = new RegExp("^[0-9]");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);

            var check_browser = navigator.userAgent.search("Firefox");

            if (check_browser == -1) {
                if (regex.test(str) || e.which == 8) {
                    return true;
                }
            } else {
                if (regex.test(str) || e.which == 8 || e.keyCode === 46 || (e.keyCode >= 37 && e.keyCode <= 40)) {
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
    </script>
    <script>
    // Default map position
    var defaultLat = -8.1325;
    var defaultLng = 113.2245;

    var map = L.map('map-canvas').setView([defaultLat, defaultLng], 13);

    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Marker awal
    var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

    // Update input ketika marker digeser
    marker.on('dragend', function () {
        var latlng = marker.getLatLng();
        $('#lat').val(latlng.lat);
        $('#lng').val(latlng.lng);
    });

    // Update marker ketika klik di map
    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        $('#lat').val(e.latlng.lat);
        $('#lng').val(e.latlng.lng);
    });

    // Fungsi fallback pakai Nominatim jika API tidak punya lat/lng
    function geocodeWithNominatim(name) {
        $.get('https://nominatim.openstreetmap.org/search?format=json&q=' + name, function (data) {
            if (data.length > 0) {
                let lat = parseFloat(data[0].lat);
                let lng = parseFloat(data[0].lon);

                $('#lat').val(lat);
                $('#lng').val(lng);

                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);
            } else {
                alert("Lokasi tidak ditemukan di Nominatim!");
            }
        });
    }
</script>
    <script type="text/javascript">
        

        $(".file").change(function(e) {
            var widthImg  = 300;
            var heightImg = 300;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width == widthImg && this.height == heightImg) {
                        // image.src = _URL.createObjectURL(file);
                        //    $('#formimage').submit()
                    }
                    else {
                        toastr.warning("Please check dimension of your photo.");
                        $('#image').children('img').attr('src', 'https://www.placehold.it/300x300/EFEFEF/AAAAAA&amp;text=no+image');
                        $("#remove_fieldphoto").trigger( "click" );

                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });
        $(".filePhotoDetail").change(function(e) {
            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.height != 375 && this.width != 720) {
                        toastr.warning("Please check dimension of your photo. Maximum height is 375 px");
                        $('#imageDetail').children('img').attr('src', 'https://www.placehold.it/720x375/EFEFEF/AAAAAA&amp;text=no+image');
                        $("#remove_fieldphotodetail").trigger( "click" );
                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });

        $(".filePhotoCover").change(function(e) {
            var widthImg  = 720;
            var heightImg = 375;

            var _URL = window.URL || window.webkitURL;
            var image, file;

            if ((file = this.files[0])) {
                image = new Image();

                image.onload = function() {
                    if (this.width != widthImg && this.height != heightImg) {
                        toastr.warning("Please check dimension of your photo.");
                        $('#imageCover').children('img').attr('src', 'https://www.placehold.it/720x375/EFEFEF/AAAAAA&amp;text=no+image');
                        $("#remove_fieldphotocover").trigger( "click" );

                    }
                };

                image.src = _URL.createObjectURL(file);
            }

        });
    </script>
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
        $('#user').change(function() {
            let name_province     	= $(this).find(':selected').data('province');
            let id_province     	= $(this).find(':selected').data('id_province');
            let city_name     	= $(this).find(':selected').data('city');
            let id_city     	= $(this).find(':selected').data('id_city');
            let email     	= $(this).find(':selected').data('email');
            $('#name_province').val(name_province);
            $('#id_province').val(id_province);
            $('#city_name').val(city_name);
            $('#id_city').val(id_city);
            $('#email').val(email);
            $('#emails').val(email);

            let token = "{{ csrf_token() }}";
            $.ajax({
                type    : "POST",
                url     : "<?php echo url('outlet/get/district')?>",
                data    : "_token="+token+"&id_city="+id_city,
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
                            selectSubdistrict += '<option value="'+subdistrict[i]['id_subdistrict']+'|'+subdistrict[i]['subdistrict_postal_code']+'|'+subdistrict[i]['subdistrict_latitude']+'|'+subdistrict[i]['subdistrict_longitude']+'">'+subdistrict[i]['subdistrict_name']+'</option>';
                            
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
             $('#lat').val(isi[2]);
            $('#lng').val(isi[3]);
            map.setView([isi[2], isi[3]], 15);
            marker.setLatLng([isi[2], isi[3]]);
            $('#merchant_postal_code').val(isi[1]);
        });
         $('#septic_tank_volume').on('change', function () {
            if ($(this).val() === 'lainnya') {
                $('#septic_tank_volume_lainnya').show().prop('required', true);
            } else {
                $('#septic_tank_volume_lainnya').hide().prop('required', false);
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
    <div class="portlet card_ light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Tambah Bangunan</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('bangunan/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <br>
                    <h3 style="text-align: center">Data Bangunan</h3>
                    <hr style="border-top: 2px dashed black;">
                    <br>
                    <div class="form-group">
                            <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                            Customer

                                    </label>
                            </div>
                            <div class="col-md-8">
                                    <select id="user" name="id_user" class="form-control select2-multiple" data-placeholder="Select Customer" required>
                                            <option></option>
                                            @if (!empty($user))
                                                    @foreach($user as $su)
                                                            <option value="{{ $su['id'] }}">{{ $su['name'] }} ({{ $su['phone'] }})</option>
                                                    @endforeach
                                            @endif
                                    </select>
                            </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                NIK 
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nik" required placeholder="NIK">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Name Kepala Keluarga 
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name_kk" required placeholder="Nama Kartu Keluarga">
                        </div>
                    </div>
                    <div class="form-group">
                                    <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                                    Province
                                                    <span class="required" aria-required="true"> * </span>
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
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select id="district" name="id_district"  class="form-control select2-multiple" data-placeholder="Select Disctrict" disabled required>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Subdisctrict
                                <span class="required" aria-required="true"> * </span>
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
                            <input type="text" class="form-control" id="merchant_postal_code" name="postal_code" required placeholder="Postal Code" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Alamat
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="address" class="form-control" placeholder="Address" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Latitude</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control latlong" name="latitude" value='' id="lat" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Longitude</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control latlong" name="longitude" value='' id="lng" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3"></label>
                        <div class="col-md-8">
                            <input id="pac-input" class="controls" type="text" placeholder="Enter a location" style="padding:10px;width:70%" onkeydown="if (event.keyCode == 13) return false;">
                            <div id="map-canvas" style="width:900;height:380px;"></div>
                        </div>
                    </div>
                    
                    {{-- Jenis Bangunan --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Bangunan <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jenis_bangunan" required>
                                <option value="">Pilih Jenis Bangunan</option>
                                <option value="Rumah">Rumah</option>
                                <option value="Ruko / Rumah Kost">Ruko / Rumah Kost</option>
                                <option value="Kantor Swasta / Pabrik / Niaga">Kantor Swasta / Pabrik / Niaga</option>
                                <option value="Kantor Pemerintah">Kantor Pemerintah</option>
                                <option value="Tempat Ibadah">Tempat Ibadah</option>
                                <option value="Sekolah">Sekolah</option>
                                <option value="Tempat Umum">Tempat Umum</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jumlah Anggota Keluarga --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jumlah Anggota Keluarga <span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" name="jml_keluarga" required placeholder="Jumlah Anggota Keluarga">
                        </div>
                    </div>

                    {{-- Volume Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Volume Septic Tank <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="septic_tank_volume" id="septic_tank_volume" required>
                                <option value="">Pilih Volume</option>
                                <option value="0.5">0.5 m³</option>
                                <option value="1">1 m³</option>
                                <option value="1.5">1.5 m³</option>
                                <option value="2">2 m³</option>
                                <option value="2.5">2.5 m³</option>
                                <option value="3">3 m³</option>
                                <option value="lainnya">Lainnya (Sebutkan)</option>
                            </select>
                             <input type="text" 
                                    class="form-control mt-2" 
                                    name="septic_tank_volume_lainnya" 
                                    id="septic_tank_volume_lainnya" 
                                    placeholder="Masukkan volume lainnya (contoh: 4.5 m³)" 
                                    style="display:none;" />
                        </div>
                       
                    </div>

                    {{-- Posisi Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Posisi Septic Tank <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="posisi_septic_tank" required>
                                <option value="">Pilih Posisi</option>
                                <option value="Di Luar Rumah">Di Luar Rumah</option>
                                <option value="Di Dalam Rumah">Di Dalam Rumah</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jenis Bangunan Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Bangunan Septic Tank <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jenis_bangunan_septic" required>
                                <option value="">Pilih Jenis Bangunan Septic Tank</option>
                                <option value="Cor Beton, Kedap">Cor Beton, Kedap</option>
                                <option value="Pasangan Bata Plester, Kedap">Pasangan Bata Plester, Kedap</option>
                                <option value="Plastik / PE">Plastik / PE</option>
                                <option value="Fiberglass">Fiberglass</option>
                                <option value="Buis Beton / Pasangan Bata, Tidak Kedap">Buis Beton / Pasangan Bata, Tidak Kedap</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jenis Kepemilikan Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Kepemilikan Septic Tank <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jenis_kepemilikan" required>
                                <option value="">Pilih Kepemilikan</option>
                                <option value="Pribadi">Pribadi</option>
                                <option value="Bersama">Bersama</option>
                            </select>
                        </div>
                    </div>

                    {{-- Lubang Penyedotan --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Apakah Tersedia Lubang Penyedotan? <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="lubang_penyedotan" required>
                                <option value="">Pilih</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak, Perlu Dibongkar">Tidak, Perlu Dibongkar</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jarak Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jarak Septic Tank dengan Jalan <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jarak_septic_tank" required>
                                <option value="">Pilih Jarak</option>
                                <option value="< 10 Meter">< 10 Meter</option>
                                <option value="10 - 50 Meter">10 - 50 Meter</option>
                                <option value="> 50 Meter">> 50 Meter</option>
                            </select>
                        </div>
                    </div>

                    {{-- Lebar Jalan --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Lebar Jalan Depan Rumah <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="lebar_jalan" required>
                                <option value="">Pilih Lebar Jalan</option>
                                <option value="< 3 Meter">< 3 Meter</option>
                                <option value="3 - 5 Meter">3 - 5 Meter</option>
                                <option value="> 5 Meter">> 5 Meter</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tahun Pembangunan Tangki --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tahun Pembangunan Tangki Septik</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="tahun_pembangunan" placeholder="Contoh: 2005 / Tidak tahu">
                        </div>
                    </div>

                    {{-- Terakhir Disedot --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Kapan Tangki Septik Terakhir Disedot? <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="terakhir_disedot" required>
                                <option value="">Pilih</option>
                                <option value="3 Tahun Terakhir">3 Tahun Terakhir</option>
                                <option value="Tidak Pernah Disedot">Tidak Pernah Disedot</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jenis Sumber Air Minum (multiple select) --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Sumber Air Minum <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="sumber_air_minum[]" multiple="multiple" required>
                                <option value="PDAM">PDAM</option>
                                <option value="PAMSIMAS">PAMSIMAS</option>
                                <option value="Sumur">Sumur</option>
                                <option value="Menampung Air Hujan">Menampung Air Hujan</option>
                                <option value="Air Isi Ulang">Air Isi Ulang</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jarak Sumber Air --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jarak Sumber Air Minum & Penampungan <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jarak_sumber_air" required>
                                <option value="">Pilih</option>
                                <option value="< 10 Meter">< 10 Meter</option>
                                <option value="> 10 Meter">> 10 Meter</option>
                            </select>
                        </div>
                    </div>

                    {{-- Sumber Air Rumah Tangga --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Sumber Air Rumah Tangga <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control select2" name="sumber_air_keluarga[]" multiple="multiple" required>
                                <option value="PDAM">PDAM</option>
                                <option value="PAMSIMAS">PAMSIMAS</option>
                                <option value="Sumur">Sumur</option>
                                <option value="Menampung Air Hujan">Menampung Air Hujan</option>
                                <option value="Air Isi Ulang">Air Isi Ulang</option>
                            </select>
                        </div>
                    </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection