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

		if(subject_value == 'start_status'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Started', '1');
			operator_value.options[operator_value.options.length] = new Option('Not Started', '0');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
		}else if(subject_value == 'validation_status'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Completed', '1');
			operator_value.options[operator_value.options.length] = new Option('Not Completed', '0');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
		}else if(subject_value == 'payment_gateway'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
					foreach($payment_list as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['payment_method']; ?>', '<?php echo $row['payment_method']; ?>');
					<?php
					}
					?>
                    var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
		}else{
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
		}
	}

</script>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Filter</span>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="form-group mt-repeater">
				<div data-repeater-list="conditions">
					@if (!empty($conditions))
						@foreach ($conditions as $key => $con)
							@if(isset($con['subject']))
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
													<option value="promo_payment_gateway_code" @if ($con['subject'] == 'promo_payment_gateway_code') selected @endif>ID</option>
													<option value="name" @if ($con['subject'] == 'name') selected @endif>Name</option>
													<option value="payment_gateway" @if ($con['subject'] == 'payment_gateway') selected @endif>Payment Gateway</option>
													<option value="start_status" @if ($con['subject'] == 'start_status') selected @endif>Status</option>
													<option value="validation_status" @if ($con['subject'] == 'validation_status') selected @endif>Validation</option>
												</select>
											</div>
											<div class="col-md-4">
												<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
													@if($con['subject'] == 'payment_gateway')
														@foreach($payment_list as $value)
															<option value="{{$value['payment_method']}}" @if ($con['operator'] == $value['payment_method']) selected @endif>{{$value['payment_method']}}</option>
														@endforeach
													@elseif($con['subject'] == 'start_status')
														<option value="1" @if ($con['operator'] == '1') selected @endif>Started</option>
														<option value="0" @if ($con['operator']  == '0') selected @endif>Not Started</option>
													@elseif($con['subject'] == 'validation_status')
														<option value="1" @if ($con['operator'] == '1') selected @endif>Completed</option>
														<option value="0" @if ($con['operator']  == '0') selected @endif>Not Completed</option>
													@else
														<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
														<option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
													@endif
												</select>
											</div>

											<div class="col-md-3">
                                                @if($con['subject'] == 'payment_gateway' || $con['subject'] == 'start_status' || $con['subject'] == 'validation_status')
                                                    <input type="hidden" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                                @else
                                                    <input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                                @endif
											</div>
										</div>
									</div>
								</div>
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
													<option value="" selected disabled>Search Subject</option>
													<option value="promo_payment_gateway_code">ID</option>
													<option value="name">Name</option>
													<option value="payment_gateway">Payment Gateway</option>
													<option value="start_status">Status</option>
													<option value="validation_status">Validation</option>
												</select>
											</div>
											<div class="col-md-4">
												<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
													<option value="=" selected>=</option>
													<option value="like">Like</option>
												</select>
											</div>
											<div class="col-md-3">
												<input type="text" placeholder="Keyword" class="form-control" name="parameter" />
											</div>
										</div>
									</div>
								</div>
							@endif
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
											<option value="" selected disabled>Search Subject</option>
											<option value="promo_payment_gateway_code">ID</option>
											<option value="name">Name</option>
											<option value="payment_gateway">Payment Gateway</option>
											<option value="start_status">Status</option>
											<option value="validation_status">Validation</option>
										</select>
									</div>
									<div class="col-md-4">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
											<option value="=" selected>=</option>
											<option value="like">Like</option>
										</select>
									</div>
									<div class="col-md-3">
										<input type="text" placeholder="Keyword" class="form-control" name="parameter" />
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
						<a class="btn green" href="{{url()->current()}}">Reset</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>