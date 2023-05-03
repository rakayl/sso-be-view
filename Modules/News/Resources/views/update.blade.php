<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $configs    		= session('configs');
 ?>
 @extends('layouts.main-closed')

@section('page-style')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOHBNv3Td9_zb_7uW-AJDU6DHFYk-8e9Y&v=3.exp&signed_in=true&libraries=places"></script>

    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
	 <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.css')}}" rel="stylesheet" type="text/css" />

   <style type="text/css">
     .sort-icon{
      position: absolute;
      top: 7px;
      left: 0px;
      z-index: 10;
      color: #777;
      cursor: move;
     }
     .mt-checkbox.mt-checkbox-outline{
      margin-bottom: 7px;
     }
     input[type="time"].form-control{
      line-height: normal;
     }
     .datepicker{
      padding: 6px 12px;
     }
   </style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
     <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script>
     $('.datepicker').datepicker({
        'format' : 'd-M-yyyy',
        'todayHighlight' : true,
        'autoclose' : true
    });
        var map;

        @if (!empty($news[0]['news_event_latitude']))
          var lat = "{{$news[0]['news_event_latitude']}}";
        @else
          var lat = "-7.7972";
        @endif

        @if (!empty($news[0]['news_event_longitude']))
          var long = "{{$news[0]['news_event_longitude']}}";
        @else
          var long = "110.3688";
        @endif

        var markers = [];

        function initialize() {
          var haightAshbury = new google.maps.LatLng(lat,long);
          var marker        = new google.maps.Marker({
              position:new google.maps.LatLng(lat,long),
              map: map,
              anchorPoint: new google.maps.Point(0, -29)
          });

          var mapOptions = {
              zoom: 12,
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
              marker.openInfoWindowHtml(latLng);
              infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
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

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script type="text/javascript">
        var video={!!json_encode(explode(';',$news[0]['news_video']))!!};
        var video_template='<div class="input-group" style="margin-bottom:5px">'+
          '<input name="news_video[]" type="url" class="form-control featureVideoForm video-content" id="newsVideo%id%" placeholder="Example: https://www.youtube.com/watch?v=u9_2wWSOQ" value="%value%"  data-id="%id%">'+
          '<span class="input-group-btn">'+
            '<button class="btn btn-danger remove-video-btn" type="button" data-id="%id%"><i class="fa fa-times"></i></button>'+
          '</span>'+
        '</div>';

        function drawVideo(){
          if(video.length<=0){
            return addVideo();
          }
          var html="";
          video.forEach(function(vrb,id){
            html+=video_template.replace(/%id%/g,id).replace('%value%',vrb);
          });
          $('#video-container').html(html);
        }

        function addVideo(){
          video.push('');
          drawVideo();
        }
        $(document).ready(function() {
            @if(!empty($news[0]['news_type']))
            var change_type = '{{$news[0]['news_type']}}';
            changeType(change_type);
            @endif

            $('.summernote').summernote({
                placeholder: 'News Content Long',
                tabsize: 2,
                height: 120,
                // fontNames: ['Open Sans'],
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
                    onFocus: function() {
                        var type = $('#news_type').val();

                        switch(type) {
                            case "video":
                                $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                                $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                                break;
                            case "article":
                                $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                                $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_content.jpg')}}")
                                break;
                            case "online_class":
                                $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_full.jpg')}}")
                                $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_content.jpg')}}")
                                break;
                        }
                    },
                    onImageUpload: function(files){
                        sendFile(files[0], $(this).attr('id'));
                    },
                    onMediaDelete: function(target){
                        var name = target[0].src;
                        token = "<?php echo csrf_token(); ?>";
                        $.ajax({
                            type: 'post',
                            data: 'filename='+name+'&_token='+token,
                            url: "{{url('summernote/picture/delete/news')}}",
                            success: function(data){
                                // console.log(data);
                            }
                        });
                    },
                    onKeyup: function (e) {
                        removeValidation();
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
                    url : "{{url('summernote/picture/upload/news')}}",
                    data: data,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(url) {
                        if (url['status'] == "success") {
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

            /* INIT JS */
            // $('.featureOutlet').hide();
            // $('.featureLocation').hide();
            // $('.featureProduct').hide();
            // $('.featureTreatment').hide();
            // $('.featureDate').hide();
            // $('.featureTime').hide();

            /* BUTTON TO TEXT */
            @if (empty($news[0]['news_button_form_text']))
              $('.featureForm').hide();
            @else
              $('.featureForm').show();
              $('.featureFormForm').prop('required',true);
            @endif

            /* featureForm: show/hide input types */
            $('.featureForm').on('change', '.form_input_types', function() {
              var parent = $(this).parents('.mt-repeater-cell');
              var type = $(this).val();

              console.log(parent);
              console.log(type);

              if( !(type == "Dropdown Choice" || type == "Radio Button Choice" || type == "Multiple Choice") ){
                parent.find('.form_input_options').hide();
                parent.find('.form_input_options input').prop('required',false);
              }
              else{
                parent.find('.form_input_options').show();
                parent.find('.form_input_options input').prop('required',true);
              }

              if( type == "Short Text" || type == "Long Text" || type == "Date" ){
                parent.find('.form_input_autofill').show();
              }
              else{
                parent.find('.form_input_autofill').hide();
              }

              // is unique
              if( type == "Short Text" || type == "Long Text" || type == "Number Input" ){
                parent.find('.is_unique').show();
              }
              else{
                parent.find('.is_unique').hide();
              }
            });

            // required tagsinput options
            $('.featureForm').on('itemAdded', '.tagsinput', function(event) {
                $(this).prop('required',false);
                $(this).prev().find('input').prop('required',false);
            });

            // unrequired tagsinput options
            $('.featureForm').on('itemRemoved', '.tagsinput', function(event) {
              if ($(this).val() == ""){
                $(this).prop('required',true);
                $(this).prev().find('input').prop('required',true);
              }
            });

            /* sortable */
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();


			/* OUTLET */
            @if (empty($news[0]['news_outlet']))
              $('.featureOutlet').hide();
            @else
              $('.featureOutlet').show();
              $('.featureOutletForm').prop('required',true);
            @endif

            /* PRODUCT */
            @if (empty($news[0]['news_product']))
              $('.featureProduct').hide();
            @else
              $('.featureProduct').show();
              $('.featureProductForm').prop('required',true);
            @endif

            /* VIDEO */
            @if (empty($news[0]['news_video']))
              $('.featureVideo').hide();
            @else
              $('.featureVideo').show();
              $('.featureVideoForm').prop('required',true);
            @endif

            /* LOCATION */
            @if (empty($news[0]['news_event_location_name']))
              $('.featureLocation').hide();
            @else
              $('.featureLocation').show();
              $('.featureLocationForm').prop('required',true);
            @endif

            /* DATE */
            @if (empty($news[0]['news_event_date_start']))
              $('.featureDate').hide();
            @else
              $('.featureDate').show();
              $('.featureDateForm').prop('required',true);
            @endif

            /* TIME */
            @if (empty($news[0]['news_event_time_start']))
              $('.featureTime').hide();
            @else
              $('.featureTime').show();
              $('.featureTimeForm').prop('required',true);
            @endif

			 /* BUTTON TO FORM */
            $('#featureForm').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureForm', state);
                $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news1.jpg')}}")
                $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news2.jpg')}}")
            });

            /* OUTLET */
            $('#featureOutlet').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureOutlet', state);
                var type = $('#news_type').val();

                switch(type) {
                    case "video":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                        break;
                    case "article":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_outlet.jpg')}}")
                        break;
                    case "online_class":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}")
                        break;
                }
            });

            /* VIDEO */
            $('#featureVideo').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureVideo', state);
                var type = $('#news_type').val();

                switch(type) {
                    case "video":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                        break;
                    case "article":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_video.jpg')}}")
                        break;
                    case "online_class":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}")
                        break;
                }
            });

            /* LOCATION */
            $('#featureLocation').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureLocation', state);
                var type = $('#news_type').val();

                switch(type) {
                    case "video":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                        break;
                    case "article":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_featured.jpg')}}")
                        break;
                    case "online_class":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}")
                        break;
                }
            });

            /* PRODUCT */
            $('#featureProduct').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureProduct', state);
                var type = $('#news_type').val();

                switch(type) {
                    case "video":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                        break;
                    case "article":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_product.jpg')}}")
                        break;
                    case "online_class":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}")
                        break;
                }
            });

            /* DATE */
            $('#featureDate').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureDate', state);
                var type = $('#news_type').val();

                switch(type) {
                    case "video":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                        break;
                    case "article":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_featured.jpg')}}")
                        break;
                    case "online_class":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_time_by.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_date_time.jpg')}}")
                        break;
                }
            });

            /* TIME */
            $('#featureTime').on('switchChange.bootstrapSwitch', function(event, state) {
                actionForm('featureTime', state);
                var type = $('#news_type').val();

                switch(type) {
                    case "video":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                        break;
                    case "article":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_featured.jpg')}}")
                        break;
                    case "online_class":
                        $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_full.jpg')}}")
                        $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_date_time.jpg')}}")
                        break;
                }
            });

            /* PUBLISH DATE */
            $('.publishType').click(function() {
              // tampil duluk
              $('.showPublish').show();

              if ($(this).val() == "always") {
                $('.always').hide();
                $('.always').removeAttr('required');
              }
              else {
                $('.always').show();
                $('.always').prop('required', true);
              }
            });

            $(".file").change(function(e) {
                var type      = $(this).data('jenis');
                var widthImg  = 0;
                var heightImg = 0;

                if (type == "square") {
                widthImg  = 500;
                heightImg = 500;
                }
                else {
                widthImg  = 750;
                heightImg = 375;
                }

                var _URL = window.URL || window.webkitURL;
                var image, file;

                if ((file = this.files[0])) {
                    image = new Image();

                    image.onload = function() {
                        if (this.width == widthImg && this.height == heightImg) {
                            // image.src = _URL.createObjectURL(file);
                        }
                        else {
                            toastr.warning("Please check dimension of your photo.");
                            $(this).val("");
                            // $('#remove_square').click()
                            // image.src = _URL.createObjectURL();

                            if (type == "square") {
                                $('#field_image_square').val("");
                                $('#image_square').children('img').attr('src', 'https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image');
                            }
                            else {
                                $('#field_image_landscape').val("");
                                $('#image_landscape').children('img').attr('src', 'https://www.placehold.it/750x375/EFEFEF/AAAAAA&amp;text=no+image');
                            }
                            console.log($(this).val())
                            // console.log(document.getElementsByName('news_image_luar'))
                        }
                    };

                    image.src = _URL.createObjectURL(file);
                }

            });
            drawVideo();
        });

        function removeValidation(){
            $('#validation').remove();
        }

        $('#myForm').on('submit', function(e) {
            var news_type = $('#news_type').val();

            if($('#field_content_long').summernote('isEmpty') && news_type != 'video') {
                $('#validation').remove();
                $('#field_content_long').parent().append('<p id="validation" style="color: red;margin-top: -2%">Content long can not be empty.</p>');
                e.preventDefault();
                $('#field_content_long').focus();
                focusSet = true;
            }
        })
    </script>
    <script type="text/javascript">
        function actionForm(identity, state) {
            if (state) {
                $('.'+identity).show();
                $('.'+identity+'Form').prop('required',true);

                // jika lokasi
                if (identity == "featureLocation") {
                    initialize();
                }
            }
            else {
                $('.'+identity).hide();
                $('.'+identity+'Form').removeAttr('required');
                $('.'+identity+'Form').val('');
            }
        }

        $('#news_by').focus(function(){
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1_video_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2_video_full.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_date_by.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_time_by.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_full.jpg')}}")
                    break;
            }

        })

        $('#link_video').focus(function(){
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1_video.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2_video.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_title.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_title.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_title.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_content.jpg')}}")
                    break;
            }

        })

        $('#field_title').focus(function(){
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_title.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_title.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_title.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_content.jpg')}}")
                    break;
            }

        })
        $('#field_post_date').focus(function(){
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_date_by.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_full.jpg')}}")
                    break;
            }
        })
        $('#field_content_short').focus(function(){
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1_content_short.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2_content_short.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_full.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_content_short.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_full.jpg')}}")
                    break;
            }
        })
        $('#field_image_square').focus(function(){
            $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/image-square.jpg')}}")
            $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news4.jpg')}}")
        })
        $('#field_image_landscape').focus(function(){
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}")
                    break;
            }
        })
        $('.field_event').focus(function(){
            $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/event.jpg')}}")
        })
        $('.featureVideoForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/video.jpg')}}")
        })
        $('.featureProductForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/product.jpg')}}")
        })
        $('.featureOutletForm').focus(function(){
            $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news3.jpg')}}")
            $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/outlet.jpg')}}")
        })
        $("input[name='publish_type']").change(function(){
            $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news1.jpg')}}")
            $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news2.jpg')}}")
        })
        $(".field_publish_date").focus(function(){
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_date_by.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_post.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}")
                    break;
            }
        })

        $('.news_button').focus(function(){
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2_full.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_button.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2_button.jpg')}}")
                    break;
            }
        })
        $(document).on('focus', '#selectOutlet .select2', function (e) {
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_outlet.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}")
                    break;
            }
        })
        $(document).on('focus', '#selectProduct .select2', function (e) {
            var type = $('#news_type').val();

            switch(type) {
                case "video":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}")
                    break;
                case "article":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1_full.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2_product.jpg')}}")
                    break;
                case "online_class":
                    $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1.jpg')}}")
                    $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}")
                    break;
            }
        })
        $(document).on('focus', '#selectCategory .select2', function (e) {
            $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news1.jpg')}}")
            $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news2.jpg')}}")
        })
        $('#add-video-btn').on('click',addVideo);
        $('#video-container').on('click','.remove-video-btn',function(){
          var id=$(this).data('id');
          video.splice(id,1);
          drawVideo();
        });
        $('#video-container').on('change','.video-content',function(){
          var id=$(this).data('id');
          video[id]=$(this).val();
        });

        function changeType(value) {
            if(value == 'video'){
                $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_1.jpg')}}");
                $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_video_2.jpg')}}");
                $('.form-show').hide();
                $('.form-video-show').show();
                $('#div_link_video').show();
                $("#link_video").prop('required',true);
                $("#news_by").prop('required',false);
                $('.make-switch').bootstrapSwitch('state', false);
            }else{
                $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_1.jpg')}}");
                $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_article_2.jpg')}}");
                $('.form-show').show();
                $('#div_link_video').hide();
                $("#link_video").prop('required',false);
                $("#news_by").prop('required',true);
            }

            if(value == 'online_class'){
                $('#tutorial1').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_1.jpg')}}");
                $('#tutorial2').attr('src', "{{env('STORAGE_URL_VIEW') }}{{('img/news/news_online_class_2.jpg')}}");
                $('#featureLocation').bootstrapSwitch('state', false);
                $('#featureVideo').bootstrapSwitch('state', false);
                $('#featureOutlet').bootstrapSwitch('state', false);
                $('#featureProduct').bootstrapSwitch('state', false);
                $('.form-class-hide').hide();
            }
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
    <a href="{{url('news')}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Update {{ $news[0]['news_title'] }}</span>
            </div>
        </div>
      @foreach ($news as $value)
        <form class="form-horizontal" role="form" id="myForm" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
        <div class="portlet-body m-form__group row">
                <div class="col-md-4">
                    <img src="{{env('STORAGE_URL_VIEW') }}{{('img/news/news1.jpg')}}"  style="box-shadow: 0 0 5px rgba(0,0,0,.08); width:100%" alt="tutorial" id="tutorial1">
                    <img src="{{env('STORAGE_URL_VIEW') }}{{('img/news/news2.jpg')}}" style="box-shadow: 0 0 5px rgba(0,0,0,.08); width:100%" alt="tutorial" id="tutorial2">
                </div>
                <div class="col-md-8">
                <div class="form-body">
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Type
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Tipe artikel" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control select2" name="news_type" id="news_type" required onchange="changeType(this.value)">
                                <option></option>
                                <option value="video" @if($value['news_type'] == 'video') selected @endif>Video</option>
                                <option value="article" @if($value['news_type'] == 'article') selected @endif>Article</option>
                                <option value="online_class" @if($value['news_type'] == 'online_class') selected @endif> Online Class</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-show form-video-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Post Date
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Tanggal news dibuat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="field_post_date" class="form-control datepicker" name="news_post_date" value="{{ (!empty($value['news_post_date']) ? date('d-M-Y', strtotime($value['news_post_date'])) : '')}}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
						<div class="col-md-3">
							<div class="input-group">
								<input type="time" class="form-control" name="news_post_time" value="{{ date('H:i', strtotime($value['news_post_date'])) }}" required>
								<span class="input-group-btn">
									<button class="btn default" type="button">
										<i class="fa fa-clock-o"></i>
									</button>
								</span>
							</div>
						</div>
                    </div>

                    <div class="form-group form-show form-video-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Publish Date
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah new akan selalu ditampilkan atau dalam waktu yang dibatasi (always show/ date limit)" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios4" name="publish_type" class="md-radiobtn publishType" value="limit"  @if (!empty($value['news_publish_date'])) checked @endif>
                                    <label for="optionsRadios4">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Date Limit </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" id="optionsRadios5" name="publish_type" class="md-radiobtn publishType" value="always"  @if (empty($value['news_expired_date'])) checked @endif>
                                    <label for="optionsRadios5">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> Always Show </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group showPublish">
                        <label class="col-md-3 control-label"> </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control datepicker field_publish_date" name="news_publish_date" value="{{ date('d-M-Y', strtotime($value['news_publish_date'])) }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 always" @if (empty($value['news_expired_date'])) style="display: none;" @endif>
                            <div class="input-group">
                                <input type="text" class="form-control always datepicker field_publish_date" name="news_expired_date" @if (!empty($value['news_expired_date'])) value="{{ date('d-M-Y', strtotime($value['news_expired_date'])) }}" @endif>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

<!--                     <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Header Title
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan Header news" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="" class="form-control" name="news_title" value="{ { $value['news_title'] } }" placeholder="Header" required>
                        </div>
                    </div> -->

                    <div class="form-group form-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                News By
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Nama pengisi artikel/kelas online" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" maxlength="30" name="news_by" id="news_by" value="{{ $value['news_by'] }}" placeholder="News By" required>
                        </div>
                    </div>

                    <div class="form-group form-show form-video-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            News Title
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Masukkan judul news" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="field_title" class="form-control" name="news_title" value="{{ $value['news_title'] }}" placeholder="Title" required>
                        </div>
                    </div>

                    <div class="form-group form-video-show" id="div_link_video" @if($value['news_type'] == 'video') style="display: none" @endif>
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Link Video
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Link video" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="link_video" id="link_video" value="{{ $value['link_video'] }}" placeholder="Example: https://www.youtube.com/watch?v=u9_2wWSOQ">
                        </div>
                    </div>

                    <!--<div class="form-group" id="selectCategory">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            News Category
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Pilih kategori News" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <select name="id_news_category" id="id_news_category" class="form-control select2">
                              <option></option>
                              @foreach($categories as $category)
                              <option value="{{$category['id_news_category']}}" @if($category['id_news_category']==$value['id_news_category']) selected @endif>{{$category['category_name']}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>-->
                    <!-- <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Image Square
                            <span class="required" aria-required="true"> * </span>
                            <br>
                            <span class="required" aria-required="true"> (500*500) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran persegi ditampilkan pada list news" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                  <img src="{{ env('STORAGE_URL_API').$value['news_image_luar'] }}" alt="Image Square">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="image_square" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" id="field_image_square" class="file" accept="image/*" data-jenis="square" name="news_image_luar">

                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" id="remove_square" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group form-video-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Image Landscape
                            <span class="required" aria-required="true"> * </span>
                            <br>
                            <span class="required" aria-required="true"> (750*375) </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Gambar dengan ukuran landscape ditampilkan pada header halaman detail news ukuran persegi ditampilkan pada list news" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 100px;">
                                  <img src="{{ $value['url_news_image_dalam'] }}" alt="Image Landscape">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" id="image_landscape" style="max-width: 200px; max-height: 100px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" id="field_image_landscape" accept="image/*" class="file" name="news_image_dalam" data-jenis="landscape" @if(empty($value['news_image_dalam'])) required @endif>
                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-show form-video-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Content Short
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Deskripsi singkat news" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="news_content_short" id="field_content_short" class="form-control" placeholder="Content Short News" required>{{$value['news_content_short']}}</textarea>
                        </div>
                    </div>

                    <div class="form-group form-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Content Long
                            <span class="required" aria-required="true"> * </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Isi konten news. Tarik dua garis ke bawah untuk memperpanjang kotak teks." data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <textarea name="news_content_long" id="field_content_long" class="form-control summernote" required>{{$value['news_content_long']}}</textarea>
                        </div>
                    </div>

                    <div class="form-group form-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Button Text
                                <i class="fa fa-question-circle tooltips" data-original-title="Wording button pada detail news" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control news_button" maxlength="50" name="news_button_text" value="{{ $value['news_button_text'] }}" placeholder="Button Text">
                        </div>
                    </div>

                    <div class="form-group form-show">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Button Link
                                <i class="fa fa-question-circle tooltips" data-original-title="Link pada button" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control news_button" maxlength="250" name="news_button_link" value="{{ $value['news_button_link'] }}" placeholder="Example: meet.google.com/mni-tsxu">
                        </div>
                    </div>

                      <!-- EVENT DATE -->
                      <div class="form-group form-show">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Date
                                <i class="fa fa-question-circle tooltips" data-original-title="Feature date 'ON' jika newss berkenaan dengan tanggal event" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureDate" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty($value['news_event_date_start'])) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureDate">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Date Start <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" class="datepicker form-control featureDateForm field_event" name="news_event_date_start" value="@if(!empty($value['news_event_date_start'])){{ date('d-M-Y',strtotime($value['news_event_date_start'])) }}@endif">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureDate">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Date End <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="text" class="datepicker form-control featureDateForm field_event" name="news_event_date_end" value="@if(!empty($value['news_event_date_end'])){{ date('d-M-Y',strtotime($value['news_event_date_end'])) }}@endif">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- EVENT TIME -->
                        <div class="form-group form-show">
                            <div class="input-icon right">
                                <label class="col-md-3 control-label">
                                Featured Time
                                <i class="fa fa-question-circle tooltips" data-original-title="feature time 'ON' jika news berkenaan dengan waktu event" data-container="body"></i>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <span class="m-switch">
                                    <label>
                                    <input type="checkbox" class="make-switch" id="featureTime" data-size="small" data-on-color="info" name="toggle_time" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty($value['news_event_time_start'])) checked @endif>
                                    <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>

                        <div class="form-group featureTime">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Time Start <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="time" class="form-control featureTimeForm field_event" name="news_event time_start" value="{{ date('h:i', strtotime($value['news_event_time_start'])) }}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group featureTime">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <label class="control-label">Time End <span class="required" aria-required="true"> * </span> </label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="time" class="form-control featureTimeForm field_event" name="news_event_time_end" value="{{ date('h:i', strtotime($value['news_event_time_end'])) }}">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- LOCATION -->
                    <div class="form-group form-show form-class-hide">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Featured Location
                            <i class="fa fa-question-circle tooltips" data-original-title="feature location 'ON' jika news berkenaan dengan tempat event" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <span class="m-switch">
                                <label>
                                <input type="checkbox" class="make-switch" name="toggle_location" id="featureLocation" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty($value['news_event_location_name'])) checked @endif>
                                <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <div class="form-group featureLocation">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Location Name <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control featureLocationForm field_event" name="news_event_location_name" value="{{ $value['news_event_location_name'] }}" placeholder="Location name or name of a place">
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureLocation">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Contact Person </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control field_event" name="news_event_location_phone" value="{{ $value['news_event_location_phone'] }}" placeholder="Contact Person in location">
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureLocation">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3"  style="text-align: right;">
                                <label class="control-label">Address </label>
                            </div>
                            <div class="col-md-9">
                                <textarea type="text" class="form-control field_event" name="news_event_location_address" placeholder="Event's Address">{{ $value['news_event_location_address'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureLocation">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3"  style="text-align: right;">
                                <label class="control-label">Maps </label>
                            </div>
                            <div class="col-md-9">
                                <input id="pac-input" class="controls field_event" type="text" placeholder="Enter a location" style="padding:10px;width:50%" onkeydown="if (event.keyCode == 13) return false;" name="news_event_location_map" value="{{ $value['news_event_location_map'] }}">
                                <div id="map-canvas" style="width:900;height:380px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureLocation">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label"></label>
                            </div>
                            <div class="col-md-9">
                                <div class="col-md-6">
                                    <input type="text" class="form-control featureLocationForm" name="news_event_latitude" value="{{ $value['news_event_latitude'] }}" id="lat" readonly>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control featureLocationForm" name="news_event_longitude" value="{{ $value['news_event_longitude'] }}" id="lng" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- VIDEO -->
                    <div class="form-group form-show form-class-hide">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Featured Video
                            <i class="fa fa-question-circle tooltips" data-original-title="feature video 'ON' jika ingin menambahkan video pada news" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <span class="m-switch">
                                <label>
                                <input type="checkbox" class="make-switch" id="featureVideo" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF"  @if (!empty($value['news_video'])) checked @endif>
                                <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <div class="form-group featureVideo">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control featureVideoForm" name="news_video_text" value="{{ $value['news_video_text'] }}" placeholder="Featured Video Title">
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureVideo">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Link Video <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id="video-container"></div>
                            <div class="col-md-offset-3 col-md-9" style="margin-top: 10px">
                              <button class="btn blue" type="button" id="add-video-btn" onclick="addVideo"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>

                    <!-- OUTLET -->
                    <div class="form-group form-show form-class-hide">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Featured Outlet
                            <i class="fa fa-question-circle tooltips" data-original-title="feature Outlet 'ON' jika news berkenaan dengan outlet" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <span class="m-switch">
                                <label>
                                <input type="checkbox" class="make-switch" id="featureOutlet" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty($value['news_outlet'])) checked @endif>
                                <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <div class="form-group featureOutlet">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control featureOutletForm" name="news_outlet_text" value="{{ $value['news_outlet_text'] }}" placeholder="Featured Outlet Title">
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureOutlet">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Outlet <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id='selectOutlet'>
                                <select class="form-control select2-multiple featureOutletForm" multiple data-placeholder="Select Outlet" name="id_outlet[]">
                                    <optgroup label="Outlet List">
                                        @php
                                            if (!empty($value['news_outlet'])) {
                                            $selectedOutlet = array_pluck($value['news_outlet'], 'id_outlet');
                                            }
                                            else {
                                            $selectedOutlet = [];
                                            }
                                        @endphp

                                        @if (!empty($outlet))
                                            @foreach($outlet as $suw)
                                                <option value="{{ $suw['id_outlet'] }}" @if (in_array($suw['id_outlet'], $selectedOutlet)) selected @endif>{{ $suw['outlet_name'] }}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- PRODUCT -->
                    <div class="form-group form-show form-class-hide">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Featured Product
                            <i class="fa fa-question-circle tooltips" data-original-title="feature product 'ON' jika news berkenaan dengan produk" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <span class="m-switch">
                                <label>
                                <input type="checkbox" class="make-switch" id="featureProduct" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty($value['news_product'])) checked @endif>
                                <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <div class="form-group featureProduct">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Title <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control featureProductForm" name="news_product_text" value="{{ $value['news_product_text'] }}" placeholder="Featured Product Title">
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureProduct">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Product <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9" id="selectProduct">
                                <select class="form-control select2-multiple featureProductForm" multiple data-placeholder="Select Product" name="id_product[]">
                                    <optgroup label="Product List">
                                        @php
                                        if (!empty($value['news_product'])) {
                                            $selectedProduct = array_pluck($value['news_product'], 'id_product');
                                        }
                                        else {
                                            $selectedProduct = [];
                                        }
                                        @endphp

                                        @if (!empty($product))
                                            @foreach($product as $suw)
                                                <option value="{{ $suw['id_product'] }}" @if (in_array($suw['id_product'], $selectedProduct)) selected @endif>{{ $suw['product_name'] }}</option>
                                            @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                @if(MyHelper::hasAccess([107], $configs))
					<!-- BUTTON TO FORM -->
                    <div class="form-group" id="customform">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                            Custom Form
                            <i class="fa fa-question-circle tooltips" data-original-title="Button to Form 'ON' jika news memiliki form yang harus diisi" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <span class="m-switch">
                                <label>
                                <input name="custom_form_checkbox" type="checkbox" class="make-switch" id="featureForm" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF" @if (!empty($value['news_button_form_text'])) checked @endif>
                                <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

					<div class="form-group featureForm">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-9">
                                <a href="{{url('/news/form-preview', $value['id_news'])}}" target="_BLANK">Klik disini untuk melihat form</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureForm">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Button Text <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control featureFormForm" name="news_button_form_text" value="{{ $value['news_button_form_text'] }}" placeholder="Button to Form text">
                            </div>
                        </div>
                    </div>

					<div class="form-group featureForm">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-3">
                                <label class="control-label">Button Exp <span class="required" aria-required="true"> * </span> </label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
									<input type="text" class="datepicker form-control featureFormForm field_event" name="news_button_form_expired" value="{{ ($value['news_button_form_expired']!="" ? date('d-M-Y',strtotime($value['news_button_form_expired'])) : "") }}">
									<span class="input-group-btn">
										<button class="btn default" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group featureForm">
                      <label class="col-md-3 control-label"></label>
                      <div class="col-md-9">
                        <div class="col-md-3">
                          <label class="control-label">Success Msg</label>
                        </div>
                        <div class="col-md-9">
                          <input type="text" class="form-control field_event" name="news_form_success_message" value="{{ $value['news_form_success_message'] }}">
                        </div>
                      </div>
                    </div>

					          <div class="form-group featureForm">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="col-md-12">
                                <div class="form-group mt-repeater">
									<div data-repeater-list="customform" id="sortable">
										@foreach($value['news_form_structures'] as $key => $form)
										<div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
											<div class="mt-repeater-cell" style="position: relative;">
                        <div class="sort-icon">
                          <i class="fa fa-arrows tooltips" data-original-title="Ubah urutan form dengan drag n drop" data-container="body"></i>
                        </div>
												<div class="col-md-12">
													<div class="col-md-2">
														<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
															<i class="fa fa-close"></i>
														</a>
													</div>
													<div class="input-icon right">
														<div class="col-md-4" style="padding-top: 5px;">
															Input Name
															<i class="fa fa-question-circle tooltips" data-original-title="Nama Input pada Form" data-container="body" ></i>
                              <span class="required" aria-required="true"> * </span>
														</div>
													</div>
													<div class="col-md-6" >
														<div class="input-icon right">
															<input type="text" name="form_input_label" class="form-control demo featureFormForm" value="{{$form['form_input_label']}}">
														</div>
													</div>
												</div>
												<div class="col-md-12" style="margin-top:20px">
													<div class="input-icon right">
														<div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
															Input Types
															<i class="fa fa-question-circle tooltips" data-original-title="Tipe inputan user" data-container="body"></i>
                              <span class="required" aria-required="true"> * </span>
														</div>
													</div>
													<div class="col-md-6" >
														<select class="form-control form_input_types featureFormForm" name="form_input_types">
															<option value="Short Text" @if($form['form_input_types'] == "Short Text") selected @endif>Short Text</option>
															<option value="Long Text" @if($form['form_input_types'] == "Long Text") selected @endif>Long Text</option>
															<option value="Number Input" @if($form['form_input_types'] == "Number Input") selected @endif>Number Input</option>
															<option value="Date" @if($form['form_input_types'] == "Date") selected @endif>Date</option>
															<option value="Date & Time" @if($form['form_input_types'] == "Date & Time") selected @endif>Date & Time</option>
															<option value="Dropdown Choice" @if($form['form_input_types'] == "Dropdown Choice") selected @endif>Dropdown Choice</option>
															<option value="Radio Button Choice" @if($form['form_input_types'] == "Radio Button Choice") selected @endif>Radio Button Choice</option>
															<option value="Multiple Choice" @if($form['form_input_types'] == "Multiple Choice") selected @endif>Multiple Choice</option>
															<option value="File Upload" @if($form['form_input_types'] == "File Upload") selected @endif>File Upload</option>
															<option value="Image Upload" @if($form['form_input_types'] == "Image Upload") selected @endif>Image Upload</option>
														</select>
													</div>
												</div>
												@if($form['form_input_types'] == "Radio Button Choice" || $form['form_input_types'] == "Multiple Choice" || $form['form_input_types'] == "Dropdown Choice")
												<div class="col-md-12 form_input_options" style="margin-top:20px" id="option_{{$key}}" >
												@else
												<div class="col-md-12 form_input_options" style="margin-top:20px; display:none;" id="option_{{$key}}">
												@endif
													<div class="input-icon right">
														<div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
															Input Options
															<i class="fa fa-question-circle tooltips" data-original-title="Warna teks nama level pada aplikasi" data-container="body" ></i>
                              <span class="required" aria-required="true"> * </span>
														</div>
													</div>
													<div class="col-md-6" >
														<div class="input-icon right">
															<input type="text" name="form_input_options" class="form-control demo tagsinput" value="{{$form['form_input_options']}}" data-role="tagsinput" placeholder="comma (,) separated">
														</div>
													</div>
												</div>
                        {{-- form_input_autofill --}}
                        @if( $form['form_input_types'] == "Short Text" || $form['form_input_types'] == "Long Text" || $form['form_input_types'] == "Date" )
                        <div class="col-md-12 form_input_autofill" style="margin-top:20px;">
                        @else
                        <div class="col-md-12 form_input_autofill" style="margin-top:20px; display: none;">
                        @endif
                          <div class="input-icon right">
                            <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                              Input Autofill
                              <i class="fa fa-question-circle tooltips" data-original-title="Isian otomatis dari data profil user" data-container="body"></i>
                            </div>
                          </div>
                          <div class="col-md-6" >
                            <div class="input-icon right">
                              <select class="form-control" name="form_input_autofill">
                                <option value="">--None--</option>
                                <option value="Name" {{ ($form['form_input_autofill']=='Name' ? 'selected' : '') }}>Name</option>
                                <option value="Phone" {{ ($form['form_input_autofill']=='Phone' ? 'selected' : '') }}>Phone</option>
                                <option value="Email" {{ ($form['form_input_autofill']=='Email' ? 'selected' : '') }}>Email</option>
                                <option value="Gender" {{ ($form['form_input_autofill']=='Gender' ? 'selected' : '') }}>Gender</option>
                                <option value="City" {{ ($form['form_input_autofill']=='City' ? 'selected' : '') }}>City</option>
                                <option value="Birthday" {{ ($form['form_input_autofill']=='Birthday' ? 'selected' : '') }}>Birthday</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-12" style="margin-top:20px;">
                            <div class="input-icon right">
                              <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                Is Required
                                <i class="fa fa-question-circle tooltips" data-original-title="Apakah wajib diisi?" data-container="body"></i>
                              </div>
                            </div>
                            <div class="col-md-6" >
                              <div class="input-icon right">
                                <div class="mt-checkbox-list">
                                  <label class="mt-checkbox mt-checkbox-outline">
                                      <input type="checkbox" name="is_required" value="1" {{ ($form['is_required']==1 ? "checked" : "") }}>
                                      <span></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12 is_unique" style="margin-top:20px;">
                            <div class="input-icon right">
                              <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                Is Unique
                                <i class="fa fa-question-circle tooltips" data-original-title="Apakah data unik?" data-container="body"></i>
                              </div>
                            </div>
                            <div class="col-md-6" >
                              <div class="input-icon right">
                                <div class="mt-checkbox-list">
                                  <label class="mt-checkbox mt-checkbox-outline">
                                      <input type="checkbox" name="is_unique" value="1" {{ ($form['is_unique']==1 ? "checked" : "") }}>
                                      <span></span>
                                  </label>
                                </div>

                              </div>
                            </div>
                          </div>

											</div>
										</div>
										@endforeach

										@if(empty($value['news_form_structures']))
										<div data-repeater-item class="mt-repeater-item mt-overflow" style="border-bottom: 1px #ddd;">
											<div class="mt-repeater-cell" style="position: relative;">
                        <div class="sort-icon">
                          <i class="fa fa-arrows tooltips" data-original-title="Ubah urutan form dengan drag n drop" data-container="body"></i>
                        </div>

												<div class="col-md-12">
													<div class="col-md-2">
														<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
															<i class="fa fa-close"></i>
														</a>
													</div>
													<div class="input-icon right">
														<div class="col-md-4" style="padding-top: 5px;">
															Input Name
															<i class="fa fa-question-circle tooltips" data-original-title="Nama Input pada Form" data-container="body"></i>
                              <span class="required" aria-required="true"> * </span>
														</div>
													</div>
													<div class="col-md-6" >
														<div class="input-icon right">
															<input type="text" name="form_input_label" class="form-control demo featureFormForm">
														</div>
													</div>
												</div>
												<div class="col-md-12" style="margin-top:20px">
													<div class="input-icon right">
														<div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
															Input Types
															<i class="fa fa-question-circle tooltips" data-original-title="Tipe inputan user" data-container="body"></i>
                              <span class="required" aria-required="true"> * </span>
														</div>
													</div>
													<div class="col-md-6" >
														<select class="form-control form_input_types featureFormForm" name="form_input_types">
															<option value="Short Text">Short Text</option>
															<option value="Long Text">Long Text</option>
															<option value="Number Input">Number Input</option>
															<option value="Date">Date</option>
															<option value="Date & Time">Date & Time</option>
															<option value="Dropdown Choice">Dropdown Choice</option>
															<option value="Radio Button Choice">Radio Button Choice</option>
															<option value="Multiple Choice">Multiple Choice</option>
															<option value="File Upload">File Upload</option>
															<option value="Image Upload">Image Upload</option>
														</select>
													</div>
												</div>
												<div class="col-md-12 form_input_options" style="margin-top:20px; display: none;">
													<div class="input-icon right">
														<div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
															Input Options
															<i class="fa fa-question-circle tooltips" data-original-title="Warna teks nama level pada aplikasi" data-container="body"></i>
                              <span class="required" aria-required="true"> * </span>
														</div>
													</div>
													<div class="col-md-6" >
														<div class="input-icon right">
															<input type="text" name="form_input_options" class="form-control demo tagsinput" data-role="tagsinput" placeholder="comma (,) separated">
														</div>
													</div>
												</div>

                        <div class="col-md-12 form_input_autofill" style="margin-top:20px;">
                          <div class="input-icon right">
                            <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                              Input Autofill
                              <i class="fa fa-question-circle tooltips" data-original-title="Isian otomatis dari data profil user" data-container="body"></i>
                            </div>
                          </div>
                          <div class="col-md-6" >
                            <div class="input-icon right">
                              <select class="form-control" name="form_input_autofill">
                                <option value="">--None--</option>
                                <option value="Name">Name</option>
                                <option value="Phone">Phone</option>
                                <option value="Email">Email</option>
                                <option value="Gender">Gender</option>
                                <option value="City">City</option>
                                <option value="Birthday">Birthday</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-12" style="margin-top:20px;">
                            <div class="input-icon right">
                              <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                Is Required
                                <i class="fa fa-question-circle tooltips" data-original-title="Apakah wajib diisi?" data-container="body"></i>
                              </div>
                            </div>
                            <div class="col-md-6" >
                              <div class="input-icon right">
                                <div class="mt-checkbox-list">
                                  <label class="mt-checkbox mt-checkbox-outline">
                                      <input type="checkbox" name="is_required" value="1">
                                      <span></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12 is_unique" style="margin-top:20px;">
                            <div class="input-icon right">
                              <div class="col-md-offset-2 col-md-4" style="padding-top: 5px;">
                                Is Unique
                                <i class="fa fa-question-circle tooltips" data-original-title="Apakah data unik?" data-container="body"></i>
                              </div>
                            </div>
                            <div class="col-md-6" >
                              <div class="input-icon right">
                                <div class="mt-checkbox-list">
                                  <label class="mt-checkbox mt-checkbox-outline">
                                      <input type="checkbox" name="is_unique" value="1">
                                      <span></span>
                                  </label>
                                </div>

                              </div>
                            </div>
                          </div>

											</div>
										</div>
										@endif
									</div>
									<div class="form-action col-md-12">
										<div class="col-md-2"></div>
										<div class="col-md-10">
											@if(MyHelper::hasAccess([12], $grantedFeature))
												<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
												<i class="fa fa-plus"></i> Add New Input</a>
											@endif
										</div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
                </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                        <hr style="width:95%; margin-left:auto; margin-right:auto; margin-bottom:20px">
                        </div>
                        <div class="col-md-offset-6 col-md-4">
                            <input type="hidden" name="id_news" value="{{ $value['id_news'] }}">
                            @if(MyHelper::hasAccess([22], $grantedFeature))
                                <button type="submit" class="btn green">Submit</button>
                            @endif
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
          @endforeach
        </div>
    </div>
@endsection