<br>
<div style="margin-top: -4%">
	<form class="form-horizontal" id="form_interview" role="form" action="{{url('transaction/detail/step')}}" method="post" enctype="multipart/form-data">
		<div class="form-body">
			<div style="text-align: center"><h3>Pemilihan Vendor</h3></div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Vendor <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
                                    <select @if($detail['transaction_status_code']==4&&$detail['step_number']!=1) disabled @endif name="id_outlet" class="form-control input-sm select2" placeholder="Search vendor" data-placeholder="Choose Vendor" required>
                                            <option value="">Select...</option>
                                            @if(isset($outlet))
                                                    @foreach($outlet as $row)
                                                            <option value="{{$row['id_outlet']}}" @if($detail['id_outlet']) selected @endif >{{$row['outlet_code']}}-{{$row['outlet_name']}}</option>
                                                    @endforeach
                                            @endif
                                    </select>
                                </div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Date <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6">
                                    <input  @if($detail['transaction_status_code']==4&&$detail['step_number']!=1) disabled @endif type="datetime-local" class="form-control form-filter input-sm datetimepicker" name="time_confirm" placeholder="From" @if($detail['step_number']==1) value="{{date('Y-m-d H:i',strtotime($detail['trasaction_sedot_wc']['time']??date('Y-m-d H:i')))}}" @else value="{{date('Y-m-d H:i',strtotime($detail['trasaction_sedot_wc']['time_confirm']??date('Y-m-d H:i')))}}" @endif  min="{{date('Y-m-d H:i')}}" data-date-format="yyyy-mm-dd hh:ii">
                                </div>
			</div>
                        @if(isset($detail['step']['step1']['procesed_by']))
			<div class="form-group">
				<label class="col-md-4 control-label" >Processed By  <span class="required" aria-required="true"> * </span>
				</label>
				<div class="col-md-6 ">
                                    <input  @if($detail['transaction_status_code']==4&&$detail['step_number']!=1) disabled @endif class="form-control" value="{{$detail['step']['step1']['procesed_by']}}" >
                                </div>
			</div>
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
                        @endif
		</div>
            @if($detail['transaction_status_code']==3&&$detail['step_number']==0)
            <input type="hidden" name="step_number" value="1">
            <input type="hidden" name="id_transaction" value="{{$detail['id_transaction']}}">
                <div class="row" style="text-align: center">
			{{ csrf_field() }}
			<button type='submit' class="btn blue">Submit</button>
		</div>
		@endif
</form>
</div>