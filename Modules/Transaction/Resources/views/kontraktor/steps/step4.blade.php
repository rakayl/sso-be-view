<br>
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/kontraktor/step')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Vendor Survey</h3></div>
                        <br>
                        
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					Mitra melakukan survey lokasi
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step4']['name']??null}}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step4']['description']??null}}
				</div>
			</div>
                        @if(isset($detail['step']['step4']['procesed_by']))
			<div class="form-group">
				<label class="col-md-2 control-label"> 
				</label>
				<div class="col-md-10">
					Processed By : {{$detail['step']['step4']['procesed_by']??null}}
				</div>
			</div>
                        @endif
			
		</div>
		@if($detail['transaction_status_code']==5&&$detail['step_number']==3)
		<div class="row" style="text-align: center">
                    <input type="hidden" name="step_number" value="4">
            <input type="hidden" name="id_transaction" value="{{$detail['id_transaction']}}">
			{{ csrf_field() }}
			<button type='submit' class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>