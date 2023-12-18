<br>
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/step')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Perhitungan Biaya</h3></div>
			<div class="form-group">
				<label class="col-md-4 control-label">Jumlah volume sedot wc <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
                                        <div class="input-group">
                                             <input class="form-control" type="number" name="volume_sedot_wc" value="{{$detail['trasaction_sedot_wc']['volume_sedot_wc']??0}}" required>
                                             <span class="input-group-addon">Liter</span>
                                        </div>
                                </div>
			</div>
                        @if(isset($detail['step']['step5']['procesed_by']))
			<div class="form-group">
				<label class="col-md-4 control-label" >Processed By  <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6 ">
                                    <input  @if($detail['transaction_status_code']==4&&$detail['step_number']!=1) disabled @endif class="form-control" value="{{$detail['step']['step5']['procesed_by']}}" >
                                </div>
			</div>
                        <div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step5']['name']??null}}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step5']['description']??null}}
				</div>
			</div>
                        @endif
		</div>
            @if($detail['transaction_status_code']==4&&$detail['step_number']==4)
            <input type="hidden" name="step_number" value="5">
            <input type="hidden" name="id_transaction" value="{{$detail['id_transaction']}}">
                <div class="row" style="text-align: center">
			{{ csrf_field() }}
			<button type='submit' class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>