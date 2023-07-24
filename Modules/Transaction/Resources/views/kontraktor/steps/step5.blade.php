<br>
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/step')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>RAB</h3></div>
                        <br>
                        
			<div><h3>Material</h3></div>
                        <br>
                        
                        <br>
			<div><h3>Jasa</h3></div>
                        <br>
			
			
		</div>
		@if($detail['transaction_status_code']==5&&$detail['step_number']==4)
		<div class="row" style="text-align: center">
                    <input type="hidden" name="step_number" value="5">
            <input type="hidden" name="id_transaction" value="{{$detail['id_transaction']}}">
			{{ csrf_field() }}
			<button type='submit' class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>