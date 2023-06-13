@if(isset($detail['step']['step1']))
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/step1/'.$detail['step']['step1']['id'])}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Konfirmasi Sedot WC</h3></div>
                        <br>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step1']['name']??null}}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step1']['description']??null}}
				</div>
			</div>
                        @if($detail['transaction_status_code']!=3)
			<div class="form-group">
				<label class="col-md-2 control-label"> 
				</label>
				<div class="col-md-10">
					Processed By : {{$detail['step']['step1']['procesed_by']??null}}
				</div>
			</div>
                        @endif
			
		</div>
		@if($detail['transaction_status_code']==4&&$detail['step_number']==1)
		<div class="row" style="text-align: center">
			{{ csrf_field() }}
			<button type='submit' class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>
@endif