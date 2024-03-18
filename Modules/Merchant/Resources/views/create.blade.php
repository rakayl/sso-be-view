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
        $(document).ready(function(){
            initialize({{env('LONGITUDE')}}, {{env('LATITUDE')}});
        });
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
    <div class="portlet card_ light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">New Vendor Penyedotan</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('tukang-sedot/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-body">
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Name
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama user"
                                            data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" placeholder="User Name (Required)"
                                        class="form-control" required value="{{ old('name') }}" />
                                    <input type="hidden" name="level" placeholder="User Name (Required)"
                                        class="form-control" required value="Mitra" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Email
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Email user"
                                            data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" onkeyup="" name="email" placeholder="Email (Required & Unique)"
                                        class="form-control" required autocomplete="new-password"
                                        value="{{ old('email') }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Phone
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips"
                                            data-original-title="Nomor telepon seluler" data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="phone" maxlength="20"
                                        placeholder="Phone Number (Required & Unique)" class="form-control onlynumber"
                                        required autocomplete="new-password" value="{{ old('phone') }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Password
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips"
                                            data-original-title="Password terdiri dari minimal 8 digit karakter, wajib mengandung huruf dan angka"
                                            data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" required name="pin"
                                        placeholder="Minimum 8 digits karakter" minlength="8"
                                        class="form-control mask_number" autocomplete="new-password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Sent Password to User?
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips"
                                            data-original-title="Pilih apakah akan mengirimkan password ke user (Yes/No)"
                                            data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="sent_pin" class="form-control input-sm select2"
                                        data-placeholder="Yes / No" required>
                                        <option value="Yes" @if (old('sent_pin') == 'Yes') selected @endif>Yes
                                        </option>
                                        <option value="No" @if (old('sent_pin') == 'No') selected @endif>No
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-icon right">
                                    <label class="col-md-3 control-label">
                                        Birthday
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips" data-original-title="Tanggal lahir user"
                                            data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group date date-picker margin-bottom-5"
                                        data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control form-filter input-sm date-picker"
                                            name="birthday" placeholder="Birthday Date" required>
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
                                        Gender
                                        <span class="required" aria-required="true"> * </span>
                                        <i class="fa fa-question-circle tooltips"
                                            data-original-title="Jenis kelamin user (laki-laki/perempuan)"
                                            data-container="body"></i>
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="gender" class="form-control input-sm select2"
                                        data-placeholder="Male / Female" required>
                                        <option value="">Select...</option>
                                        <option value="Male" @if (old('gender') == 'Male') selected @endif>Male
                                        </option>
                                        <option value="Female" @if (old('gender') == 'Female') selected @endif>Female
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    <br>
                    <h3 style="text-align: center">Data Vendor</h3>
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
                                            City
                                            <span class="required" aria-required="true"> * </span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih kota " data-container="body"></i>
                                    </label>
                            </div>
                            <div class="col-md-8">
                                    <select id="city" name="id_city" class="form-control select2-multiple" data-placeholder="Select City"  required>
                                            <option></option>
                                            @if (!empty($city))
                                                    @foreach($city as $suw)
                                                            <option value="{{ $suw['id_city'] }}">{{ $suw['city_name'] }}</option>
                                                    @endforeach
                                            @endif
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

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Image Logo Portrait <span class="required" aria-required="true">* <br>(300*300) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Logo outlet ukuran 300 x 300" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                    <img src="" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="image" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="file" id="fieldphoto" accept="image/*" name="outlet_image_logo_portrait" required @>
                                    </span>
            
                                    <a href="javascript:;" id="remove_fieldphoto" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Image Cover<span class="required" aria-required="true">* <br>(720*375) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Cover outlet ukuran 730px x 375 px" data-container="body"></i>
                        </label>
                        <div class="col-md-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 300px; height: 150px;">
                                    <img src="" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="imageCover" style="max-width: 300px; max-height: 150px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" class="filePhotoCover" id="fieldphotocover" accept="image/*" name="outlet_image_cover" required>
                                    </span>
            
                                    <a href="javascript:;" id="remove_fieldphotocover" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                
                    <h3 style="text-align: center">Maps</h3>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Latitude</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control latlong" name="outlet_latitude" value='' id="lat" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Longitude</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control latlong" name="outlet_longitude" value='' id="lng" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3"></label>
                            <div class="col-md-8">
                                <input id="pac-input" class="controls" type="text" placeholder="Enter a location" style="padding:10px;width:70%" onkeydown="if (event.keyCode == 13) return false;">
                                <div id="map-canvas" style="width:900;height:380px;"></div>
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
                    
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            
                    <input type="hidden" name="level"  value="Tukang Sedot">
                    <input type="hidden" name="outlet_type"  value="Tukang Sedot">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
