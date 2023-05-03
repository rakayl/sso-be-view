<script>
	function changeSelect(){
        setTimeout(function(){
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
	}
	function changeSubject(val){
		var subject = val;
		var temp1 = subject.replace("conditions[", "");
		var index = temp1.replace("][subject]", "");
		var subject_value = document.getElementsByName(val)[0].value;

		if(subject_value == 'doctor' || subject_value == 'name' || subject_value == 'phone' || subject_value == 'email' || subject_value == 'product_name' || subject_value == 'product_code' || subject_value == 'product_category'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
		}
		
		if(subject_value == 'product_weight' || subject_value == 'product_price' || subject_value == 'product_tax' || subject_value == 'date'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('>=', '>=');
			operator_value.options[operator_value.options.length] = new Option('>', '>');
			operator_value.options[operator_value.options.length] = new Option('<=', '<=');
			operator_value.options[operator_value.options.length] = new Option('<', '<');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'date';
		}
		
		if(subject_value == 'courier'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('psc', 'psc');
			operator_value.options[operator_value.options.length] = new Option('jne', 'jne');
			operator_value.options[operator_value.options.length] = new Option('pos', 'pos');
			operator_value.options[operator_value.options.length] = new Option('tiki', 'tiki');
			operator_value.options[operator_value.options.length] = new Option('pcp', 'pcp');
			operator_value.options[operator_value.options.length] = new Option('esl', 'esl');
			operator_value.options[operator_value.options.length] = new Option('rpx', 'rpx');
			operator_value.options[operator_value.options.length] = new Option('pandu', 'pandu');
			operator_value.options[operator_value.options.length] = new Option('wahana', 'wahana');
			operator_value.options[operator_value.options.length] = new Option('sicepat', 'sicepat');
			operator_value.options[operator_value.options.length] = new Option('jnt', 'jnt');
			operator_value.options[operator_value.options.length] = new Option('pahala', 'pahala');
			operator_value.options[operator_value.options.length] = new Option('cahaya', 'cahaya');
			operator_value.options[operator_value.options.length] = new Option('sap', 'sap');
			operator_value.options[operator_value.options.length] = new Option('jet', 'jet');
			operator_value.options[operator_value.options.length] = new Option('indah', 'indah');
			operator_value.options[operator_value.options.length] = new Option('slis', 'slis');
			operator_value.options[operator_value.options.length] = new Option('dse', 'dse');
			operator_value.options[operator_value.options.length] = new Option('first', 'first');
			operator_value.options[operator_value.options.length] = new Option('ncs', 'ncs');
			operator_value.options[operator_value.options.length] = new Option('star', 'star');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}
		
		if(subject_value == 'gender'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Male', 'Male');
			operator_value.options[operator_value.options.length] = new Option('Female', 'Female');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}
		
		if(subject_value == 'status'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Success', 'Success');
			operator_value.options[operator_value.options.length] = new Option('Settlement', 'Settlement');
			operator_value.options[operator_value.options.length] = new Option('Pending', 'Pending');
			operator_value.options[operator_value.options.length] = new Option('Cancel', 'Cancel');
			operator_value.options[operator_value.options.length] = new Option('Expired', 'Expired');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}
	}

</script>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Consultation Search</span>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="form-group mt-repeater">
				<div data-repeater-list="conditions">
					@if (!empty($conditions))
						@foreach ($conditions as $key => $con)
							<div data-repeater-item class="mt-repeater-item mt-overflow">
								<div class="mt-repeater-cell">
									<div class="col-md-12">
										<div class="col-md-1">
											<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
												<i class="fa fa-close"></i>
											</a>
										</div>
										<div class="col-md-4">
											<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
												<option value="name"  @if ($con['subject'] == 'name') selected @endif>Customer Name</option>
												<option value="date" @if ($con['subject'] == 'date') selected @endif>Date</option>
												<option value="doctor" @if ($con['subject'] == 'doctor') selected @endif>Doctor</option>
											</select>
										</div>
										<div class="col-md-4">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
											@if ($con['subject'] == 'date')
												<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
												<option value=">" @if ($con['operator'] == '>') selected @endif>></option>
												<option value=">=" @if ($con['operator'] == '>=') selected @endif>>=</option>
												<option value="<" @if ($con['operator'] == '<') selected @endif><</option>
												<option value="<=" @if ($con['operator'] == '<=') selected @endif><=</option>
											@else
												<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
												<option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
											@endif
										</select>
										</div>
										@if ($con['subject'] == 'date' )
											<div class="col-md-3">
												<input type="date" placeholder="Parameter" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
											</div>
										@else
											<div class="col-md-3">
												<input type="text" placeholder="Parameter" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
											</div>
										@endif
									</div>
								</div>
							</div>
						@endforeach
					@else
						<div data-repeater-item class="mt-repeater-item mt-overflow">
							<div class="mt-repeater-cell">
								<div class="col-md-12">
									<div class="col-md-1">
										<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
											<i class="fa fa-close"></i>
										</a>
									</div>
									<div class="col-md-4">
										<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
											<option value="name">Customer Name</option>
											<option value="doctor">Doctor Name</option>
											<option value="date">Date</option>
										</select>
									</div>
									<div class="col-md-4">
									<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
										<option value="=" selected>=</option>ororororor
										<option value="like">Like</option>
									</select>
									</div>
									<div class="col-md-3">
									<input type="text" placeholder="Parameter" class="form-control" name="parameter" required />
									</div>
									
								</div>
							</div>
						</div>
					@endif
				</div>
				<div class="form-action col-md-12">
					<div class="col-md-12">
						<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add" onClick="changeSelect();">
						<i class="fa fa-plus"></i> Add New Condition</a>
					</div>
				</div>
				
				<div class="form-action col-md-12" style="margin-top:15px">
					<div class="col-md-5">
						<select name="rule" class="form-control input-sm " placeholder="Search Rule" required>
							<option value="and" @if (isset($rule) && $rule == 'and') selected @endif>Valid when all conditions are met</option>
							<option value="or" @if (isset($rule) && $rule == 'or') selected @endif>Valid when minimum one condition is met</option>
						</select>
					</div>
					<div class="col-md-4">
						{{ csrf_field() }}
						 <button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>