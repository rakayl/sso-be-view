<?php
	use App\Lib\MyHelper;
	$grantedFeature     = session('granted_features');
    $field = [
        'doctor_name' => 'Nama',
        'doctors_services' => 'Service',
        'practice_experience' => 'Pengalaman Praktik',
        'alumni' => 'Alumni',
        'registration_certificate_number' => 'Nomor STR'
    ];
?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
		@media (min-width: 768px) {
		  .seven-cols .col-md-1,
		  .seven-cols .col-sm-1,
		  .seven-cols .col-lg-1  {
		    width: 100%;
		    *width: 100%;
		  }
		}


		@media (min-width: 992px) {
		  .seven-cols .col-md-1,
		  .seven-cols .col-sm-1,
		  .seven-cols .col-lg-1 {
		    width: 14.2857142857%;
		    *width: 14.2857142857%;
		  }
		}


		@media (min-width: 1200px) {
		  .seven-cols .col-md-1,
		  .seven-cols .col-sm-1,
		  .seven-cols .col-lg-1 {
		    width: 14.2857142857%;
		    *width: 14.2857142857%;
		  }
		}

		.custom-date-container {
			margin: 10px;
		}

		.custom-date-box, .custom-date-box-header {
			text-align: center;
    		padding: 10px;
			border: 1px solid;
			margin-top: -1px;
    		margin-left: -1px;
		}

		.custom-date-box {
    		height: 100px;
		}

	</style>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script>
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });

        var SweetAlert = function() {
            return {
                init: function() {
                    $(".approve-update-data").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to approve this request?",
                                    text: "Your will not be able to undo this action!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, approve it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    if ($('form#form-submit')[0].checkValidity()) {
                                    	$('form#form-submit').append('<input type="hidden" name="update_type" value="approve" />');
                                        $('form#form-submit').submit();
                                    }else{
                                        swal({
                                            title: "Incompleted Data",
                                            text: "Please fill blank input",
                                            type: "warning",
                                            showCancelButton: true,
                                            showConfirmButton: false
                                        });
                                    }
                                });
                        })
                    })

                    $(".reject-update-data").each(function() {
                        var token  	= "{{ csrf_token() }}";
                        let column 	= $(this).parents('tr');
                        let name    = $(this).data('name');
                        $(this).click(function() {
                            swal({
                                    title: name+"\n\nAre you sure want to reject this request?",
                                    text: "Your will not be able to undo this action!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonClass: "btn-info",
                                    confirmButtonText: "Yes, reject it!",
                                    closeOnConfirm: false
                                },
                                function(){
                                    if ($('form#form-submit')[0].checkValidity()) {
                                    	$('form#form-submit').append('<input type="hidden" name="update_type" value="reject" />');
                                        $('form#form-submit').submit();
                                    }else{
                                        swal({
                                            title: "Incompleted Data",
                                            text: "Please fill blank input",
                                            type: "warning",
                                            showCancelButton: true,
                                            showConfirmButton: false
                                        });
                                    }
                                });
                        })
                    })
                }
            }
        }();

        jQuery(document).ready(function() {
            SweetAlert.init()
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

    <a href="{{url($url_back)}}" class="btn green" style="margin-bottom: 2%;"><i class="fa fa-arrow-left"></i> Back</a>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue">Detail {{$sub_title}}</span>
            </div>
        </div>

        <div class="portlet-body">
	        <div class="form">
	            <form class="form-horizontal" id="form-submit" role="form" action="{{url($url_back.'/update/'.$data['detail']['id_doctor_update_data'])}}" method="post">
	                <div class="form-body">
		            	@php
		            		$status = $data['detail']['approve_at'] ? 'Approved' : ($data['detail']['reject_at'] ? 'Rejected' : 'Pending');
	                		$color = ($status == 'Approved') ? '#26C281' : (($status == 'Rejected') ? '#E7505A' : '#ffc107');
	                		$textColor = ($status == 'Pending') ? '#fff' : '#fff';
	                	@endphp
		                <div class="form-group">
		                    <label class="col-md-2">Status</label>
		                    <div class="col-md-6">: 
			                    <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: {{ $color }};padding: 5px 12px;color: {{ $textColor }};">{{ $status }}</span>
			                </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">Approve By</label>
		                    <div class="col-md-6">: @if(empty($data['detail']['approve_by_name'])) - @else {{ $data['detail']['approve_by_name'] }}@endif</div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">Name</label>
		                    <div class="col-md-6">: {{ $data['detail']['doctor_name'] }}</div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">Field</label>
		                    <div class="col-md-6">: {{ $field[$data['detail']['field']]??'' }}</div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">New value</label>
		                    <div class="col-md-6">: {{ $data['detail']['new_value'] }}</div>
		                </div>
		                <div class="form-group">
		                    <label class="col-md-2">Notes</label>
		                    <div class="col-md-6">: {{ $data['detail']['notes'] }}</div>
		                </div>
	                </div>
	                {{ csrf_field() }}
	                <div class="row" style="text-align: center">
	                    @if(empty($data['detail']['approve_at']))
	                        <a class="btn green-jungle approve-update-data" data-name="{{ $data['detail']['doctor_name'] }}">Approve</a>
	                        @if(empty($data['detail']['reject_at']) && empty($data['detail']['approve_at']))
	                        	<a class="btn red reject-update-data" data-name="{{ $data['detail']['doctor_name'] }}">Reject</a>
	                        @endif
	                    @endif
	                </div>
	            </form>
	        </div>
	    </div>
    </div>

@endsection