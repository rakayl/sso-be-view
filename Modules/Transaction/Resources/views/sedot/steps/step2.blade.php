<br>
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/step')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Konfirmasi Vendor</h3></div>
                        <br>
                        
			<div class="form-group">
				<label class="col-md-4 control-label">Vendor <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
                                    <select @if($detail['transaction_status_code']==4&&$detail['step_number']!=1) disabled @endif name="id_accommodation" class="form-control input-sm select2" placeholder="Search vendor" data-placeholder="Choose Armada" required>
                                            <option value="">Select...</option>
                                            @if(isset($armada))
                                                    @foreach($armada as $row)
                                                            <option value="{{$row['id_accommodation']}}" @if($detail['trasaction_sedot_wc']['id_accommodation']) selected @endif >{{$row['name']}}-{{$row['number_accommodation']}}-{{$row['merk']}} {{$row['type']}}</option>
                                                    @endforeach
                                            @endif
                                    </select>
                                </div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step2']['name']??null}}
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">
				</label>
				<div class="col-md-10">
					{{$detail['step']['step2']['description']??null}}
				</div>
			</div>
                        @if(isset($detail['step']['step2']['procesed_by']))
			<div class="form-group">
				<label class="col-md-2 control-label"> 
				</label>
				<div class="col-md-10">
					Processed By : {{$detail['step']['step2']['procesed_by']??null}}
				</div>
			</div>
                        @endif
			
		</div>
		@if($detail['transaction_status_code']==4&&$detail['step_number']==1)
		<div class="row" style="text-align: center">
                    <input type="hidden" name="step_number" value="2">
            <input type="hidden" name="id_transaction" value="{{$detail['id_transaction']}}">
			{{ csrf_field() }}
			<button type='submit' class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>