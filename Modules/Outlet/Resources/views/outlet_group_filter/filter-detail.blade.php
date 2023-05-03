<?php
use App\Lib\MyHelper;
$configs = session('configs');
$show=$show??false;
?>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		$('.datepicker').datepicker({
			'format' : 'yyyy-mm-dd',
			'todayHighlight' : true,
			'autoclose' : true
		});
	})

	function changeSelect(){
		setTimeout(function(){
			$(".select2").select2({
				placeholder: "Search"
			});
		}, 100);
	}

			@if(!is_array($conditions??"") || count($conditions??[]) <= 0)
	var noRule = 1;
			@else
	var noRule = {{count($conditions??[])}};
	@endif

	function addRule(){
		$("#div-rule").append(
				'<div id="rule'+noRule+'">'+
				'<div class="portlet light bordered" style="margin-top:80px">'+
				'<div class="col-md-12" style="padding: 0; margin-bottom: 15px;">'+
				'<a href="javascript:;" class="btn btn-danger pull-right delete-rule" onClick="deleteRule('+noRule+')">'+
				'<i class="fa fa-trash"></i> Delete Rule'+
				'</a>'+
				'</div>'+
				'<div class="form-group mt-repeater">'+
				'<div id="div-condition'+noRule+'">'+
				'<div data-repeater-item class="mt-repeater-item mt-overflow" id="condition'+noRule+'0">'+
				'<div class="mt-repeater-cell">'+
				'<div class="col-md-12">'+
				'<div class="col-md-1">'+
				'<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+noRule.toString()+'0`,`'+noRule.toString()+'`)">'+
				'<i class="fa fa-close"></i>'+
				'</a>'+
				'</div>'+
				'<div class="col-md-4">'+
				'<div class="input-group">'+
				'<select id="select2'+noRule+'0" name="conditions['+noRule+'][0][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, '+noRule+')" style="width:100%" required>'+
				'<option value="outlet_code">Outlet Code</option>'+
				'<option value="outlet_name">Outlet Name</option>'+
				'<option value="province">Province</option>'+
				'<option value="city">City</option>'+
				'<option value="status_franchise">Status Franchise</option>'+
				'<option value="delivery_order">Status Delivery</option>'+
				'<option value="brand">Brand</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'<div id="normalCondition'+noRule+'0">'+
				'<div class="col-md-4">'+
				'<div class="input-group">'+
				'<select name="conditions['+noRule+'][0][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'<option value="=" selected>=</option>'+
				'<option value="like">Like</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator = untuk mendapatkan hasil pencarian yang sama persis dengan keyword.'+

				'(2). Operator like untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword'+
				'" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'<div class="col-md-3">'+
				'<div class="input-group">'+
				'<input type="text" placeholder="Parameter" class="form-control" name="conditions['+noRule+'][0][parameter]" required/>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'<div id="specialCondition'+noRule+'0" style="display:none">'+
				'<div class="col-md-3">'+
				'<div class="input-group">'+
				'<select name="conditions['+noRule+'][0][id]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'</select>'+
				'</div>'+
				'</div>'+

				'<div class="col-md-2">'+
				'<div class="input-group">'+
				'<select name="conditions['+noRule+'][0][operatorSpecialCondition]" id ="operator'+noRule+'0"  class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'<option value="=" selected>=</option>'+
				'<option value=">=">>=</option>'+
				'<option value=">">></option>'+
				'<option value="<="><=</option>'+
				'<option value="<"><</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator = untuk mendapatkan hasil pencarian yang sama persis dengan keyword.'+

				'(2). Operator like untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword'+
				'" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+

				'<div class="col-md-2">'+
				'<div class="input-group">'+
				'<input type="text" placeholder="0" class="form-control" id ="parameter'+noRule+'0" name="conditions['+noRule+'][0][parameterSpecialCondition]"/>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+

				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'<div class="form-action col-md-12">'+
				'<div class="col-md-12">'+
				'<a id="btnAddCondition'+noRule+'" href="javascript:;" class="btn btn-success mt-repeater-add" onClick="changeSelect();addCondition('+noRule+', 1)">'+
				'<i class="fa fa-plus"></i> Add New Condition</a>'+
				'</div>'+
				'</div>'+
				'<div class="form-action col-md-12" style="margin-top:15px">'+
				'<div class="col-md-7">'+
				'<div class="input-group">'+
				'<select name="conditions['+noRule+'][rule]" class="form-control" placeholder="Search Rule" required>'+
				'<option value="and">Valid when all conditions are met</option>'+
				'<option value="or">Valid when minimum one condition is met</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Valid when all conditions are met = melakukan filter pencarian dengan semua kondisi.'+

				'Valid when minimum one condition is met = melakukan filter pencarian dengan salah satu kondisi'+
				'" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'<div class="col-md-3">'+
				'<div class="input-group">'+
				'<select name="conditions['+noRule+'][rule_next]" class="form-control" placeholder="Search Rule" required>'+
				'<option value="and">And</option>'+
				'<option value="or">Or</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="And = melakukan filter pencarian dengan semua kondisi.'+

				'Or = melakukan filter pencarian dengan salah satu kondisi'+
				'" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'</div>'
		);
		noRule++;
		$('.tooltips').tooltip()
	}

	function deleteRule(no){
		if(confirm('Are you sure you want to delete this rule?')) {
			$('#rule'+no).remove()
		}

	}

	function addCondition(no, noCond){
		$(
				'<div data-repeater-item class="mt-repeater-item mt-overflow" id="condition'+no+noCond+'">'+
				'<div class="mt-repeater-cell">'+
				'<div class="col-md-12">'+
				'<div class="col-md-1">'+
				'<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition(`'+no+noCond+'`,`'+no+'`)">'+
				'<i class="fa fa-close"></i>'+
				'</a>'+
				'</div>'+
				'<div class="col-md-4">'+
				'<div class="input-group">'+
				'<select id="select2'+no+noCond+'" name="conditions['+no+']['+noCond+'][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, '+no+')" style="width:100%" required>'+
				'<option value="outlet_code">Outlet Code</option>'+
				'<option value="outlet_name">Outlet Name</option>'+
				'<option value="province">Province</option>'+
				'<option value="city">City</option>'+
				'<option value="status_franchise">Status Franchise</option>'+
				'<option value="delivery_order">Status Delivery</option>'+
				'<option value="brand">Brand</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'<div id="normalCondition'+no+noCond+'">'+
				'<div class="col-md-4">'+
				'<div class="input-group">'+
				'<select name="conditions['+no+']['+noCond+'][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'<option value="=" selected>=</option>'+
				'<option value="like">Like</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator = untuk mendapatkan hasil pencarian yang sama persis dengan keyword.'+

				'(2). Operator like untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword'+
				'" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'<div class="col-md-3">'+
				'<div class="input-group">'+
				'<input type="text" placeholder="Parameter" class="form-control" name="conditions['+no+']['+noCond+'][parameter]" required/>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'</div>'+
				'<div id="specialCondition'+no+noCond+'" style="display:none">'+
				'<div class="col-md-3">'+
				'<div class="input-group">'+
				'<select name="conditions['+no+']['+noCond+'][id]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'</select>'+
				'</div>'+
				'</div>'+

				'<div class="col-md-2">'+
				'<div class="input-group">'+
				'<select name="conditions['+no+']['+noCond+'][operatorSpecialCondition]"  id ="operator'+no+noCond+'"  class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">'+
				'<option value="=" selected>=</option>'+
				'<option value=">=">>=</option>'+
				'<option value=">">></option>'+
				'<option value="<="><=</option>'+
				'<option value="<"><</option>'+
				'</select>'+
				'<span class="input-group-addon">'+
				'<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator = untuk mendapatkan hasil pencarian yang sama persis dengan keyword.'+

				'(2). Operator like untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword'+
				'" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+

				'<div class="col-md-2">'+
				'<div class="input-group">'+
				'<input type="text" placeholder="0" class="form-control" id ="parameter'+no+noCond+'" name="conditions['+no+']['+noCond+'][parameterSpecialCondition]"/>'+
				'<span class="input-group-addon">'+
				'<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>'+
				'</span>'+
				'</div>'+
				'</div>'+
				'</div>'+

				'</div>'+
				'</div>'+
				'</div>'
		).appendTo($('#div-condition'+no)).slideDown("slow")
		noCond = parseInt(noCond) + 1
		$('#btnAddCondition'+no).attr('onclick', 'changeSelect();addCondition('+no+','+noCond+')');
		$('.tooltips').tooltip()
	}

	function deleteCondition(no, indexRule){
		if(confirm('Are you sure you want to delete this condition?')) {
			$('#condition'+no).remove()
		}

	}

	function changeSubject(val, indexRule){
		var subject = val;
		var temp1 = subject.replace("conditions[", "");
		var index = temp1.replace("][subject]", "");
		var subject_value = document.getElementsByName(val)[0].value;
		var indx = index.replace("[", "");
		var indx = indx.replace("]", "");

		if(document.getElementById('normalCondition'+indx).style.display === 'none' ){
			var parameter = "conditions["+index+"][parameter]";
			var operator = "conditions["+index+"][operator]";
			var idData = "conditions["+index+"][id]";
			document.getElementById('normalCondition'+indx).style.display = 'block';
			if (document.getElementsByName(parameter)[0] != null) document.getElementsByName(parameter)[0].required = true;
			if (document.getElementsByName(operator)[0] != null) document.getElementsByName(operator)[0].required = true;

			document.getElementById('specialCondition'+indx).style.display = 'none';
			if (document.getElementsByName(idData)[0] != null) document.getElementsByName(idData)[0].required = false;
			if (document.getElementById('operator'+indx) != null) document.getElementById('operator'+indx).required = false;
			if (document.getElementById('parameter'+indx) != null) document.getElementById('parameter'+indx).required = false;
		}

		var parameter = "conditions["+index+"][parameter]";
		var operator = "conditions["+index+"][operator]";
		$('[name="'+parameter+'"]').closest('.input-group').show();
		$('[name="'+operator+'"]').closest('.input-group').show();

		if(subject_value == 'province') {
			var operator = "conditions[" + index + "][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for (i = operator_value.options.length - 1; i >= 0; i--) operator_value.remove(i);
			<?php
					foreach($provinces as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['province_name']; ?>', '<?php echo $row['id_province']; ?>');
					<?php
					}
					?>

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}else if(subject_value == 'city') {
			var operator = "conditions[" + index + "][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for (i = operator_value.options.length - 1; i >= 0; i--) operator_value.remove(i);
			<?php
					foreach($cities as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['city_name']; ?>', '<?php echo $row['id_city']; ?>');
					<?php
					}
					?>

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}else if(subject_value == 'brand') {
			var operator = "conditions[" + index + "][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for (i = operator_value.options.length - 1; i >= 0; i--) operator_value.remove(i);
			<?php
					foreach($brands as $row){
					?>
					operator_value.options[operator_value.options.length] = new Option('<?php echo $row['name_brand']; ?>', '<?php echo $row['id_brand']; ?>');
					<?php
					}
					?>

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}else if(subject_value == 'status_franchise'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Mitra', '1');
			operator_value.options[operator_value.options.length] = new Option('Pusat', '0');

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}else if(subject_value == 'delivery_order'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Active', '1');
			operator_value.options[operator_value.options.length] = new Option('Inactive', '0');

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'none';
				document.getElementsByName(parameter)[0].required = false;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			}
		}else{
			var operator = "conditions["+index+"][operator]";

			var operator_value = document.getElementsByName(operator)[0];

			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');

			var parameter = "conditions["+index+"][parameter]";
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].style.display = 'block';
				document.getElementsByName(parameter)[0].required = true;
			} else if(document.getElementsByName(parameter)[0] != null){
				document.getElementsByName(parameter)[0].style.display = 'none';
			}
		}
	}
</script>

<div id="div-rule">
	@if(!is_array($conditions??"") || count($conditions??[]) <= 0)
		<div id="rule0">
			<div class="portlet light bordered">
				<div class="col-md-12" style="padding: 0; margin-bottom: 15px;">
					<a href="javascript:;" class="btn btn-danger pull-right delete-rule" onclick="deleteRule(0)">
						<i class="fa fa-trash"></i> Delete Rule
					</a>
				</div>
				<div class="form-group mt-repeater">
					<div id="div-condition0">
						<div data-repeater-item class="mt-repeater-item mt-overflow" id="condition00">
							<div class="mt-repeater-cell">
								<div class="col-md-12">
									<div class="col-md-1">
										<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('00','0')">
											<i class="fa fa-close"></i>
										</a>
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<select id="select200"  name="conditions[0][0][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, 0)" style="width:100%">
												<option value="outlet_code">Outlet Code</option>
												<option value="outlet_name">Outlet Name</option>
												<option value="province">Province</option>
												<option value="city">City</option>
												<option value="status_franchise">Status Franchise</option>
												<option value="delivery_order">Status Delivery</option>
												<option value="brand">Brand</option>
											</select>
											<span class="input-group-addon">
													<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>
												</span>
										</div>
									</div>
									<div id="normalCondition00">
										<div class="col-md-4">
											<div class="input-group">
												<select name="conditions[0][0][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">
													<option value="=" selected>=</option>
													<option value="like">Like</option>
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
												<input type="text" placeholder="Parameter" class="form-control" name="conditions[0][0][parameter]"/>
												<span class="input-group-addon">
													<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
												</span>
											</div>
										</div>
									</div>
									<div id="specialCondition00" style="display:none">
										<div class="col-md-3">
											<div class="input-group">
												<select name="conditions[0][0][id]" class="form-control input-sm select2"  placeholder="Search Operator" style="width:100%">
												</select>
												</span>
											</div>
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<select name="conditions[0][0][operatorSpecialCondition]" class="form-control input-sm select2" id="operator00" placeholder="Search Operator" style="width:100%">
													<option value="=" selected>=</option>
													<option value=">=">>=</option>
													<option value=">">></option>
													<option value="<="><=</option>
													<option value="<"><</option>
												</select>
												<span class="input-group-addon">
													<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

													(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
													" data-container="body"></i>
												</span>
											</div>
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input type="text" placeholder="0" class="form-control" name="conditions[0][0][parameterSpecialCondition]" id="parameter00"/>
												<span class="input-group-addon">
													<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-action col-md-12">
						<div class="col-md-12">
							<a id="btnAddCondition0" href="javascript:;" class="btn btn-success mt-repeater-add" onClick="changeSelect();addCondition(0, 1)">
								<i class="fa fa-plus"></i> Add New Condition</a>
						</div>
					</div>
					<div class="form-action col-md-12" style="margin-top:15px">
						<div class="col-md-7">
							<div class="input-group">
								<select name="conditions[0][rule]" class="form-control" placeholder="Search Rule">
									<option value="and">Valid when all conditions are met</option>
									<option value="or">Valid when minimum one condition is met</option>
								</select>
								<span class="input-group-addon">
									<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Valid when all conditions are met = melakukan filter pencarian dengan semua kondisi.

									Valid when minimum one condition is met = melakukan filter pencarian dengan salah satu kondisi
									" data-container="body"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group">
					<select name="conditions[0][rule_next]" class="form-control" placeholder="Search Rule">
						<option value="and">And</option>
						<option value="or">Or</option>
					</select>
					<span class="input-group-addon">
						<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="And = melakukan filter pencarian dengan semua kondisi.

						Or = melakukan filter pencarian dengan salah satu kondisi
						" data-container="body"></i>
					</span>
				</div>
			</div>
		</div>
	@else
		<?php $q = 0; ?>
		@foreach($conditions as $key => $cond)
			<div id="rule{{$q}}" @if($q > 0) style="margin-top:80px;" @endif>
				<div class="portlet light bordered">
					<div class="col-md-12" style="padding: 0; margin-bottom: 15px;">
						<a href="javascript:;" class="btn btn-danger pull-right delete-rule" onclick="deleteRule({{$q}})">
							<i class="fa fa-trash"></i> Delete Rule
						</a>
					</div>
					<div class="form-group mt-repeater">
						<div id="div-condition{{$q}}">
							<?php
							$indexnya = 0;
							?>
							@foreach($cond['condition_child']??[] as $row)
								@if(isset($row['outlet_group_filter_subject']))
									<?php
									if($row['outlet_group_filter_subject'] != '' && $row['outlet_group_filter_subject'] != 'all_user'){
										$arrayOp = ['=','like','<','<=','>','>='];
										if(!in_array($row['outlet_group_filter_operator'],$arrayOp)){
											$row['outlet_group_filter_parameter'] = $row['outlet_group_filter_operator'];
										}
									}else{
										$row['outlet_group_filter_operator'] = "";
										$row['outlet_group_filter_parameter'] = $row['outlet_group_filter_operator'];

									}
									?>
									<div data-repeater-item class="mt-repeater-item mt-overflow" id="condition{{$q}}{{$indexnya}}">
										<div class="mt-repeater-cell">
											<div class="col-md-12">
												<div class="col-md-1">
													<a href="javascript:;" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline" onclick="deleteCondition('{{$q}}{{$indexnya}}','{{$q}}')">
														<i class="fa fa-close"></i>
													</a>
												</div>
												<div class="col-md-4">
													<div class="input-group">
														<select id="select2{{$q}}{{$indexnya}}" name="conditions[{{$q}}][{{$indexnya}}][subject]" class="form-control input-sm select2 subject" placeholder="Search Subject" onChange="changeSubject(this.name, {{$indexnya}})" style="width:100%">
															<option value="outlet_code" @if ($row['outlet_group_filter_subject'] == 'outlet_code') selected @endif>Outlet Code</option>
															<option value="outlet_name" @if ($row['outlet_group_filter_subject'] == 'outlet_name') selected @endif>Outlet Name</option>
															<option value="province" @if ($row['outlet_group_filter_subject'] == 'province') selected @endif>Province</option>
															<option value="city" @if ($row['outlet_group_filter_subject'] == 'city') selected @endif>City</option>
															<option value="status_franchise" @if ($row['outlet_group_filter_subject'] == 'status_franchise') selected @endif>Status Franchise</option>
															<option value="delivery_order" @if ($row['outlet_group_filter_subject'] == 'delivery_order') selected @endif>Status Delivery</option>
															<option value="brand" @if ($row['outlet_group_filter_subject'] == 'brand') selected @endif>Brand</option>
														</select>
														<span class="input-group-addon">
															<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Pilih field yang akan dijadikan condition filter" data-container="body"></i>
														</span>
													</div>
												</div>
												<?php
												$operator = '';
												$parameter = '';
												$id_data = '';
												$display_special_condition = 'none';
												$display_normal_condition = 'block';

												if($row['outlet_group_filter_subject'] == 'city'){
													foreach($cities as $city){
														$operator .= '<option value="'.$city['id_city'].'" '.($row['outlet_group_filter_operator'] == $city['id_city'] ? 'selected' : '').'>'.$city['city_name'].'</option>';
													}
													$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" />';
												}elseif($row['outlet_group_filter_subject'] == 'province'){
													foreach($provinces as $province){
														$operator .= '<option value="'.$province['id_province'].'" '.($row['outlet_group_filter_operator'] == $province['id_province'] ? 'selected' : '').'>'.$province['province_name'].'</option>';
													}
													$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" />';
												}elseif($row['outlet_group_filter_subject'] == 'brand'){
													foreach($brands as $brand){
														$operator .= '<option value="'.$brand['id_brand'].'" '.($row['outlet_group_filter_operator'] == $brand['id_brand'] ? 'selected' : '').'>'.$brand['name_brand'].'</option>';
													}
													$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" />';
												}elseif($row['outlet_group_filter_subject'] == 'status_franchise'){
													$operator .= '<option value="1" '.($row['outlet_group_filter_operator'] == 1 ? 'selected' : '').'>Mitra</option>';
													$operator .= '<option value="0" '.($row['outlet_group_filter_operator'] == 0 ? 'selected' : '').'>Pusat</option>';
													$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" />';
												}elseif($row['outlet_group_filter_subject'] == 'delivery_order'){
													$operator .= '<option value="1" '.($row['outlet_group_filter_operator'] == 1 ? 'selected' : '').'>Active</option>';
													$operator .= '<option value="0" '.($row['outlet_group_filter_operator'] == 0 ? 'selected' : '').'>Inavtive</option>';
													$parameter .= '<input type="hidden" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" />';
												}else{
													$operator .= '<option value="="'.($row['outlet_group_filter_operator'] == '=' ? 'selected' : '').'>=</option>';
													$operator .= '<option value="like"'.($row['outlet_group_filter_operator'] == 'like' ? 'selected' : '').'>Like</option>';
													$parameter .= '<input type="text" placeholder="Parameter" class="form-control" name="conditions['.$q.']['.$indexnya.'][parameter]" value="'.$row['outlet_group_filter_parameter'].'" />';
												}
												?>
												<div id="normalCondition{{$q}}{{$indexnya}}" style="display: {{$display_normal_condition}};">
													<div class="col-md-4">
														<div class="input-group">
															<select name="conditions[{{$q}}][{{$indexnya}}][operator]" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%">
																@if($display_normal_condition != 'none')
																	<?php echo $operator ?>
																@else
																	<option value="=" selected>=</option>
																	<option value="like">Like</option>
																@endif
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
															@if($display_normal_condition != 'none')
																<?php echo $parameter ?>
															@else
																<input type="text" placeholder="Parameter" class="form-control" name="conditions[{{$q}}][{{$indexnya}}][parameter]"/>
															@endif
															<span class="input-group-addon">
																	<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
															</span>
														</div>
													</div>
												</div>
												<div id="specialCondition{{$q}}{{$indexnya}}" style="display: {{$display_special_condition}};">
													<div class="col-md-3">
														<div class="input-group">
															<select name="conditions[{{$q}}][{{$indexnya}}][id]" class="form-control input-sm select2" placeholder="Search Product"  style="width:100%" @if($display_special_condition != 'none') required @endif>
																<?php echo $id_data ?>
															</select>
														</div>
													</div>
													<div class="col-md-2">
														<div class="input-group">
															<select name="conditions[{{$q}}][{{$indexnya}}][operatorSpecialCondition]" id="operator{{$q}}{{$indexnya}}" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%" @if($display_special_condition != 'none') required @endif>
																<?php echo $operator ?>
															</select>
															<span class="input-group-addon">
															<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="(1). Operator '=' untuk mendapatkan hasil pencarian yang sama persis dengan keyword.

															(2). Operator 'like' untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword
															" data-container="body"></i>
														</span>
														</div>
													</div>
													<div class="col-md-2">
														<div class="input-group">
															@if($display_special_condition != 'none')
																<?php echo $parameter ?>
															@else
																<input type="text" placeholder="0" class="form-control" id="parameter{{$q}}{{$indexnya}}" name="conditions[{{$q}}][{{$indexnya}}][parameterSpecialCondition]"/>
															@endif
															<span class="input-group-addon">
																<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="keyword untuk pencarian" data-container="body"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
									$indexnya++;
									?>
								@endif
							@endforeach
						</div>
						<div class="form-action col-md-12">
							<div class="col-md-12">
								<a id="btnAddCondition{{$q}}" href="javascript:;" class="btn btn-success mt-repeater-add" onClick="changeSelect();addCondition({{$q}},{{$indexnya}})">
									<i class="fa fa-plus"></i> Add New Condition</a>
							</div>
						</div>
						<div class="form-action col-md-12" style="margin-top:15px">
							<div class="col-md-7">
								<div class="input-group">
									<select name="conditions[{{$q}}][rule]" class="form-control" placeholder="Search Rule" required>
										<option value="and" @if($conditions[$key]['condition_parent_rule'] == 'and') selected @endif>Valid when all conditions are met</option>
										<option value="or" @if($conditions[$key]['condition_parent_rule'] == 'or') selected @endif>Valid when minimum one condition is met</option>
									</select>
									<span class="input-group-addon">
										<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Valid when all conditions are met = melakukan filter pencarian dengan semua kondisi.

										Valid when minimum one condition is met = melakukan filter pencarian dengan salah satu kondisi
										" data-container="body"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="input-group">
						<select name="conditions[{{$q}}][rule_next]" class="form-control" placeholder="Search Rule" required>
							<option @if($conditions[$key]['condition_parent_rule_next'] == 'and') selected @endif value="and">And</option>
							<option @if($conditions[$key]['condition_parent_rule_next'] == 'or') selected @endif value="or">Or</option>
						</select>
						<span class="input-group-addon">
							<i  style="color:#333" class="fa fa-question-circle tooltips" data-original-title="And = melakukan filter pencarian dengan semua kondisi.

							Or = melakukan filter pencarian dengan salah satu kondisi
							" data-container="body"></i>
						</span>
					</div>
				</div>
			</div>
			<?php $q++	; ?>
		@endforeach
	@endif
</div>
<div>
	<a href="javascript:;" class="btn btn-success mt-repeater-add" onClick="addRule();changeSelect()">
		<i class="fa fa-plus"></i> Add New Rule</a>
</div>
