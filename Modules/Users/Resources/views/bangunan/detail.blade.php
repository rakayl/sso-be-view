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
@endsection
@section('page-script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('KEY_MAPS')}}&v=3.exp&signed_in=true&libraries=places"></script>
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
        var map;

        var markers = [];

        function initialize(latNow, longNow) {
          var haightAshbury = new google.maps.LatLng(latNow,longNow);
          var marker        = new google.maps.Marker({
            position:new google.maps.LatLng(latNow,longNow),
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
          });

          var mapOptions = {
              zoom: 15,
              center: haightAshbury,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };

          var infowindow = new google.maps.InfoWindow({
              content: '<p>Marker Location:</p>'
          });

          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

          var input = /** @type  {HTMLInputElement} */(
              document.getElementById('pac-input'));

              var types = document.getElementById('type-selector');
              map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
              map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

              var autocomplete = new google.maps.places.Autocomplete(input);

              autocomplete.bindTo('bounds', map);

              var infowindow = new google.maps.InfoWindow();

              google.maps.event.addListener(autocomplete, 'place_changed', function() {
              deleteMarkers();
              infowindow.close();
              marker.setVisible(true);
              var place = autocomplete.getPlace();
              if (!place.geometry) {
                  return;
              }

            // If the place has a geometry, then present it on a map.
              if (place.geometry.viewport) {
                  map.fitBounds(place.geometry.viewport);
              } else {
                  map.setCenter(place.geometry.location);
                  map.setZoom(17);  // Why 17? Because it looks good.
              }
                  addMarker(place.geometry.location);
              });

              google.maps.event.addListener(map, 'click', function(event) {

              deleteMarkers();
              addMarker(event.latLng);
              // marker.openInfoWindowHtml(latLng);
              // infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
              infowindow.open(map, marker);
          });
          // Adds a marker at the center of the map.
          addMarker(haightAshbury);
        }

        function placeMarker(location) {
          marker = new google.maps.Marker({
            position: location,
            map: map,
          });

          markers.push(marker);

          infowindow = new google.maps.InfoWindow({
             content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
          });
          infowindow.open(map,marker);
        }

        // Add a marker to the map and push to the array.

        function addMarker(location) {
          var marker = new google.maps.Marker({
            position: location,
            map: map
          });

          $('#lat').val(location.lat());
          $('#lng').val(location.lng());
          markers.push(marker);
        }

        // Sets the map on all markers in the array.

        function setAllMap(map) {
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
          setAllMap(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
          setAllMap(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
          clearMarkers();
          markers = [];
        }

        google.maps.event.addDomListener(window, 'load', initialize());
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
                                            <select disabled id="user" name="id_user" class="form-control select2-multiple" data-placeholder="Select Customer" required>
                                                    <option></option>
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
                                Name Alamat 
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama alamat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" value='{{$bangunan['name']}}' required placeholder="Nama Alamat">
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
                                Nomor Kartu Keluarga
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nomor kartu keluarga" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="no_kk" value='{{$bangunan['no_kk']}}' required placeholder="Nama Nomor Kartu Keluarga">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Name Kartu Keluarga 
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
                    
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jumlah Anggota Keluarga
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" class="form-control" value='{{$bangunan['jml_keluarga']}}' id="jml_keluarga" name="jml_keluarga" required placeholder="Jumlah Anggota Keluarga">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Volume Septic Tank
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" class="form-control" value='{{$bangunan['septic_tank_volume']}}' id="septic_tank_volume" name="septic_tank_volume" required placeholder="Volume Septic Tank">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Posisi Septic Tank
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="posisi_septic_tank" value='{{$bangunan['posisi_septic_tank']}}' name="posisi_septic_tank" required placeholder="Posisi Septic Tank">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jenis Bangunan
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jenis_bangunan" value='{{$bangunan['jenis_bangunan']}}' name="jenis_bangunan" required placeholder="Jenis Bangunan">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jenis Kepemilikan
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jenis_kepemilikan" value='{{$bangunan['jenis_kepemilikan']}}' name="jenis_kepemilikan" required placeholder="Jenis Kepemilikan">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Sumber Air Utama
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="sumber_air" value='{{$bangunan['sumber_air']}}' name="sumber_air" required placeholder="Sumber Air">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jarak Sumber Air Minum dan Penampungan
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jarak_sumber_air" value='{{$bangunan['jarak_sumber_air']}}' name="jarak_sumber_air" required placeholder="Jarak Sumber Air Minum dan Penampungan">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jenis Sumber Air Untuk Minum
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jenis_sumber_air_minum" value='{{$bangunan['jenis_sumber_air_minum']}}' name="jenis_sumber_air_minum" required placeholder="Jenis Sumber Air Untuk Minum">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jenis Sumber Air Untuk Kebutuhan Rumah Tangga
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jenis_sumber_air_keluarga" value='{{$bangunan['jenis_sumber_air_keluarga']}}' name="jenis_sumber_air_keluarga" required placeholder="Jenis Sumber Air Untuk Kebutuhan Rumah Tangga">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Akses Spald
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="akses_spald" value='{{$bangunan['akses_spald']}}' name="akses_spald" required placeholder="Jenis Sumber Air Untuk Kebutuhan Rumah Tangga">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                BABS
                            </label>
                        </div>
                        <div class="col-md-1">
                            <input type="checkbox" class="form-control" @if($bangunan['babs']) checked @endif id="babs" name="babs" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Cubluk/Lubang Tanah
                            </label>
                        </div>
                        <div class="col-md-1">
                            <input type="checkbox" class="form-control" @if($bangunan['lubang_tanah']) checked @endif id="lubang_tanah" name="lubang_tanah" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Fasilitas Umum
                            </label>
                        </div>
                        <div class="col-md-1">
                            <input type="checkbox" @if($bangunan['fasilitas_umum']) checked @endif class="form-control" id="fasilitas_umum" name="fasilitas_umum" >
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
        </div>            </form>

    </div>
    </div>
@endsection