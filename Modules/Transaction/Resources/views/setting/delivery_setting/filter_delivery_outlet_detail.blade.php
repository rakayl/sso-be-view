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

		if(subject_value == 'id_province'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
					foreach($province as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['province_name']; ?>', '<?php echo $row['id_province']; ?>');
					<?php
					}
					?>
                    var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
		}else if(subject_value == 'id_city'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			<?php
					foreach($city as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['city_name']; ?>', '<?php echo $row['id_city']; ?>');
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

	function changeFilterType(val) {
		if(val == 'outlet_group'){
			document.getElementById('div_outlet_group').style.display = 'block';
			document.getElementById('div_conditions').style.display = 'none';
			$("#outlet_group_filter").select2({
				"closeOnSelect": false,
				width: '100%'
			});
		}else{
			document.getElementById('div_outlet_group').style.display = 'none';
			document.getElementById('div_conditions').style.display = 'block';
		}
	}
	
	function searchFilterConditions() {
		console.log($('form_filter').serialize());
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
			<div class="form-group">
				<div class="col-md-9" style="margin-left:2%;">
					<div class="mt-radio-inline">
						<label class="mt-radio">
							<input type="radio" name="filter_type" id="optionFilterType1" value="outlet_group"  onclick="changeFilterType(this.value)" @if($filter_type == 'outlet_group' || empty($filter_type)) checked @endif> Outlet Group Filter
							<span></span>
						</label>
						<label class="mt-radio">
							<input type="radio" name="filter_type" id="optionFilterType2" value="conditions" onclick="changeFilterType(this.value)" @if($filter_type == 'conditions') checked @endif> Conditions
							<span></span>
						</label>
					</div>
				</div>
			</div>

			<div class="form-group" id="div_outlet_group" @if($filter_type == 'conditions') style="display: none" @endif>
				<div class="col-md-4" style="margin-left:2%;">
					<select class="form-control select2" id="outlet_group_filter" name="id_outlet_group_filter" data-placeholder="Select" required>
						<option></option>
						<option value="0" @if(empty($id_outlet_group_filter)) selected @endif>All Outlet</option>
						@foreach($outlet_group_filter as $filter)
							<option value="{{$filter['id_outlet_group']}}" @if($id_outlet_group_filter == $filter['id_outlet_group']) selected @endif>{{$filter['outlet_group_name']}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
				</div>
				<div class="col-md-1" style="margin-left: -5%">
					<a class="btn green" href="{{url()->current()}}">Reset</a>
				</div>
			</div>

			<div class="form-group mt-repeater" id="div_conditions" @if($filter_type == 'outlet_group' || empty($filter_type)) style="display: none" @endif>
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
													<option value="id_province" @if ($con['subject'] == 'id_province') selected @endif>Province</option>
													<option value="id_city" @if ($con['subject'] == 'id_city') selected @endif>Cities</option>
													<option value="oultet_name" @if ($con['subject'] == 'oultet_name') selected @endif>Outlet Name</option>
													<option value="outlet_code" @if ($con['subject'] == 'outlet_code') selected @endif>Outlet Code</option>
												</select>
											</div>
											<div class="col-md-4">
												<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
													@if($con['subject'] == 'id_city')
														@foreach($city as $value)
															<option value="{{$value['id_city']}}" @if ($con['operator'] == $value['id_city']) selected @endif>{{$value['city_name']}}</option>
														@endforeach
													@elseif($con['subject'] == 'id_province')
														@foreach($province as $value)
															<option value="{{$value['id_province']}}" @if ($con['operator'] == $value['id_province']) selected @endif>{{$value['province_name']}}</option>
														@endforeach
													@else
														<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
														<option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
													@endif
												</select>
											</div>

											<div class="col-md-3">
												@if($con['subject'] == 'id_city' || $con['subject'] == 'id_province')
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
													<option value="id_province">Province</option>
													<option value="id_city">Cities</option>
													<option value="oultet_name">Outlet Name</option>
													<option value="outlet_code">Outlet Code</option>
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
											<option value="id_province">Province</option>
											<option value="id_city">Cities</option>
											<option value="oultet_name">Outlet Name</option>
											<option value="outlet_code">Outlet Code</option>
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