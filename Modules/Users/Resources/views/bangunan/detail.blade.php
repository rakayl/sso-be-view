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
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endsection
@section('page-script')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
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

    <script type="text/javascript">
        $('.timepicker').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,

        });
        // sortable
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
    </script>
    <script>
        var map, marker;

        function initMap(latNow, lngNow) {
            // Inisialisasi peta
            map = L.map('map-canvas').setView([latNow, lngNow], 15);

            // Tambahkan tile dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Tambahkan marker default
            marker = L.marker([latNow, lngNow], {draggable: true}).addTo(map);

            // Update input ketika marker digeser
            marker.on('dragend', function(e) {
                var latlng = marker.getLatLng();
                document.getElementById("lat").value = latlng.lat;
                document.getElementById("lng").value = latlng.lng;
            });

            // Klik di peta → pindahkan marker
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                marker.setLatLng([lat, lng]);

                document.getElementById("lat").value = lat;
                document.getElementById("lng").value = lng;
            });

            // Tambahkan geocoder (search lokasi)
            L.Control.geocoder({
                defaultMarkGeocode: false
            })
            .on('markgeocode', function(e) {
                var bbox = e.geocode.bbox;
                var center = e.geocode.center;

                map.fitBounds(bbox);
                marker.setLatLng(center);

                document.getElementById("lat").value = center.lat;
                document.getElementById("lng").value = center.lng;
            })
            .addTo(map);
        }

        document.addEventListener("DOMContentLoaded", function() {
            let latNow = "{{ $bangunan['latitude'] }}";
            let lngNow = "{{ $bangunan['longitude'] }}";

            if (latNow === "" || lngNow === "") {
                // Jika kosong pakai lokasi browser
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        initMap(position.coords.latitude, position.coords.longitude);
                    }, function() {
                        initMap({{env('LATITUDE')}}, {{env('LONGITUDE')}});
                    });
                } else {
                    initMap({{env('LATITUDE')}}, {{env('LONGITUDE')}});
                }
            } else {
                initMap(latNow, lngNow);
            }
        });
    </script>

    <script type="text/javascript">

        $(document).ready(function(){
            $('#table_product').DataTable( {
                "pageLength": 15,
                "lengthChange": false,
                "ordering": false,
                "info" : false
            });
            /* MAPS */
            longNow = "{{ $bangunan['longitude'] }}";
            latNow = "{{ $bangunan['latitude'] }}";

            if (latNow == "" || longNow == "") {
              navigator.geolocation.getCurrentPosition(function(position){
                  initialize(position.coords.latitude, position.coords.longitude);
              },
              function (error) {
                if (error.code == error.PERMISSION_DENIED)
                initialize({{env('LONGITUDE')}}, {{env('LATITUDE')}});
              });
            }
            else {
              initialize(latNow, longNow);
            }

            /*=====================================*/

            // untuk show atau hide informasi photo
            if ($('.deteksi').data('dis') != 1) {
                $('.deteksi-trigger').hide();
            }
            else {
                $('.deteksi-trigger').show();
            }

            let token = "{{ csrf_token() }}";

            // hapus gambar
            $('.hapus-gambar').click(function() {
                let id     = $(this).data('id');
                let parent = $(this).parent().parent().parent().parent();

                $.ajax({
                    type : "POST",
                    url : "{{ url('outlet/photo/delete') }}",
                    data : "_token="+token+"&id_outlet_photo="+id,
                    success : function(result) {

                        if (result == "success") {
                            parent.remove();
                            toastr.info("Photo has been deleted.");
                        }
                        else {
                            toastr.warning("Something went wrong. Failed to delete photo.");
                        }
                    }
                });
            });

            // change info
            $('#infoOutlet').click(function() {
            //   initialize();
            // console.log(latNow)
            // console.log(latNow)

            // initialize(latNow, longNow);

            });

            $('#province').change(function() {
                $('#city').empty();
                $('#city').prop('disabled', true);
                $('#district').empty();
                $('#district').prop('disabled', true);
                $('#subdistrict').empty();
                $('#subdistrict').prop('disabled', true);
                $('#outlet_postal_code').val('');

                var isi         = $('#province').val();

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
                                selectCity += '<option value="'+city[i]['id_city']+'" >'+city[i]['city_name']+'</option>';
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
                $('#outlet_postal_code').val('');

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
                $('#outlet_postal_code').val('');

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
                console.log(isi)
                $('#postal_code').val(isi[1]);
            });

             $('#septic_tank_volume').on('change', function () {
                if ($(this).val() === 'lainnya') {
                    $('#septic_tank_volume_lainnya').show().prop('required', true);
                } else {
                    $('#septic_tank_volume_lainnya').hide().prop('required', false);
                }
            });
            
        });
    </script>

    <script type="text/javascript">
   

    $('.latlong').change(function(){
        var lat = $('#lat').val()
        var long = $('#lng').val()
        initialize(lat, long);
    })
    $('.is_closed').change(function(){
        if($(this).is(':checked')){
            $('#'+$(this).attr('data-id')).val('1')
        }else{
            $('#'+$(this).attr('data-id')).val('0')
        }
    })

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
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
                <span class="caption-subject font-blue sbold uppercase">Update Bangunan</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('bangunan/update') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <br>
                    <h3 style="text-align: center">Data Bangunan</h3>
                    <hr style="border-top: 2px dashed black;">
                    <br>
                    <div class="form-group">
                                    <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                                    Customer
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi " data-container="body"></i>
                                            </label>
                                    </div>
                                    <div class="col-md-8">
                                            <select id="user" name="id_user" class="form-control select2-multiple" data-placeholder="Select Customer" required>
                                                    <option value=''>Pilih Customer</option>
                                                    @if (!empty($user))
                                                            @foreach($user as $su)
                                                                    <option value="{{ $su['id'] }}" @if($bangunan['id_user']==$su['id']) selected @endif>{{ $su['name'] }} ({{ $su['phone'] }})</option>
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
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan NIK" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nik" value='{{$bangunan['nik']}}' required placeholder="NIK">
                        </div>
                    </div>
                 
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Name Kepala Keluarga 
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama kartu keluarga" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name_kk" value='{{$bangunan['name_kk']}}' required placeholder="Nama Kartu Keluarga">
                        </div>
                    </div>
                    <div class="form-group">
                                    <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                                    Province
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi " data-container="body"></i>
                                            </label>
                                    </div>
                                    <div class="col-md-8">
                                            <select id="province" name="id_province" class="form-control select2-multiple" data-placeholder="Select Province" required>
                                                    <option></option>
                                                    @if (!empty($province))
                                                            @foreach($province as $suw)
                                                                    <option @if ($suw['id_province'] == $bangunan['id_province']) selected @endif  value="{{ $suw['id_province'] }}">{{ $suw['province_name'] }}</option>
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
                        <option value="{{ $bangunan['city']['id_city'] }}">{{ $bangunan['city']['city_name'] }}</option>
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
                <select id="district" name="id_district" class="form-control select2-multiple" data-placeholder="Select Disctrict" disabled required>
                    <optgroup label="Disctrict List">
                        <option value="{{ $bangunan['district']['id_district'] }}">{{ $bangunan['district']['district_name'] }}</option>
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
                        <option value="{{ $bangunan['subdistrict']['id_subdistrict'] }}">{{ $bangunan['subdistrict']['subdistrict_name'] }}</option>
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
                            <input type="text" class="form-control" id="postal_code" value='{{$bangunan['postal_code']}}' name="postal_code" required placeholder="Postal Code" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Alamat
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap " data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="address" class="form-control" placeholder="Address" required>{{$bangunan['address']}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Latitude</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control latlong" name="latitude" value='{{$bangunan['latitude']}}' id="lat" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Longitude</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control latlong" name="longitude" value='{{$bangunan['longitude']}}' id="lng" required>
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
                                <option @if($bangunan['jenis_bangunan'] == 'Rumah') 
                                         selected @endif value="Rumah">Rumah</option>
                                <option @if($bangunan['jenis_bangunan'] == 'Ruko / Rumah Kost') 
                                         selected @endif value="Ruko / Rumah Kost">Ruko / Rumah Kost</option>
                                <option @if($bangunan['jenis_bangunan'] == 'Kantor Swasta / Pabrik / Niaga') 
                                         selected @endif value="Kantor Swasta / Pabrik / Niaga">Kantor Swasta / Pabrik / Niaga</option>
                                <option @if($bangunan['jenis_bangunan'] == 'Kantor Pemerintah') 
                                         selected @endif value="Kantor Pemerintah">Kantor Pemerintah</option>
                                <option @if($bangunan['jenis_bangunan'] == 'Tempat Ibadah') 
                                         selected @endif value="Tempat Ibadah">Tempat Ibadah</option>
                                <option @if($bangunan['jenis_bangunan'] == 'Sekolah') 
                                         selected @endif value="Sekolah">Sekolah</option>
                                <option @if($bangunan['jenis_bangunan'] == 'Tempat Umum') 
                                         selected @endif value="Tempat Umum">Tempat Umum</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jumlah Anggota Keluarga --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jumlah Anggota Keluarga <span class="required">*</span></label>
                        <div class="col-md-8">
                            <input type="number" value='{{$bangunan['jml_keluarga']}}' class="form-control" name="jml_keluarga" required placeholder="Jumlah Anggota Keluarga">
                        </div>
                    </div>

                    {{-- Volume Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Volume Septic Tank <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="septic_tank_volume" id="septic_tank_volume" required>
                                <option value="">Pilih Volume</option>
                                <option @if($bangunan['septic_tank_volume'] == '0.5') 
                                         selected @endif value="0.5">0.5 m³</option>
                                <option @if($bangunan['septic_tank_volume'] == '1') 
                                         selected @endif value="1">1 m³</option>
                                <option @if($bangunan['septic_tank_volume'] == '1.5') 
                                         selected @endif value="1.5">1.5 m³</option>
                                <option @if($bangunan['septic_tank_volume'] == '2') 
                                         selected @endif value="2">2 m³</option>
                                <option @if($bangunan['septic_tank_volume'] == '2.5') 
                                         selected @endif value="2.5">2.5 m³</option>
                                <option @if($bangunan['septic_tank_volume'] == '3') 
                                         selected @endif value="3">3 m³</option>
                                <option @if($bangunan['septic_tank_volume'] == 'lainnya') 
                                         selected @endif value="lainnya">Lainnya (Sebutkan)</option>
                            </select>
                             <input type="text" 
                                    class="form-control mt-2" 
                                    name="septic_tank_volume_lainnya" 
                                    id="septic_tank_volume_lainnya" 
                                    placeholder="Masukkan volume lainnya (contoh: 4.5 m³)" 
                                    value='{{$bangunan['septic_tank_volume_lainnya']}}'
                                    @if($bangunan['septic_tank_volume'] != 'lainnya') 
                                         style="display:none;" @endif
                                     />
                        </div>
                       
                    </div>

                    {{-- Posisi Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Posisi Septic Tank <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="posisi_septic_tank" required>
                                <option value="">Pilih Posisi</option>
                                <option @if($bangunan['posisi_septic_tank'] == 'Di Luar Rumah') 
                                         selected @endif value="Di Luar Rumah">Di Luar Rumah</option>
                                <option @if($bangunan['posisi_septic_tank'] == 'Di Dalam Rumah') 
                                         selected @endif value="Di Dalam Rumah">Di Dalam Rumah</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jenis Bangunan Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Bangunan Septic Tank <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jenis_bangunan_septic" required>
                                <option @if($bangunan['jenis_bangunan_septic'] == 'Di Dalam Rumah') 
                                         selected @endif value="">Pilih Jenis Bangunan Septic Tank</option>
                                <option @if($bangunan['jenis_bangunan_septic'] == 'Cor Beton, Kedap') 
                                         selected @endif value="Cor Beton, Kedap">Cor Beton, Kedap</option>
                                <option @if($bangunan['jenis_bangunan_septic'] == 'Pasangan Bata Plester, Kedap') 
                                         selected @endif value="Pasangan Bata Plester, Kedap">Pasangan Bata Plester, Kedap</option>
                                <option @if($bangunan['jenis_bangunan_septic'] == 'Plastik / PE') 
                                         selected @endif value="Plastik / PE">Plastik / PE</option>
                                <option @if($bangunan['jenis_bangunan_septic'] == 'Fiberglass') 
                                         selected @endif value="Fiberglass">Fiberglass</option>
                                <option @if($bangunan['jenis_bangunan_septic'] == 'Buis Beton / Pasangan Bata, Tidak Kedap') 
                                         selected @endif value="Buis Beton / Pasangan Bata, Tidak Kedap">Buis Beton / Pasangan Bata, Tidak Kedap</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jenis Kepemilikan Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Kepemilikan Septic Tank <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jenis_kepemilikan" required>
                                <option value="">Pilih Kepemilikan</option>
                                <option @if($bangunan['jenis_kepemilikan'] == 'Pribadi') 
                                         selected @endif value="Pribadi">Pribadi</option>
                                <option @if($bangunan['jenis_kepemilikan'] == 'Bersama') 
                                         selected @endif value="Bersama">Bersama</option>
                            </select>
                        </div>
                    </div>

                    {{-- Lubang Penyedotan --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Apakah Tersedia Lubang Penyedotan? <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="lubang_penyedotan" required>
                                <option value="">Pilih</option>
                                <option @if($bangunan['lubang_penyedotan'] == 'Ya') 
                                         selected @endif value="Ya">Ya</option>
                                <option @if($bangunan['lubang_penyedotan'] == 'Tidak, Perlu Dibongkar') 
                                         selected @endif value="Tidak, Perlu Dibongkar">Tidak, Perlu Dibongkar</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jarak Septic Tank --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jarak Septic Tank dengan Jalan <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jarak_septic_tank" required>
                                <option value="">Pilih Jarak</option>
                                <option @if($bangunan['jarak_septic_tank'] == '< 10 Meter"') 
                                         selected @endif value="< 10 Meter">< 10 Meter</option>
                                <option @if($bangunan['jarak_septic_tank'] == '10 - 50 Meter') 
                                         selected @endif value="10 - 50 Meter">10 - 50 Meter</option>
                                <option @if($bangunan['jarak_septic_tank'] == '> 50 Meter') 
                                         selected @endif value="> 50 Meter">> 50 Meter</option>
                            </select>
                        </div>
                    </div>

                    {{-- Lebar Jalan --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Lebar Jalan Depan Rumah <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="lebar_jalan" required>
                                <option value="">Pilih Lebar Jalan</option>
                                <option @if($bangunan['lebar_jalan'] == '< 3 Meter') 
                                         selected @endif value="< 3 Meter">< 3 Meter</option>
                                <option @if($bangunan['lebar_jalan'] == '3 - 5 Meter') 
                                         selected @endif value="3 - 5 Meter">3 - 5 Meter</option>
                                <option @if($bangunan['lebar_jalan'] == '> 5 Meter') 
                                         selected @endif value="> 5 Meter">> 5 Meter</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tahun Pembangunan Tangki --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Tahun Pembangunan Tangki Septik</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value='{{$bangunan['tahun_pembangunan']}}' name="tahun_pembangunan" placeholder="Contoh: 2005 / Tidak tahu">
                        </div>
                    </div>

                    {{-- Terakhir Disedot --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Kapan Tangki Septik Terakhir Disedot? <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="terakhir_disedot" required>
                                <option value="">Pilih</option>
                                <option @if($bangunan['terakhir_disedot'] == '3 Tahun Terakhir') 
                                         selected @endif value="3 Tahun Terakhir">3 Tahun Terakhir</option>
                                <option @if($bangunan['terakhir_disedot'] == 'Tidak Pernah Disedot') 
                                         selected @endif value="Tidak Pernah Disedot">Tidak Pernah Disedot</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jenis Sumber Air Minum (multiple select) --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Sumber Air Minum <span class="required">*</span></label>
                        <div class="col-md-8">
                            @php
                                // decode JSON ke array
                                $selectedSumber = !empty($bangunan['sumber_air_minum']) 
                                    ? json_decode($bangunan['sumber_air_minum'], true) 
                                    : [];
                            @endphp

                            <select class="form-control select2" name="sumber_air_minum[]" multiple="multiple" required>
                                <option value="PDAM" @if(in_array('PDAM', $selectedSumber)) selected @endif>PDAM</option>
                                <option value="PAMSIMAS" @if(in_array('PAMSIMAS', $selectedSumber)) selected @endif>PAMSIMAS</option>
                                <option value="Sumur" @if(in_array('Sumur', $selectedSumber)) selected @endif>Sumur</option>
                                <option value="Menampung Air Hujan" @if(in_array('Menampung Air Hujan', $selectedSumber)) selected @endif>Menampung Air Hujan</option>
                                <option value="Air Isi Ulang" @if(in_array('Air Isi Ulang', $selectedSumber)) selected @endif>Air Isi Ulang</option>
                            </select>
                        </div>
                    </div>

                    {{-- Jarak Sumber Air --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jarak Sumber Air Minum & Penampungan <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="jarak_sumber_air" required>
                                <option value="">Pilih</option>
                                <option @if($bangunan['jarak_sumber_air'] == '< 10 Meter') 
                                         selected @endif value="< 10 Meter">< 10 Meter</option>
                                <option @if($bangunan['jarak_sumber_air'] == '> 10 Meter') 
                                         selected @endif value="> 10 Meter">> 10 Meter</option>
                            </select>
                        </div>
                    </div>

                    {{-- Sumber Air Rumah Tangga --}}
                    <div class="form-group">
                        <label class="col-md-3 control-label">Jenis Sumber Air Rumah Tangga <span class="required">*</span></label>
                        <div class="col-md-8">
                            @php
                                    // decode JSON ke array
                                    $selectedSumber1 = !empty($bangunan['sumber_air_keluarga']) 
                                        ? json_decode($bangunan['sumber_air_keluarga'], true) 
                                        : [];
                                @endphp

                                <select class="form-control select2" name="sumber_air_keluarga[]" multiple="multiple" required>
                                    <option value="PDAM" @if(in_array('PDAM', $selectedSumber1)) selected @endif>PDAM</option>
                                    <option value="PAMSIMAS" @if(in_array('PAMSIMAS', $selectedSumber1)) selected @endif>PAMSIMAS</option>
                                    <option value="Sumur" @if(in_array('Sumur', $selectedSumber1)) selected @endif>Sumur</option>
                                    <option value="Menampung Air Hujan" @if(in_array('Menampung Air Hujan', $selectedSumber1)) selected @endif>Menampung Air Hujan</option>
                                    <option value="Air Isi Ulang" @if(in_array('Air Isi Ulang', $selectedSumber1)) selected @endif>Air Isi Ulang</option>
                                </select>
                        </div>
                    </div>
                  
               
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <input type="hidden" class="form-control" id="id_user_address" value="{{$bangunan['id_user_address']}}" name="id_user_address" >
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
        </div>            
        </form>

    </div>
    </div>
@endsection