@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        function cekRequired() {
            var reply = $('#reply').val();
            var reply_name   = $('#reply_name').val();
            var cc = $('#cc').val();
            var cc_name   = $('#cc_name').val();
            var bcc = $('#bcc').val();
            var bcc_name   = $('#bcc_name').val();

            if (reply != "" && reply_name == "") {
                $('#reply_name').attr('required');
                $('#reply').removeAttr('required');
                $('#reply_name').focus();

                return false;
            }

            if (reply == "" && reply_name != "") {
                $('#reply').attr('required');
                $('#reply_name').removeAttr('required');
                $('#reply').focus();

                return false;
            }

            if (cc != "" && cc_name == "") {
                $('#cc_name').attr('required');
                $('#cc').removeAttr('required');
                $('#cc_name').focus();

                return false;
            }

            if (cc == "" && cc_name != "") {
                $('#cc').attr('required');
                $('#cc_name').removeAttr('required');
                $('#cc').focus();

                return false;
            }

            if (bcc != "" && bcc_name == "") {
                $('#bcc_name').attr('required');
                $('#bcc').removeAttr('required');
                $('#bcc_name').focus();

                return false;
            }

            if (bcc == "" && bcc_name != "") {
                $('#bcc').attr('required');
                $('#bcc_name').removeAttr('required');
                $('#bcc').focus();

                return false;
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
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-dark sbold uppercase">Setting Email</span>
		</div>
	</div>
	<div class="portlet-body form">
        <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data" onsubmit="return cekRequired();" >
            <div class="form-body">
                    <h4 style="text-align:center">Preview Email</h4>
                    <br>
                    <div class="form-group">
                        <label class="col-md-1 control-label"></label>
                        <div class="col-md-10">
                            @include('emails.preview')
                        </div>
                    </div>
                <br>
                <h4 style="text-align:center">Setting Mail Variable</h4>
                <br>
                <div class="form-group">
                    <label class="col-md-3 control-label">From <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-9">
                        <input type="email" class="form-control" name="email_from" value="@if(isset($setting)) {{ $setting['email_from'] }} @endif" placeholder="Email From" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Sender <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="email_sender" value="@if(isset($setting) && $setting['email_sender'] != null){{ $setting['email_sender'] }} @endif" placeholder="Sender" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Reply To Email</label>
                    <div class="col-md-9">
                        <input id="reply" type="email" class="form-control" name="email_reply_to" value="@if(isset($setting)){{ $setting['email_reply_to'] }} @endif" placeholder="Reply To Email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Reply To Name</label>
                    <div class="col-md-9">
                        <input id="reply_name" type="text" class="form-control" name="email_reply_to_name" value="@if(isset($setting) && !empty($setting['email_reply_to_name'])) {{ $setting['email_reply_to_name'] }} @endif" placeholder="Reply To Name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">CC Email</label>
                    <div class="col-md-9">
                        <input id="cc" type="email" class="form-control" name="email_cc" value="@if(isset($setting)){{ $setting['email_cc'] }} @endif" placeholder="CC">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">CC Name</label>
                    <div class="col-md-9">
                        <input id="cc_name" type="text" class="form-control" name="email_cc_name" value="@if(isset($setting) && !empty($setting['email_cc_name'])) {{ $setting['email_cc_name'] }} @endif" placeholder="CC Name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">BCC Email</label>
                    <div class="col-md-9">
                        <input id="bcc" type="email" class="form-control" name="email_bcc" value="@if(isset($setting)) {{ $setting['email_bcc'] }} @endif" placeholder="BCC">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">BCC Name</label>
                    <div class="col-md-9">
                        <input id="bcc_name" type="text" class="form-control" name="email_bcc_name" value="@if(isset($setting) && !empty($setting['email_bcc_name'])) {{ $setting['email_bcc_name'] }} @endif" placeholder="BCC Name">
                    </div>
                </div>

                <br>
                <h4 style="text-align:center">Setting Header</h4>
                <br>

                <div class="form-group">
                    <label class="col-md-3 control-label">Logo <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-9">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
								@if(isset($setting) && $setting['email_logo'] != null)
                                <img src="{{ env('STORAGE_URL_API')}}{{$setting['email_logo']}}" id="" />
								@else
								<img src="https://vignette.wikia.nocookie.net/simpsons/images/6/60/No_Image_Available.png/revision/latest?cb=20170219125728" id="autocrm_push_image" />
								@endif
							</div>

							<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
							<div>
								<span class="btn default btn-file">
									<span class="fileinput-new"> Select image </span>
									<span class="fileinput-exists"> Change </span>
									<input type="file"  accept="image/*" name="email_logo"> </span>
								<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
							</div>
						</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Header Logo Position <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-9">
                        <select name="email_logo_position" class="form-control" placeholder="" required>
                            <option value="" selected hidden>Select Header Logo Position</option>
                            <option @if(isset($setting)) @if($setting['email_logo_position'] == 'left') selected @endif @endif value="left">Left</option>
                            <option @if(isset($setting)) @if($setting['email_logo_position'] == 'center') selected @endif @endif value="center">Center</option>
                            <option @if(isset($setting)) @if($setting['email_logo_position'] == 'right') selected @endif @endif value="right">Right</option>
                        </select>
                    </div>
                </div>

                <br>
                <h4 style="text-align:center">Setting Footer</h4>
                <br>

                <div class="form-group">
                    <label class="col-md-3 control-label">Footer Copyright <span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="email_copyright" value="@if(isset($setting) &&  $setting['email_copyright'] !=null) {{ $setting['email_copyright'] }} @endif" placeholder="Copyright">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Footer Contact</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="email_contact" value="@if(isset($setting) && $setting['email_contact'] != null) {{ $setting['email_contact'] }} @endif" placeholder="Contact">
                    </div>
                </div>

            </div>
            <div class="form-actions">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green">Submit</button>
                        <button type="button" class="btn default">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
	</div>
</div>
@endsection
