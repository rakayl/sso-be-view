@extends('layouts.main')

@section('page-script')
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('.appender').on('click','.appender-btn',function(){
    			var value=$(this).data('value');
    			var target=$(this).parents('.appender').data('target');
    			var newValue=$(target).val()+" "+value;
    			$(target).val(newValue);
    			$(target).focus();
    		});
    	});
    </script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Confirmation Messages</a>
		</li>
	</ul>
</div>
<br>

@include('layouts.notifications')

    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">Share Promo Campaign Message</span>
						</div>
					</div>
					<div class="portlet-body">

						<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">Text Message
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="Teks yang akan tampil saat akan membagikan kode promo" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" id="share_promo_code" name="share_promo_code" value="{{ old('share_promo_code',$msg['share_promo_code']??'') }}" required><br/>
										<div class="row appender" data-target="#share_promo_code">
											<div class="col-md-3" style="margin-bottom:5px;">
												<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" title="Text will be replace '%promo_code%' with deals name" data-value="%promo_code%">%promo_code%</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions" style="text-align:center">
								{{ csrf_field() }}
								<button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>

@endsection