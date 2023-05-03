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
    			console.log(1); 	
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

    <div class="tab-pane" id="user-profile">
		<div class="row" style="margin-top:20px">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption font-blue ">
							<i class="icon-settings font-blue "></i>
							<span class="caption-subject bold uppercase">{{ $sub_title ?? 'Confirmation Messages'}}</span>
						</div>
					</div>
					<div class="portlet-body">

						<form role="form" class="form-horizontal" action="{{url()->current()}}" method="POST">
							@foreach ($messages as $key => $message)
								<div class="form-group col-md-12">
									<label class="control-label col-md-4">{{ $message['label'] }}
										<span class="required" aria-required="true"> * </span>
										<i class="fa fa-question-circle tooltips" data-original-title="{{ $message['tooltip'] }}" data-container="body"></i>
									</label>
									<div class="fileinput fileinput-new col-md-8">
										<input class="form-control" type="text" id="{{ $key }}" name="{{ $key }}" value="{{ old($key) ?? $message['value'] ?? null }}" required><br/>
										@foreach ($message['text_replaces'] ?? [] as $text)
											<div class="row appender" data-target="#{{ $key }}">
												<div class="col-md-3" style="margin-bottom:5px;">
													<span class="btn dark btn-xs btn-block btn-outline var appender-btn" data-toggle="tooltip" data-value="{{ $text }}">{{ $text }}</span>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							@endforeach
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