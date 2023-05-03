@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
	 <link href="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
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
			<span class="caption-subject font-blue sbold uppercase">Email Settings</span>
		</div>
	</div>
	<div class="portlet-body form">
		<form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
			<div class="form-body">
				<h4>Head</h4>
				<div class="form-group">
					<div class="input-icon right">
						<label class="col-md-3 control-label">
						From
						<i class="fa fa-question-circle tooltips" data-original-title="nama pengirim email" data-container="body"></i>
						</label>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email_from" value="@if(isset($settings['email_from'])){{$settings['email_from']}}@endif">
					</div>
				</div>
				<div class="form-group">
					<div class="input-icon right">
						<label class="col-md-3 control-label">
						Sender
						<i class="fa fa-question-circle tooltips" data-original-title="alamat email pengirim" data-container="body"></i>
						</label>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email_sender" value="@if(isset($settings['email_sender'])){{$settings['email_sender'] }}@endif">
					</div>
				</div>
				<div class="form-group">
					<div class="input-icon right">
						<label class="col-md-3 control-label">
						Reply To
						<i class="fa fa-question-circle tooltips" data-original-title="alamat email penerima" data-container="body"></i>
						</label>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email_reply_to" value="@if(isset($settings['email_reply_to'])){{$settings['email_reply_to'] }}@endif">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">CC</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email_cc" value="@if(isset($settings['email_cc'])){{$settings['email_cc']}}@endif">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">BCC</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email_bcc" value="@if(isset($settings['email_bcc'])){{$settings['email_bcc']}}@endif">
					</div>
				</div>
				<h4>Email Header</h4>
				 <div class="form-group">
                        <label class="col-md-3 control-label">Logo <span class="required" aria-required="true"> * </span>
                        <br>
                        <span class="required" aria-required="true"></span>
                        </label>
                        <div class="col-md-9">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px;">
								@if(isset($settings['email_logo']))
								  	<img src="{{ env('STORAGE_URL_API').$settings['email_logo'] }}" alt="Image Logo">
								@else
									<img src="https://www.placehold.it/500x500/EFEFEF/AAAAAA&amp;text=no+image" alt="">
								@endif
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                <div>
                                    <span class="btn default btn-file">
                                    <span class="fileinput-new"> Select image </span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" accept="image/*" name="email_logo">

                                    </span>

                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>
                    </div>

				<div class="form-group">
					<label class="col-md-3 control-label">Position</label>
					<div class="col-md-9">
						<select class="form-control" name="email_logo_position">
							<option value="left" @if(isset($settings['email_logo_position'])) @if($settings['email_logo_position'] == 'left') selected @endif @endif>Left</option>
							<option value="center" @if(isset($settings['email_logo_position'])) @if($settings['email_logo_position'] == 'center') selected @endif @endif>Center</option>
							<option value="right" @if(isset($settings['email_logo_position'])) @if($settings['email_logo_position'] == 'right') selected @endif @endif>Right</option>
						</select>
					</div>
				</div>

				<h4>Email Footer</h4>

				<div class="form-group">
					<label class="col-md-3 control-label">Copyright</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email_copyright" value="@if(isset($settings['email_copyright'])){{$settings['email_copyright']}}@endif">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Disclaimer</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email_disclaimer" value="@if(isset($settings['email_disclaimer'])){{$settings['email_disclaimer']}}@endif">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Contact</label>
					<div class="col-md-9">
						<input type="text" class="form-control" name="email_contact" value="@if(isset($settings['email_contact'])){{$settings['email_contact']}}@endif">
					</div>
				</div>
			</div>
			<div class="form-actions">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-offset-5 col-md-4">
						<button type="submit" class="btn green">Submit</button>
						<!-- <button type="button" class="btn default">Cancel</button> -->
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection