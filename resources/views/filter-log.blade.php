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

		if(subject_value == 'name' || subject_value == 'email' || subject_value == 'phone' || subject_value == 'subject' || subject_value == 'request' || subject_value == 'response' || subject_value == 'module' || subject_value == 'url' || subject_value == 'ip' || subject_value == 'userganet'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
		}

		if(subject_value == 'response_status'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('success', 'success');
			operator_value.options[operator_value.options.length] = new Option('fail', 'fail');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}

	}

</script>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Log Activity Search</span>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="form-group mt-repeater">
				<div data-repeater-list="conditions">
					@if(isset($conditions) && count($conditions) > 0)
						@foreach($conditions as $cond)
							<div data-repeater-item class="mt-repeater-item mt-overflow">
								<div class="mt-repeater-cell">
									<div class="col-md-12">
										<div class="col-md-1">
											<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
												<i class="fa fa-close"></i>
											</a>
										</div>
										<div class="col-md-4">
											<div class="input-group">
												<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
													<option value="name" @if($cond['subject'] == 'name') selected @endif>Name</option>
													<option value="phone" @if($cond['subject'] == 'phone') selected @endif>Phone</option>
													<option value="email" @if($cond['subject'] == 'email') selected @endif>Email</option>
													<option value="subject" @if($cond['subject'] == 'subject') selected @endif>Subject</option>
													<option value="response_status" @if($cond['subject'] == 'response_status') selected @endif>Response Status</option>
													<option value="url" @if($cond['subject'] == 'url') selected @endif>URL</option>
													<option value="ip" @if($cond['subject'] == 'ip') selected @endif>IP</option>
													<option value="useragent" @if($cond['subject'] == 'useragent') selected @endif>Useragent</option>
												</select>
												<span class="input-group-addon">
													<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>
												</span>
											</div>
										</div>
										<div class="col-md-4">
											<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
												@if($cond['subject'] == 'response_status')
													<option value="success" @if ($cond['operator']  == 'success') selected @endif>success</option>
													<option value="fail" @if ($cond['operator']  == 'fail') selected @endif>fail</option>
												@else
													<option value="=" @if ($cond['operator'] == '=') selected @endif>=</option>
													<option value="like" @if ($cond['operator']  == 'like') selected @endif>Like</option>
												@endif
											</select>
										</div>
										@if ($cond['subject'] == 'response_status')
											<div class="col-md-3">
												<input type="hidden" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($cond['parameter'])) value="{{ $cond['parameter'] }}" @endif/>
											</div>
										@else
											<div class="col-md-3">
												<input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($cond['parameter'])) value="{{ $cond['parameter'] }}" @endif/>
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
										<div class="input-group">
											<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%">
												<option value="name" selected>Name</option>
												<option value="phone">Phone</option>
												<option value="email">Email</option>
												<option value="subject">Subject</option>
												<option value="response_status">Response Status</option>
												<option value="url">URL</option>
												<option value="ip">IP</option>
												<option value="useragent">Useragent</option>
											</select>
											<span class="input-group-addon">
											<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>
										</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
												<option value="=">=</option>
												<option value="like" selected>Like</option>
											</select>
											<span class="input-group-addon">
											<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

											(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
											" data-container="body"></i>
										</span>
										</div>
									</div>
									<div class="col-md-3">
										<div class="input-group">
											<input type="text" placeholder="Parameter" class="form-control" name="parameter"/>
											<span class="input-group-addon">
											<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
										</span>
										</div>
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
						<div class="input-group">
							<select name="rule" class="form-control" placeholder="Search Rule" required>
								<option value="and" @if(isset($rule) && $rule == 'and') selected @endif>Valid when all conditions are met</option>
								<option value="or" @if(isset($rule) && $rule == 'or') selected @endif>Valid when minimum one condition is met</option>
							</select>
							<span class="input-group-addon">
								<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Valid when all conditions are met = melakukan filter pencarian dengan semua kondisi.

								Valid when minimum one condition is met = melakukan filter pencarian dengan salah satu kondisi
								" data-container="body"></i>
							</span>
						</div>
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