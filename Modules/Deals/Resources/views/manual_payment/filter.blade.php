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

		if(subject_value == 'deals_titlte' || subject_value == 'name' || subject_value == 'phone' || subject_value == 'email' || subject_value == 'confirm_by' ){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
		}
		
		if(subject_value == 'payment_nominal' || subject_value == 'confirmed_at' || subject_value == 'cancelled_at'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('>=', '>=');
			operator_value.options[operator_value.options.length] = new Option('>', '>');
			operator_value.options[operator_value.options.length] = new Option('<=', '<=');
			operator_value.options[operator_value.options.length] = new Option('<', '<');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
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

		if(subject_value == 'confirmed_at' || subject_value == 'cancelled_at'){
			var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].value='' 
            document.getElementsByName(parameter)[0].setAttribute('class', 'form-control datepicker'+index) 
			$('.datepicker'+index).datepicker({ 
				'format' : 'd-M-yyyy', 
				'todayHighlight' : true, 
				'autoclose' : true 
			});  

		}else{
			if($('.datepicker'+index).length > 0){
				var parameter = "conditions["+index+"][parameter]";
				$('.datepicker'+index).datepicker('remove'); 
				document.getElementsByName(parameter)[0].setAttribute('class', 'form-control') 
				document.getElementsByName(parameter)[0].value='' 
			}
        }
		
	}

</script>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Filter Manual Payment List</span>
		</div>
	</div>
	<div class="portlet-body form">
		
		<div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">Date Start :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_start" value="{{$date_start}}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <label class="col-md-2 control-label">Date End :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_end" value="{{$date_end}}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div><hr>

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
											<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%" required>
												<option value="deals_title" @if ($con['subject'] == 'deals_title') selected @endif>Deals Title</option>
												<option value="payment_nominal" @if ($con['subject'] == 'payment_nominal') selected @endif>Nominal Payment</option>
												<option value="account_name" @if ($con['subject'] == 'account_name') selected @endif>Account Name</option>
												<option value="account_number" @if ($con['subject'] == 'account_number') selected @endif>Account Number</option>
												<option value="payment_method" @if ($con['subject'] == 'payment_method') selected @endif>Payment Method</option>
												<option value="bank" @if ($con['subject'] == 'bank') selected @endif>Payment Bank</option>
												<option value="confirm_by" @if ($con['subject'] == 'confirm_by') selected @endif>Confirm By</option>
												<option value="confirmed_at" @if ($con['subject'] == 'confirmed_at') selected @endif>Accept Date</option>
												<option value="cancelled_at" @if ($con['subject'] == 'cancelled_at') selected @endif>Decline Date</option>
												<option value="name"  @if ($con['subject'] == 'name') selected @endif>Customer Name</option>
												<option value="phone" @if ($con['subject'] == 'phone') selected @endif>Customer Phone</option>
												<option value="email" @if ($con['subject'] == 'email') selected @endif>Customer Email</option>
												<option value="gender" @if ($con['subject'] == 'gender') selected @endif>Customer Gender</option>
											</select>
										</div>
										<div class="col-md-3" name="divoperator" >
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%" required>
											@if ($con['subject'] == 'gender')
												<option value="Male" @if ($con['operator'] == 'Male') selected @endif>Male</option>
												<option value="Female" @if ($con['operator']  == 'Female') selected @endif>Female</option>
											@elseif ($con['subject'] == 'grand_total' || $con['subject'] == 'payment_nominal'
												|| $con['subject'] == 'confirmed_at' || $con['subject'] == 'cancelled_at')
												<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
												<option value=">" @if ($con['operator']  == '>') selected @endif>></option>
												<option value=">=" @if ($con['operator']  == '>=') selected @endif>>=</option>
												<option value="<" @if ($con['operator']  == '<') selected @endif><</option>
												<option value="<=" @if ($con['operator']  == '<=') selected @endif><=</option>
											@else
												<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
												<option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
											@endif
										</select>
										</div>

                                        <div class="col-md-4">
                                            @if ($con['subject'] == 'cancelled_at' || $con['subject'] == 'confirmed_at')
                                                <input type="text" placeholder="Keyword" class="form-control datepicker" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                            @elseif ($con['subject'] == 'gender')
                                                <input type="hidden" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                            @else
                                                <input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                            @endif
                                        </div>
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
										<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%" required>
											<option value="deals_title">Deals Title</option>
											<option value="payment_nominal">Nominal Payment</option>
											<option value="account_name">Account Name</option>
											<option value="account_number">Account Number</option>
											<option value="payment_method">Payment Method</option>
											<option value="bank">Payment Bank</option>
                                            <option value="confirm_by">Confirm By</option>
                                            <option value="confirmed_at">Accept Date</option>
                                            <option value="cancelled_at">Decline Date</option>
											<option value="name">Customer Name</option>
											<option value="phone">Customer Phone</option>
											<option value="email">Customer Email</option>
											<option value="gender">Customer Gender</option>
										</select>
									</div>
									<div class="col-md-3" name="divoperator">
									<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%" required>
										<option value="=">=</option>
										<option value="like">Like</option>
									</select>
									</div>
									<div class="col-md-4">
									<input type="text" placeholder="Keyword" class="form-control" name="parameter" required />
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