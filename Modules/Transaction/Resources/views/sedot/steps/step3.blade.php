<br>
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/step')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Survey Lokasi</h3></div>
                        <br>
                        
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					Proses survey lokasi dilakukan oleh Mitra, Superadmin maupun Pemda yang terkait dengan transaksi ini
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step3']['name']??null}}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step3']['description']??null}}
				</div>
			</div>
                        @if(isset($detail['step']['step3']['procesed_by']))
			<div class="form-group">
				<label class="col-md-2 control-label"> 
				</label>
				<div class="col-md-10">
					Processed By : {{$detail['step']['step3']['procesed_by']??null}}
				</div>
			</div>
                        @endif
			
		</div>
		@if($detail['transaction_status_code']==4&&$detail['step_number']==2)
		<div class="row" style="text-align: center">
                    <input type="hidden" name="step_number" value="3">
            <input type="hidden" name="id_transaction" value="{{$detail['id_transaction']}}">
			{{ csrf_field() }}
			<button type='submit' class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>