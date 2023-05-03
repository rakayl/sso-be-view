<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');

?>
@extends('layouts.main')

@section('page-style')
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
<style>
	.switcher{
		position: relative;
		overflow: auto;
		overflow-x: hidden;
		min-height: 1500px;
		white-space: nowrap;
	}
	.switcher .switcher-item{
		position: absolute;
		display: inline-block;
		width: 100%;
		padding: 0, 5px;
		transition-duration: .5s;
	}
	.switcher .switcher-item.active{
		left: 0;
	}
	.switcher .switcher-item{
		left: 100%;
	}
	.switcher .switcher-item.prev{
		left: -100%;
	}
	#upload-loading{
		display: none;
	}
	.uploading #upload-loading{
		display: block;
	}
	.uploading #upload-form{
		display: none;
	}
	.if-success,.if-fail{
		display: none;
	}
	.upload-success .if-success{
		display: block;
	}
	.upload-fail .if-fail{
		display: block;
	}
</style>
@endsection

@section('page-script')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	function updateStep(){
		const current_step = $('.switcher').data('current-step')?$('.switcher').data('current-step'):"1";
		const childs = $('.switcher').children();
		childs.removeClass('active');
		childs.removeClass('prev');
		for(let i = 0;  i < childs.length; i++){
			const step = $(childs[i]);
			if(step.data('step') === current_step){
				step.addClass('active');
			}else if(step.data('step') <= current_step){
				step.addClass('prev');
			}
		}

		const childs2 = $('.step-line').children();
		childs2.removeClass('done');
		childs2.removeClass('active');
		for(let i = 0;  i < childs2.length; i++){
			const step = $(childs2[i]);
			if(step.data('step') === current_step){
				step.addClass('active');
			}else if(step.data('step') <= current_step){
				step.addClass('done');
			}
		}
	}
	$(document).ready(function() {
		//INITIALIZATION
		updateStep();
		//EVENT LISTENER
		$('.btn-wizard').on('click',function(event){
			if($($(this).data('target-form')).length && !$($(this).data('target-form'))[0].reportValidity()){
				event.preventDefault();
			}else{
				$('.switcher').data('current-step',$(this).data('target-step'));
				updateStep();				
			}
		});

		$("#form-upload").on('submit', function(e){
			e.preventDefault();
			const container = $(this).parents('.upload-container');
			container.addClass('uploading');
			$.ajax({
				xhr: function() {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = ((evt.loaded / evt.total) * 100);
							$(".progress-bar").width(percentComplete + '%');
							$(".progress-bar").html(Math.round(percentComplete)+'%');
						}
					}, false);
					return xhr;
				},
				type: 'POST',
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					$(".progress-bar").width('0%');
				},
				error:function(){
					$('.step3').addClass('upload-fail');
					$('.step3').removeClass('upload-success');
					$('#result-list').html('<li>Check your internet connection</li>');
				},
				success: function(resp){
					let msg = '';
					if(resp.status == 'success'){
						$('.step3').addClass('upload-success');
						$('.step3').removeClass('upload-fail');
						$('#result-list').html('<li>Check your internet connection</li>');
						if(resp.result){
							if(resp.result.length > 1){
								resp.result.forEach(message => {
									msg+=`<li>${message}</li>`;
								});
							}else{
								msg = resp.result[0];
							}
						}else{
							msg = '<li>Success import product</li>';
						}
					}else{
						$('.step3').addClass('upload-fail');
						$('.step3').removeClass('upload-success');
						if(resp.messages){
							if(resp.messages.length > 1){
								resp.messages.forEach(message => {
									msg+=`<li>${message}</li>`;
								});
							}else{
								msg = resp.messages[0];
							}
						}else{
							msg = '<li>Check your internet connection</li>';
						}
					}
					$('#result-list').html(msg);
				}
			}).always(function(){
				$('.switcher').data('current-step',3);
				updateStep();
				container.removeClass('uploading');
				$('#form-upload')[0].reset();
				$(".progress-bar").width('0%');
			});
		});
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
<div class="row">
	<div class="col-md-12">
		<div class="mt-element-step">
			<div class="row step-line">
				<div class="col-md-4 mt-step-col first active" data-step="1">
					<div class="mt-step-number bg-white">1</div>
					<div class="mt-step-title uppercase font-grey-cascade">Download Template User Mitra</div>
					<div class="mt-step-content font-grey-cascade">Download current user mitra</div>
				</div>
				<div class="col-md-4 mt-step-col" data-step="2">
					<div class="mt-step-number bg-white">2</div>
					<div class="mt-step-title uppercase font-grey-cascade">Upload Data User Mitra</div>
					<div class="mt-step-content font-grey-cascade">Import from modifie user mitra list</div>
				</div>
				<div class="col-md-4 mt-step-col last" data-step="3">
					<div class="mt-step-number bg-white">#</div>
					<div class="mt-step-title uppercase font-grey-cascade">Result User Mitra</div>
					<div class="mt-step-content font-grey-cascade">Report imported user mitra</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="switcher" data-current-step="-1">
	<div class="switcher-item" data-step="-1">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-dark sbold uppercase font-green">About {{$sub_title}}</span>
				</div>
			</div>
			<div class="portlet-body form">
				<div class="m-heading-1 border-green m-bordered">
					<p style="white-space: pre-wrap;">Menu ini digunakan untuk melakukan impor atau ekspor data user mitra.</p>
					<p style="white-space: pre-wrap;">User diidentifikasi berdasarkan <b>username</b>. Apabila username tidak tersedia maka data tersebut akan <b>ditambahkan otomatis</b>.</p>
					<br>
					<p style="white-space: pre-wrap;">Silahkan klik <span class="badge">Start</span> untuk memulai impor/ekspor user mitra</p>
				</div>
				<div class="form-actions" style="padding-bottom: 5px">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-offset-4 col-md-4 text-center">
							<button type="button" data-target-step="1"  class="btn green btn-wizard">Start <i class="fa fa-arrow-right"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="switcher-item" data-step="1">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-dark sbold uppercase font-green">Download Template </span>
				</div>
			</div>
			<div class="portlet-body form">
				<form class="form-horizontal" role="form" action="{{ url('user/user-franchise/export') }}" method="post">
					<div class="form-body">
						<div class="form-group text-center">
							<div class="col-md-offset-4 col-md-4">
								<button class="btn blue btn-block text-center">Download</button>
							</div>
						</div>
					</div>
					<div class="form-actions" style="padding-bottom: 5px">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-4 col-md-4 text-center">
								<button type="button" class="btn yellow btn-wizard" data-target-step="-1"><i class="fa fa-arrow-left"></i> Prev</button>
								<button type="button" class="btn green btn-wizard" data-target-step="2">Next <i class="fa fa-arrow-right"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="switcher-item" data-step="2">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-dark sbold uppercase font-green">Upload Data </span>
				</div>
			</div>
			<div class="portlet-body form upload-container">
				<div class="m-heading-1 border-green m-bordered">
					<p>Untuk user baru password akan di generate secara otomatis oleh sistem.</p>
				</div>
				<br>
				<div id="upload-form">
					<form class="form-horizontal" role="form" action="{{ url('user/user-franchise/import/save') }}" method="post" enctype="multipart/form-data" id="form-upload">
						<div class="form-body">
							<div class="form-group text-center">
								<div class="col-md-offset-3 col-md-6 text-center">
									<div class="fileinput fileinput-new text-left" data-provides="fileinput">
										<div class="input-group input-large">
											<div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
												<i class="fa fa-file fileinput-exists"></i>&nbsp;
												<span class="fileinput-filename"> </span>
											</div>
											<span class="input-group-addon btn default btn-file">
												<span class="fileinput-new"> Select file </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
											</span>
											<a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions" style="padding-bottom: 5px">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-offset-4 col-md-4 text-center">
										<button type="button" class="btn yellow btn-wizard" data-target-step="1"><i class="fa fa-arrow-left"></i> Prev</button>
										<button type="submit" class="btn green" id="import-btn"><i class="fa fa-import"></i> Import</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div id="upload-loading" style="padding: 20px 0;">
					<div class="row">
						<div class="col-md-offset-4 col-md-4">
							<div class="progress">
								<div class=" progress-bar-striped active progress-bar" role="progressbar" style="width: 0%"></div>
							</div>
							<div class="text-center">Uploading...</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="switcher-item" data-step="3">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<span class="caption-subject font-dark sbold uppercase font-green">Import Result </span>
				</div>
			</div>
			<div class="portlet-body step3 form">
				<form class="form-horizontal" role="form" action="{{ url('user/user-franchise/export') }}" method="post">
					<div class="row">
						<div class="col-md-offset-3 col-md-6">
							<div class="text-center if-success">
								<span class="text-center text-success" style="font-size: 90px">
									<i class="fa fa-check-circle"></i>
								</span>
							</div>
							<div class="text-center if-fail">
								<span class="text-center text-danger" style="font-size: 90px">
									<i class="fa fa-times-circle"></i>
								</span>
							</div>
							<ul class="text-center" id="result-list" style="padding: 0">
							</ul>
						</div>
					</div>
					<div class="form-actions" style="padding-bottom: 5px">
						{{ csrf_field() }}
						<div class="row">
							<div class="col-md-offset-4 col-md-4 text-center">
								<button type="button" class="btn yellow btn-wizard" data-target-step="1"><i class="fa fa-arrow-left"></i> Upload Again</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection