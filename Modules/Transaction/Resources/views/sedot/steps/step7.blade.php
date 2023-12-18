<br>
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/step')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Pembayaran Sedot Wc</h3></div>
                        <br>
                        
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					Menunggu pembayaran dari Customer
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step6']['name']??null}}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step6']['description']??null}}
				</div>
			</div>
                        @if(isset($detail['step']['step6']['procesed_by']))
			<div class="form-group">
				<label class="col-md-2 control-label"> 
				</label>
				<div class="col-md-10">
					Processed By : {{$detail['step']['step6']['procesed_by']??null}}
				</div>
			</div>
                        @endif
			
		</div>
		
</form>
</div>