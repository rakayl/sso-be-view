
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
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
		$(document).ready(function() {
            // library initialization
            $('[data-switch=true]').bootstrapSwitch();
			
			$.ajax({
				type: "GET",
				url: "getTag",
				dataType: "json",
				success: function(data){
					if (data.status == 'fail') {
						$.ajax(this)
						return
					}
					productLoad = 1;
					$.each(data, function( key, value ) {
						$('#selectService').append("<option id='service"+value.id_doctor_service+"' value='"+value.doctor_service_name+"'>"+value.doctor_service_name+"</option>");
					});
					$('#multipleProduct').prop('required', true)
					$('#multipleProduct').prop('disabled', false)
				},
				complete: function(data){
					doctor_service = JSON.parse('{!!json_encode($service)!!}')
					$.each(doctor_service, function( key, value ) {
						$("#doctor_service"+value.doctor_service.doctor_service_name+"").attr('selected', true)
					});
				}
			});

			$("#selectService").select2({
				placeholder: "Input Service",
				tags: true
			});

			$('.price').each(function() {
				var input = $(this).val();
				var input = input.replace(/[\D\s\._\-]+/g, "");
				input = input ? parseInt( input, 10 ) : 0;

				$(this).val( function() {
					return ( input === 0 ) ? "" : input.toLocaleString( "id" );
				});
			});

			$( ".price" ).on( "keyup", numberFormat);
			function numberFormat(event){
				var selection = window.getSelection().toString();
				if ( selection !== '' ) {
					return;
				}

				if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
					return;
				}
				var $this = $( this );
				var input = $this.val();
				var input = input.replace(/[\D\s\._\-]+/g, "");
				input = input ? parseInt( input, 10 ) : 0;

				$this.val( function() {
					return ( input === 0 ) ? "" : input.toLocaleString( "id" );
				});
			}

			$( ".price" ).on( "blur", checkFormat);
			function checkFormat(event){
				var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
				if(!$.isNumeric(data)){
					$( this ).val("");
				}
			}

			var max_fields = 10;
			var wrapper = $(".container1");
			var add_button = $(".add_form_field");

			var x = 1;
			$(add_button).click(function(e) {
				e.preventDefault();
				if (x < max_fields) {
					x++;
					$(wrapper).append('<div><div class="col-md-8" style="margin-top:10px;"><input type="text" name="practice_experience_place[]" placeholder="Practice Experience Place" class="form-control" required /></div><div class="col-md-4" style="margin-top:10px;"> <a href="#" class="delete">Delete</a> </div> </div>'); //add input box
				} else {
					alert('You Reached the limits')
				}
			});

			$(wrapper).on("click", ".delete", function(e) {
				e.preventDefault();
				$(this).parent('div').parent('div').remove();
				x--;
			})

			var _URL = window.URL || window.webkitURL;
			$("#field_image").change(function (e) {
			    var file, img;
			    if ((file = this.files[0])) {
			        img = new Image();
			        var objectUrl = _URL.createObjectURL(file);
			        img.onload = function () {
			            if (this.width != 300 && this.height != 300) {
			            	alert(this.width + " " + this.height);
			            	$('#removeImage').click();
			            }
			            _URL.revokeObjectURL(objectUrl);
			        };
			        img.src = objectUrl;
			    }
			});

			$(".file").change(function(e) {
				var type      = $(this).data('jenis');
				var widthImg  = 0;
				var heightImg = 0;
				var _URL = window.URL || window.webkitURL;
				var image, file;

				if ((file = this.files[0])) {
					image = new Image();

					image.onload = function() {
						if (type == "doctor_photo") {
							if ($(".file").val().split('.').pop().toLowerCase() != 'png') {
								toastr.warning("Please check type of your photo.");
								$("#removeLogo").trigger( "click" );
							}
							if (this.width != 300 || this.height != 300) {
								toastr.warning("Please check dimension of your photo.");
								$("#removeLogo").trigger( "click" );
							}
						}
					};
					image.src = _URL.createObjectURL(file);
				}
			});
		});
	</script>
	<script>
        $('.timepicker').timepicker({
            autoclose: true,
            showSeconds: false,
        });

        var tmp = [0];
        function changeType(value) {
			console.log("typeee");
            if(value != ''){
                $('#use_shift').show();
                $('#without_shift').hide();

                if(tmp.length == 0){
                    addShift();
                }
            }
        }

		var countJ = parseInt($("#count_array").val());
		var j = 1;
		if(countJ > 0){
			var j=countJ + 1;
		}
		function addSchedule() {
            var html =  '<div class="form-group" id="div_schedule_child_'+j+'">'+
						'<div class="col-md-1" style="text-align: right">'+
                        '<a class="btn btn-danger" onclick="deleteChildSchedule('+j+')">&nbsp;<i class="fa fa-trash"></i></a>'+
                        '</div>'+
						'<label for="multiple" class="control-label col-md-2">Hari <span class="required" aria-required="true"> * </span>'+
						'<i class="fa fa-question-circle tooltips" data-original-title="Aktifkan Jadwal dan Tambahkan Sesi konsultasi" data-container="body"></i>'+
						'</label>'+
						'<div class="col-md-3">'+
						'<select class="form-control select2" id="office_hour_type" name="schedules['+j+'][day]" onchange="changeType('+this.value+')" required>'+
						'<option></option>'+
						'<option value="monday">Senin</option>'+
						'<option value="tuesday">Selasa</option>'+
						'<option value="wednesday">Rabu</option>'+
						'<option value="thursday">Kamis</option>'+
						'<option value="friday">Jumat</option>'+
						'<option value="saturday">Sabtu</option>'+
						'<option value="sunday">Minggu</option>'+
						'</select>'+
						'</div>'+
						'<div id="use_shift_'+j+'">'+
						'<div class="form-group">'+
						'<div class="col-md-3"></div>'+
						'<div class="col-md-4">'+
						'<a class="btn btn-primary" onclick="addShift('+j+')">&nbsp;<i class="fa fa-plus-circle"></i> Add Session </a>'+
						'</div>'+
						'</div>'+
						'<div class="form-group">'+
						'<div class="col-md-3"></div>'+
						'<div class="col-md-3">Session Start</div>'+
						'<div class="col-md-3">Session End</div>'+
						'</div>'+
						'<div id="div_shift_child_'+j+'">'+
						'<div class="form-group" id="div_shift_child_'+j+'_0">'+
						'<div class="col-md-3"></div>'+
						'<div class="col-md-3">'+
						'<input type="text" style="background-color: white" data-placeholder="select time" id="time_start_0"  name="schedules['+j+'][session_time][0][start_time]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
						'</div>'+
						'<div class="col-md-3">'+
						'<input type="text" style="background-color: white" data-placeholder="select time" id="time_end_0" name="schedules['+j+'][session_time][0][end_time]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
						'</div>'+
						'<input type="hidden" name="schedules['+j+'][is_active]" value="1">'+
						'<div class="col-md-3">'+
						'<a class="btn btn-danger" onclick="deleteChild('+j+', 0)">&nbsp;<i class="fa fa-trash"></i></a>'+
						'</div>'+
						'</div>'+
						'</div>'+
						'</div>'+
						'</div>';

			console.log(html);
            $("#div_schedule_parent").append(html);
            $('.timepicker').timepicker({
                autoclose: true,
                showSeconds: false,
            });
            tmp.push(j);
            j++;
        }
        
        // function addShiftPreparation(j) {
		// 	var countTime = parseInt($('#count_array_time_'+j).val());
		// 	var i=1;
		// 	if(countTime > 0) {
		// 		var i=countTime+1; 
		// 	}

		// 	console.log("iii"+i);

		// 	addShift(j, i);
		// }

		var i = 20;
        function addShift(j) {
			console.log('this is value of j:'+j);
			// console.log(i);
			// $('#header_child_'+j).show();
			// $('#header_child_'+j).removeClass("hidden");
            var html =  '<div class="form-group" id="div_shift_child_'+j+'_'+i+'">'+
						'<div class="col-md-3"></div>'+
						'<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" id="time_start_'+i+'" data-placeholder="select time" name="schedules['+j+'][session_time]['+i+'][start_time]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
                        '<div class="col-md-3">'+
                        '<input type="text" style="background-color: white" id="time_end_'+i+'" data-placeholder="select time" name="schedules['+j+'][session_time]['+i+'][end_time]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>'+
                        '</div>'+
						'<div class="col-md-3">'+
                        '<a class="btn btn-danger" onclick="deleteChild('+j+', '+i+')">&nbsp;<i class="fa fa-trash"></i></a>'+
                        '</div>'+
                        '</div>';

            $('#div_shift_child_'+j).append(html);
            $('.timepicker').timepicker({
                autoclose: true,
                showSeconds: false,
            });
            tmp.push(i);
            i++;
        }

        function deleteChild(j, i){
            $('#div_shift_child_'+j+'_'+i).remove();
            var index = tmp.indexOf(i);
            if(index >= 0){
                tmp.splice(index, 1);
            }
        }

		function deleteChildSchedule(number){
			console.log("hereeee");
			console.log(number);
            $('#div_schedule_child_'+number).remove();
            var index = tmp.indexOf(number);
            if(index >= 0){
                tmp.splice(index, 1);
            }
        }
        
        function submit() {
            var type = $("#office_hour_type").val();

            var err = '';
            if(name.trim().length === 0){
                err += 'Please input data name.\n';
            }

            if(type === ''){
                err += 'Please select type.\n';
            }

            if(!empty(type)){
                for (var j=0;j<tmp.length;j++){
                    var time_start = $('#time_start_'+tmp[j]).val();
                    var time_end = $('#time_end_'+tmp[j]).val();

                    if(time_start == '0:00' && time_end == '0:00'){
                        err += 'Time can not be 0:00 - 0:00\n';
                        break;
                    }
                }
            }

            if(err !== ''){
                swal("Error!", err, "error");
            }else{
                $('form#form_submit').submit();
            }
        }
    </script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="#">Home</a>
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
</div>
<br>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="tab-content">
			<div class="tabbable-line tabbable-full-width">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#overview" data-toggle="tab"> Info Personal </a>
					</li>
					@if(isset($doctor))
					<li>
						<a href="#password" data-toggle="tab"> Change Password </a>
					</li>
					@endif
					@if(isset($doctor))
					<li>
						<a href="#schedule" data-toggle="tab"> Doctor Schedule </a>
					</li>
					@endif
				</ul>
			</div>
			<div class="tab-pane active" id="overview">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							@if(isset($doctor))
								<span class="caption-subject bold uppercase">Detail Doctor</span>
							@else
								<span class="caption-subject bold uppercase">New Doctor</span>
							@endif
						</div>
					</div>
					<div class="portlet-body form">
						@if(isset($doctor))
						<form role="form" class="form-horizontal" action="{{ url('/doctor', $doctor['id_doctor'])}}/update"" method="POST" enctype="multipart/form-data">
							@method('PUT')
							<input name="id_doctor" value="{{$doctor['id_doctor']}}" class="form-control hidden" />
						@else 
						<form role="form" class="form-horizontal" action="{{url('doctor/store')}}" method="POST" enctype="multipart/form-data">
						@endif
							{{ csrf_field() }}
							<div class="form-body">
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Name
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama doctor" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="doctor_name" placeholder="Doctor Name (Required)" value="{{isset($doctor) ? $doctor['doctor_name'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Phone
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Nomor telepon seluler" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="doctor_phone" placeholder="Phone Number (Required & Unique)" value="{{isset($doctor) ? $doctor['doctor_phone'] : ''}}" class="form-control" required autocomplete="new-password" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										ID Card Number
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan Nomor Kartu Identitas dengan 16 digit karakter" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="id_card_number" placeholder="Id Card Number (Required) Must Contain 16 Digit Characters" value="{{isset($doctor) ? $doctor['id_card_number'] : ''}}" class="form-control" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" pattern='.{16}' />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Address
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan Alamat" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<textarea type="text" name="address" placeholder="Input your address here..." class="form-control" required>{{isset($doctor) ? $doctor['address'] : ''}}</textarea> 
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Gender
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Jenis kelamin user (laki-laki/perempuan)" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<select name="gender" class="form-control input-sm select2" data-placeholder="Male / Female" required>
											<option value="">Select...</option>
											<option value="Male" {{isset($doctor) ? $doctor['gender'] == "Male" ? "selected" : '' : ''}}>Male</option>
											<option value="Female" {{isset($doctor) ? $doctor['gender'] == "Female" ? "selected" : '' : ''}}>Female</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Birthday
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Tanggal lahir user" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
											<input type="text" value="{{isset($doctor) ? $doctor['birthday'] ? date('d/m/Y', strtotime($doctor['birthday'])) : '' : ''}}" class="form-control form-filter input-sm date-picker" name="birthday" placeholder="Birthday Date" required>
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
										Celebrate
										<i class="fa fa-question-circle tooltips" data-original-title="Kota domisili user" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<select name="celebrate" class="form-control input-sm select2" placeholder="Search Celebrate" data-placeholder="Choose Users Celebrate">
											<option value="">Select...</option>
											@if(isset($celebrate))
												@foreach($celebrate as $row)
													<option value="{{$row}}" {{isset($doctor) ? $doctor['celebrate'] == $row ? "selected" : '' : ''}}>{{$row}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								@if(!isset($doctor))
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Password
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Password terdiri dari minimal 8 digit karakter, wajib mengandung huruf dan angka" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="password" name="pin" placeholder="Minimum 8 digits karakter (Leave empty to autogenerate)" minlength="8" class="form-control mask_number" autocomplete="new-password" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Send Password to Doctor?
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Pilih apakah akan mengirimkan password ke user (Yes/No)" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-4">
										<select name="sent_pin" class="form-control input-sm select2" data-placeholder="Yes / No" required>
											<option value="">Select...</option>
											<option value="Yes" @if(old('sent_pin') == 'Yes') selected @endif>Yes</option>
											<option value="No" @if(old('sent_pin') == 'No') selected @endif>No</option>
										</select>
									</div>
								</div>
								@endif
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Outlet Clinic
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Pilih klinik dokter" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<select name="id_outlet" class="form-control input-sm select2" data-placeholder="Select Outlet Clinic..." required>
											<option value="">Select Outlet Clinic...</option>
											@if(isset($outlet))
												@foreach($outlet as $row)
													<?php
														$selected = '';
														if((isset($doctor) && $doctor['id_outlet'] == $row['id_outlet']) || (!empty($id_outlet) && $id_outlet == $row['id_outlet'])){
															$selected = 'selected';
														}
													?>
													<option value="{{$row['id_outlet']}}" {{$selected}}>{{$row['outlet_name']}}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Specialist
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Pilih specialist dokter" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<select name="doctor_specialist[]" id="selectService" class="form-control input-sm select2-multiple select2-hidden-accessible" multiple="multiple" data-placeholder="Select specialist..." required>
											<option value="">Select Specialist...</option>
											@if(isset($specialist))
												@if(isset($doctor))
													@foreach($specialist as $key => $row)
														@php $selected = (in_array($row['id_doctor_specialist'], $selected_id_specialist) ? 'selected' : ''); @endphp
														<option value="{{$row['id_doctor_specialist']}}"
														{{isset($doctor) ? $selected : ''}}>
														{{$row['doctor_specialist_name']}}</option>
													@endforeach
												@else
													@foreach($specialist as $key => $row)
														<option value="{{$row['id_doctor_specialist']}}">
														{{$row['doctor_specialist_name']}}</option>
													@endforeach
												@endif
											@endif
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Service
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Pilih service dokter" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<select name="doctor_service[]" id="selectService" class="form-control input-sm select2-multiple select2-hidden-accessible" multiple="multiple" data-placeholder="Select service..." required>
											<option value="">Select Service...</option>
											@if(isset($service))
												@if(isset($doctor) && $doctor['doctor_service'] != null)
													@foreach($service as $row)
														@php $selected = (in_array($row['doctor_service_name'], $doctor['doctor_service']) ? 'selected' : ''); @endphp
														<option value="{{$row['doctor_service_name']}}"}}
														{{isset($doctor) ? $selected : ''}}>
														{{$row['doctor_service_name']}}</option>
													@endforeach
												@else
													@foreach($service as $row)
														<option value="{{$row['doctor_service_name']}}"}}>
														{{$row['doctor_service_name']}}</option>
													@endforeach
												@endif
											@endif
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Session Price
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan harga sesi" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-4">
										<input type="text" name="doctor_session_price" placeholder="Session Price (Required)" value="{{isset($doctor) ? $doctor['doctor_session_price'] : ''}}" class="form-control price" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Practice Experience
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan jumlah tahun dan bulan praktek" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="practice_experience" placeholder="Practice Experience (Required) ex: 4 years 7 month" value="{{isset($doctor) ? $doctor['practice_experience'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Practice Experience Place
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan jumlah tahun praktek" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<div class="container1">
											<button class="add_form_field btn btn-success" style="margin-bottom:10px;">Add New Field &nbsp; 
												<span style="font-weight:bold;">+ </span>
											</button>
											@if(isset($doctor) && $doctor['practice_experience_place'] != null)
												@foreach($doctor['practice_experience_place'] as $exp)
													<div><div class="col-md-8" style="margin-bottom:10px;"><input type="text" name="practice_experience_place[]" placeholder="Practice Experience Place (Required)" class="form-control" value="{{$exp}}" required /></div><div class="col-md-4" style="margin-top:10px;"> <a href="#" class="delete">Delete</a> </div></div>
												@endforeach
											@else
												<div><div class="col-md-8"><input type="text" name="practice_experience_place[]" placeholder="Practice Experience Place (Required)" class="form-control" required /></div></div>
											@endif
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Alumni
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan alumni doctor" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="alumni" placeholder="Alumni Doctor (Required)" value="{{isset($doctor) ? $doctor['alumni'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Registration Certificate Number
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan Nomor Sertifikat" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="registration_certificate_number" placeholder="Registration Certificate Number (Required)" value="{{isset($doctor) ? $doctor['registration_certificate_number'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
										Practice Lisence Number
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Masukkan Surat Izin Praktek" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="text" name="practice_lisence_number" placeholder="Practice Lisence Number (Required)" value="{{isset($doctor) ? $doctor['practice_lisence_number'] : ''}}" class="form-control" required />
									</div>
								</div>
								<div class="form-group">
									<input type="hidden" name="is_active" value="0"/>
									<label class="col-md-3 control-label"> Status Account <span class="text-danger">*</span></label>
									<div class="col-md-3">
										<input data-switch="true" type="checkbox" name="is_active" data-on-text="Active" data-off-text="Deactive" {{isset($doctor) && $doctor['is_active'] ? 'checked' : ''}}/>
									</div>
								</div>
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Id Photo
											<span class="required" aria-required="true"> (300*300) </span>
											<br>
											<span class="required" aria-required="true"> (ONLY PNG) </span>
											<i class="fa fa-question-circle tooltips" data-original-title="Foto Professional Dokter" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
												<img style="margin-top:18px;" src="@if(!empty($doctor['doctor_photo'])) {{env('STORAGE_URL_API').$doctor['doctor_photo']}} @else https://www.cs.emory.edu/site/media/rg5 @endif">
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 300px; max-height: 300px;"> </div>
											<div>
												<span class="btn default btn-file">
													<span class="fileinput-new"> Select image </span>
													<span class="fileinput-exists"> Change </span>
													<input type="file" accept="image/*" class="file" name="doctor_photo" value="{{isset($doctor) ? $doctor['doctor_photo'] : ''}}" data-jenis="doctor_photo">
												</span>
												<a href="javascript:;" id="removeLogo" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="input-icon right">
									<label class="col-md-3 control-label"> </label>
								</div>
								<div class="col-md-9">
									<div class="form-actions">
										{{ csrf_field() }}
										<button type="submit" class="btn blue" id="checkBtn">{{isset($doctor) ? 'Update' : 'Create'}}</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			@if(isset($doctor))
			<div class="tab-pane" id="password">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
								<span class="caption-subject bold uppercase">Doctor Password</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form role="form" class="form-horizontal" action="{{ url('/doctor', $doctor['id_doctor'])}}/update-password" method="POST" enctype="multipart/form-data">
							@method('PUT')
							<input name="id_doctor" value="{{$doctor['id_doctor']}}" class="form-control hidden" />
							{{ csrf_field() }}
							<div class="form-body">
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Password
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Password terdiri dari minimal 8 digit karakter, wajib mengandung huruf dan angka" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="password" name="password_new" placeholder="Minimum 8 digits karakter (Leave empty to autogenerate)" minlength="8" class="form-control mask_number" autocomplete="new-password" required />
									</div>
								</div>
							</div>
							<div class="form-body">
								<div class="form-group">
									<div class="input-icon right">
										<label class="col-md-3 control-label">
											Re-Type Password
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Password terdiri dari minimal 8 digit karakter, wajib mengandung huruf dan angka" data-container="body"></i>
										</label>
									</div>
									<div class="col-md-7">
										<input type="password" name="password_new_confirmation" placeholder="Minimum 8 digits karakter (Leave empty to autogenerate)" minlength="8" class="form-control mask_number" required />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="input-icon right">
									<label class="col-md-3 control-label"> </label>
								</div>
								<div class="col-md-9">
									<div class="form-actions">
										{{ csrf_field() }}
										<button type="submit" class="btn blue" id="checkBtn">Update</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			@endif
			@if(isset($doctor))
			<div class="tab-pane" id="schedule">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">Doctor Schedule</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form class="form-horizontal" id="form_submit" role="form" action="{{ url('/doctor', $doctor['id_doctor'])}}/update-schedule" method="post">
							@method('PUT')
							{{ csrf_field() }}
							@if(!empty($doctor['schedules_raw']))
							<div class="form-body">
								<div class="form-group">
									<div class="col-md-1">
										<a class="btn btn-primary hidden" onclick="addSchedule()">&nbsp;<i class="fa fa-plus-circle"></i> Add Schedule </a>
									</div>
								</div>
								@php $count = count($doctor['schedules_raw']);@endphp
								<input type="hidden" id="count_array" value="{{$count}}">
								<div id="div_schedule_parent">
									@foreach($doctor['schedules_raw'] as $key => $schedule)
									<div class="form-group" id="div_schedule_child_{{$key}}">
										<div class="col-md-1" style="text-align: right">
											<a class="btn btn-danger hidden" onclick="deleteChildSchedule(0)">&nbsp;<i class="fa fa-trash"></i></a>
										</div>
										<label for="multiple" class="control-label col-md-2">Hari <span class="required" aria-required="true"> * </span>
											<i class="fa fa-question-circle tooltips" data-original-title="Aktifkan Jadwal dan Tambahkan Sesi konsultasi" data-container="body"></i>
										</label>
										<input type="hidden" name="schedules[{{$key}}][id_doctor_schedule]" value="{{$schedule['id_doctor_schedule']}}">
										<div class="col-md-3">
											<select disabled="true" class="form-control select" id="office_hour_type[0]" name="schedules[{{$key}}][day]" required>
												<option></option>
												<option value="monday" {{strtolower($schedule['day']) == "monday" ? 'selected' : ''}}>Senin</option>
												<option value="tuesday" {{strtolower($schedule['day']) == "tuesday" ? 'selected' : ''}}>Selasa</option>
												<option value="wednesday" {{strtolower($schedule['day']) == "wednesday" ? 'selected' : ''}}>Rabu</option>
												<option value="thursday" {{strtolower($schedule['day']) == "thursday" ? 'selected' : ''}}>Kamis</option>
												<option value="friday" {{strtolower($schedule['day']) == "friday" ? 'selected' : ''}}>Jumat</option>
												<option value="saturday" {{strtolower($schedule['day']) == "saturday" ? 'selected' : ''}}>Sabtu</option>
												<option value="sunday" {{strtolower($schedule['day']) == "sunday" ? 'selected' : ''}}>Minggu</option>
											</select>
										</div>
										<input type="hidden" name="schedules[{{$key}}][day]" value="{{$schedule['day']}}">
										{{--<input type="hidden" name="schedules[{{$key}}][is_active]" value="1">--}}
										<div id="use_shift_0">
											<div class="form-group">
												<div class="col-md-3"></div>
												<div class="col-md-4">
													<a class="btn btn-primary" onclick="addShift({{$key}})">&nbsp;<i class="fa fa-plus-circle"></i> Add Session </a>
													<input type="checkbox" name="schedules[{{$key}}][is_active]" @if($schedule['is_active'] == '1') checked @endif class="make-switch switch-change" data-size="small" data-on-text="Active" data-off-text="Inactive">
												</div>
											</div>
											@if(!empty($schedule['schedule_time']))
											<div class="form-group">
												<div class="col-md-3"></div>
												<div class="col-md-3">Session Start</div>
												<div class="col-md-3">Session End</div>
											</div>
											@php $count = count($schedule['schedule_time']);@endphp
											<input type="hidden" id="count_array_time_{{$key}}" value="{{$count}}">
											<div id="div_shift_child_{{$key}}">
											@foreach($schedule['schedule_time'] as $key2 => $time)
												<div class="form-group" id="div_shift_child_{{$key}}_{{$key2}}">
													<div class="col-md-3"></div>
													<div class="col-md-3">
														<input type="text" style="background-color: white" data-placeholder="select time" id="time_start_{{$key2}}"  name="schedules[{{$key}}][session_time][{{$key2}}][start_time]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="{{$time['start_time']}}" readonly>
													</div>
													<div class="col-md-3">
														<input type="text" style="background-color: white" data-placeholder="select time" id="time_end_{{$key2}}" name="schedules[{{$key}}][session_time][{{$key2}}][end_time]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="{{$time['end_time']}}" readonly>
													</div>
													<div class="col-md-3">
														<a class="btn btn-danger" onclick="deleteChild({{$key}}, {{$key2}})">&nbsp;<i class="fa fa-trash"></i></a>
													</div>
												</div>
											@endforeach
											</div>
											@else
											@php $count = count($schedule['schedule_time']);@endphp
											<div class="form-group hidden" id="header_child_{{$key}}">
												<div class="col-md-3"></div>
												<div class="col-md-3">Session Start</div>
												<div class="col-md-3">Session End</div>
											</div>
											<input type="hidden" id="count_array_time_{{$key}}" value="{{$count}}">
											<div id="div_shift_child_{{$key}}"></div>
											@endif
										</div>
									<div>
								</div>
							</div>
							@endforeach
							@else
							<div class="form-body">
								<div class="form-group">
									<div class="col-md-1">
										<a class="btn btn-primary" onclick="addSchedule()">&nbsp;<i class="fa fa-plus-circle"></i> Add Schedule </a>
									</div>
								</div>
								<div id="div_schedule_parent">
									<div class="form-group" id="div_schedule_child_0">
										<div class="col-md-1" style="text-align: right">
											<a class="btn btn-danger" onclick="deleteChildSchedule(0)">&nbsp;<i class="fa fa-trash"></i></a>
										</div>
										<label for="multiple" class="control-label col-md-2">Hari <span class="required" aria-required="true"> * </span>
											<i class="fa fa-question-circle tooltips" data-original-title="Aktifkan Jadwal dan Tambahkan Sesi konsultasi" data-container="body"></i>
										</label>
										<div class="col-md-3">
											<select class="form-control select" id="office_hour_type[0]" name="schedules[0][day]" onchange="changeType(this.value)" required>
												<option></option>
												<option value="monday">Senin</option>
												<option value="tuesday">Selasa</option>
												<option value="wednesday">Rabu</option>
												<option value="thursday">Kamis</option>
												<option value="friday">Jumat</option>
												<option value="saturday">Sabtu</option>
												<option value="sunday">Minggu</option>
											</select>
										</div>
										<input type="hidden" name="schedules[0][is_active]" value="1">
										<div id="use_shift_0">
											<div class="form-group">
												<div class="col-md-3"></div>
												<div class="col-md-4">
													<a class="btn btn-primary" onclick="addShift(0)">&nbsp;<i class="fa fa-plus-circle"></i> Add Session </a>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-3"></div>
												<div class="col-md-3">Session Start</div>
												<div class="col-md-3">Session End</div>
											</div>
											<div id="div_shift_child_0">
												<div class="form-group" id="div_shift_child_0_0">
													<div class="col-md-3"></div>
													<div class="col-md-3">
														<input type="text" style="background-color: white" data-placeholder="select time" id="time_start_0"  name="schedules[0][session_time][0][start_time]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>
													</div>
													<div class="col-md-3">
														<input type="text" style="background-color: white" data-placeholder="select time" id="time_end_0" name="schedules[0][session_time][0][end_time]" class="form-control mt-repeater-input-inline timepicker timepicker-no-seconds" data-show-meridian="false" value="00:00" readonly>
													</div>
													<div class="col-md-3">
														<a class="btn btn-danger" onclick="deleteChild(0, 0)">&nbsp;<i class="fa fa-trash"></i></a>
													</div>
												</div>
											</div>
										<div>
									</div>
								</div>
							</div>
							@endif
						</form>
					</div>
					<div class="form-actions" style="text-align: center">
							<button class="btn blue">Submit</button>
						</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection