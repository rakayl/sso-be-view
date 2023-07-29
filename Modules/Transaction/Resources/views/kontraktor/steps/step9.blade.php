<br>
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/kontraktor/step')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Konfirmasi Customer</h3></div>
                        <br>
                        
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					Proses Konfirmasi dilakukan oleh Customer untuk menyelesai transaksi
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step9']['name']??null}}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step9']['description']??null}}
				</div>
			</div>
                        @if(isset($detail['step']['step9']['procesed_by']))
			<div class="form-group">
				<label class="col-md-2 control-label"> 
				</label>
				<div class="col-md-10">
					Processed By : {{$detail['step']['step9']['procesed_by']??null}}
				</div>
			</div>
                        @endif
			
		</div>
		@if($detail['transaction_status_code']==5&&$detail['step_number']==8)
		<div class="row" style="text-align: center">
                    <input type="hidden" name="step_number" value="9">
            <input type="hidden" name="id_transaction" value="{{$detail['id_transaction']}}">
			{{ csrf_field() }}
			<button type='submit' class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>