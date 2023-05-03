<?php
    use App\Lib\MyHelper;
    $configs     	= session('configs');
 ?>
<script>
	function changeRule(value, name){
		if(name == 'tooltip_rule'){
			if(value == 'or')document.getElementsByName(name)[0].setAttribute('data-original-title','melakukan filter pencarian dengan salah satu kondisi')
			else if(value == 'and') document.getElementsByName(name)[0].setAttribute('data-original-title','melakukan filter pencarian dengan semua kondisi')
		}else{
			var subject = name;
			var temp1 = subject.replace("conditions[", "");
			var index = temp1.replace("][operator]", "");
			var name = "conditions["+index+"][tooltip]";
			if(value == '=') document.getElementsByName(name)[0].setAttribute('data-original-title',' operator "=" untuk mendapatkan hasil pencarian yang sama persis dengan keyword')
			else if(value == 'like') document.getElementsByName(name)[0].setAttribute('data-original-title',' operator "like" untuk mendapatkan hasil pencarian yang mirip atau mengandung keyword')
			else if(value == '<') document.getElementsByName(name)[0].setAttribute('data-original-title',' operator "<" untuk mendapatkan hasil pencarian yang nilainya kurang dari keyword')
			else if(value == '<=') document.getElementsByName(name)[0].setAttribute('data-original-title',' operator "<=" untuk mendapatkan hasil pencarian yang nilainya kurang dari sama dengan keyword')
			else if(value == '>=') document.getElementsByName(name)[0].setAttribute('data-original-title',' operator ">=" untuk mendapatkan hasil pencarian yang nilainya lebih dari sama dengan keyword')
			else if(value == '>') document.getElementsByName(name)[0].setAttribute('data-original-title',' operator ">" untuk mendapatkan hasil pencarian yang nilainya lebih dari keyword')
		}
	}

	function changeSelect(){
		setTimeout(function(){
			$(".select2").select2({
				placeholder: "Search"
            });
		}, 100);
	}

	function changeRadioDate(name, val){
		var subject = name;
		var temp1 = subject.replace("conditions[", "");
		var index = temp1.replace("][radio_parameter]", "");
		var parameter = "conditions["+index+"][parameter]";
		if(val =="date"){
			document.getElementsByName(parameter)[0].style.display = 'block';
		}else if(val == 'select month'){
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
		}
		else{
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "none";
			document.getElementsByName(parameter)[0].style.display = 'none';
			document.getElementsByName(parameter)[0].value = '';
		}
	}

	function changeSubject(val){
		
		var subject = val;
		var temp1 = subject.replace("conditions[", "");
		var index = temp1.replace("][subject]", "");
		var subject_value = document.getElementsByName(val)[0].value;
		
		var parameter = "conditions["+index+"][parameter]";
		document.getElementsByName(parameter)[0].removeAttribute('readonly');
		document.getElementsByName(parameter)[0].value = '';
		document.getElementsByName(parameter)[0].style.display = "block";
		document.getElementsByClassName('radioDate')[index].style.display = "none";
		
		document.getElementsByName("conditions["+index+"][parameter_price]")[0].style.display = 'none';
		document.getElementsByName("conditions["+index+"][parameter_price]")[0].value = '';
		document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "none";
		document.getElementsByName("conditions["+index+"][parameter_select]")[0].value = "";
		document.getElementsByName("conditions["+index+"][radio_parameter]")[1].checked = false;
		document.getElementsByName("conditions["+index+"][radio_parameter]")[2].checked = false;
		document.getElementsByName("conditions["+index+"][div_param]")[0].style.padding = '0';

		document.getElementsByName(parameter)[0].required = true;
		document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = false;
		document.getElementsByName("conditions["+index+"][parameter_price]")[0].required = false;

		if(subject_value != 'created_at'){
			if($('.datepicker').length > 0){
				$('.datepicker').datepicker('remove'); 
				document.getElementsByName(parameter)[0].setAttribute('class', 'form-control') 
			}
		}

		if(subject_value == 'name' || subject_value == 'email' || subject_value == 'phone'){
			var operator = "conditions["+index+"][operator]";
			
			var operator_value = document.getElementsByName(operator)[0];

			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');
			
			if(document.getElementsByName(parameter)[0]){
				document.getElementsByName(parameter)[0].type = 'text';
			} else {
				document.getElementsByName(parameter)[0].type = 'hidden';
			}
		}
		
		if(subject_value == 'age' || subject_value == 'birthday_date' || subject_value == 'birthday_year' || subject_value == 'points' 
			|| subject_value == 'balances' || subject_value == 'membership_retain_date' || subject_value == 'transaction_count' 
			|| subject_value == 'transaction_nominal' || subject_value == 'created_at'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('>=', '>=');
			operator_value.options[operator_value.options.length] = new Option('>', '>');
			operator_value.options[operator_value.options.length] = new Option('<=', '<=');
			operator_value.options[operator_value.options.length] = new Option('<', '<');
			
			if(document.getElementsByName(parameter)[0]){
				if(subject_value == 'transaction_nominal' || subject_value == 'balances'){
					document.getElementsByName(parameter)[0].type = 'hidden';
					document.getElementsByName(parameter)[0].required = false;
					document.getElementsByName("conditions["+index+"][parameter_price]")[0].required = true;
					document.getElementsByName("conditions["+index+"][parameter_price]")[0].style.display = 'block';
					$('.price').each(function() {
						var input = $(this).val();
						var input = input.replace(/[\D\s\._\-]+/g, "");
						input = input ? parseInt( input, 10 ) : 0;

						$(this).val( function() {
							return ( input === 0 ) ? "" : input.toLocaleString( "id" );
						});
					});

					$( ".price" ).on( "keyup", numberFormat);
					function numberFormat(event){
						var selection = window.getSelection().toString();
						if ( selection !== '' ) {
							return;
						}

						if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
							return;
						}
						var $this = $( this );
						var input = $this.val();
						var input = input.replace(/[\D\s\._\-]+/g, "");
						input = input ? parseInt( input, 10 ) : 0;

						$this.val( function() {
							return ( input === 0 ) ? "" : input.toLocaleString( "id" );
						});
					}

					$( ".price" ).on( "blur", checkFormat);
					function checkFormat(event){
						var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
						if(!$.isNumeric(data)){
							$( this ).val("");
						}
					}
				}else if(subject_value == 'age' || subject_value == 'points' || subject_value == 'transaction_count'){
					document.getElementsByName(parameter)[0].type = 'number';
				} else if(subject_value == 'created_at') {
					document.getElementsByName(parameter)[0].type = 'text';
					document.getElementsByName(parameter)[0].setAttribute('class', 'form-control datepicker') 
					$('.datepicker').datepicker({ 
						'format' : 'd-M-yyyy', 
						'todayHighlight' : true, 
						'autoclose' : true 
					});  

					document.getElementsByName("conditions["+index+"][parameter_price]")[0].style.display = 'none';
				}else{
					document.getElementsByName(parameter)[0].type = 'text';
					document.getElementsByName("conditions["+index+"][parameter_price]")[0].style.display = 'none';
				}
			} else {
				document.getElementsByName(parameter)[0].type = 'hidden';
			}
		}
		
		if(subject_value == 'birthday_month'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "none";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			parameter_value.options[parameter_value.options.length] = new Option('January', '01');
			parameter_value.options[parameter_value.options.length] = new Option('February', '02');
			parameter_value.options[parameter_value.options.length] = new Option('March', '03');
			parameter_value.options[parameter_value.options.length] = new Option('April', '04');
			parameter_value.options[parameter_value.options.length] = new Option('May', '05');
			parameter_value.options[parameter_value.options.length] = new Option('June', '06');
			parameter_value.options[parameter_value.options.length] = new Option('July', '07');
			parameter_value.options[parameter_value.options.length] = new Option('August', '08');
			parameter_value.options[parameter_value.options.length] = new Option('September', '09');
			parameter_value.options[parameter_value.options.length] = new Option('October', '10');
			parameter_value.options[parameter_value.options.length] = new Option('November', '11');
			parameter_value.options[parameter_value.options.length] = new Option('December', '12');

			document.getElementsByName("conditions["+index+"][radio_parameter]")[1].id = "radioDate"+index;
			document.getElementsByName("conditions["+index+"][radio_parameter]")[2].id = "radioDate2"+index;
			document.getElementsByName("conditions["+index+"][radio_text]")[1].innerHTML = "<span></span>"+"<span class='check'></span>"+"<span class='box'></span> Select Month";
			document.getElementsByName("conditions["+index+"][radio_text]")[0].innerHTML = "<span></span>"+"<span class='check'></span>"+"<span class='box'></span> This Month";
			document.getElementsByName("conditions["+index+"][radio_parameter]")[1].value = "now";
			document.getElementsByName("conditions["+index+"][radio_parameter]")[2].value = "select month";
			document.getElementsByName("conditions["+index+"][radio_text]")[1].html = "radioDate2"+index;
			document.getElementsByClassName("labelRadio")[index].setAttribute('for', 'radioDate'+index)
			document.getElementsByClassName("labelRadio2")[index].setAttribute('for', 'radioDate2'+index)
			document.getElementsByClassName('radioDate')[index].style.display = "block";
		}
		
        if(subject_value == 'birthday_date'){
			
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByClassName('radioDate')[index].required = true;

			document.getElementsByName("conditions["+index+"][radio_parameter]")[1].id = "radioDate"+index;
			document.getElementsByName("conditions["+index+"][radio_parameter]")[2].id = "radioDate2"+index;
			document.getElementsByClassName("labelRadio")[index].setAttribute('for', 'radioDate'+index)
			document.getElementsByClassName("labelRadio2")[index].setAttribute('for', 'radioDate2'+index)
			document.getElementsByName("conditions["+index+"][radio_text]")[0].innerHTML = "<span></span>"+"<span class='check'></span>"+"<span class='box'></span> Now";
			document.getElementsByName("conditions["+index+"][radio_text]")[1].innerHTML = "<span></span>"+"<span class='check'></span>"+"<span class='box'></span> Custom date";
			document.getElementsByName("conditions["+index+"][radio_parameter]")[1].value = "now";
			document.getElementsByName("conditions["+index+"][radio_parameter]")[2].value = "date";
			document.getElementsByClassName('radioDate')[index].style.display = "block";
		}

		if(subject_value == 'provider'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			parameter_value.options[parameter_value.options.length] = new Option('Telkomsel', 'Telkomsel');
			parameter_value.options[parameter_value.options.length] = new Option('Indosat', 'Indosat');
			parameter_value.options[parameter_value.options.length] = new Option('XL Axiata', 'XL Axiata');
			parameter_value.options[parameter_value.options.length] = new Option('Tri', 'Tri');
			parameter_value.options[parameter_value.options.length] = new Option('Smart', 'Smart');
			parameter_value.options[parameter_value.options.length] = new Option('Axis', 'Axis');
		}
		
		if(subject_value == 'gender'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			parameter_value.options[parameter_value.options.length] = new Option('Male', 'Male');
			parameter_value.options[parameter_value.options.length] = new Option('Female', 'Female');
		}

		if(subject_value == 'city_name'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			<?php
			foreach($city as $row){
			?>
			parameter_value.options[parameter_value.options.length] = new Option('<?php echo $row['city_name']; ?>', '<?php echo $row['city_name']; ?>');
			<?php
			}
			?>
		}
		
		if(subject_value == 'city_postal_code'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			<?php
			foreach($city as $row){
			?>
			parameter_value.options[parameter_value.options.length] = new Option('<?php echo $row['city_postal_code']; ?>', '<?php echo $row['city_postal_code']; ?>');
			<?php
			}
			?>
		}
		
		if(subject_value == 'province_name'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			<?php
			foreach($province as $row){
			?>
			parameter_value.options[parameter_value.options.length] = new Option('<?php echo $row['province_name']; ?>', '<?php echo $row['province_name']; ?>');
			<?php
			}
			?>
		}
		
		if(subject_value == 'phone_verified' || subject_value == 'email_verified'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			parameter_value.options[parameter_value.options.length] = new Option('Not Verified', '0');
			parameter_value.options[parameter_value.options.length] = new Option('Verified', '1');
		}
		
		if(subject_value == 'email_unsubscribed'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			parameter_value.options[parameter_value.options.length] = new Option('Subscribed', '1');
			parameter_value.options[parameter_value.options.length] = new Option('Unsubscribed', '0');
		}
		
		if(subject_value == 'is_suspended'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			parameter_value.options[parameter_value.options.length] = new Option('Not Suspended', '0');
			parameter_value.options[parameter_value.options.length] = new Option('Suspended', '1');
		}
		
		if(subject_value == 'device' ){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');

			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			parameter_value.options[parameter_value.options.length] = new Option('Android', 'Android');
			parameter_value.options[parameter_value.options.length] = new Option('IOS', 'IOS');
			parameter_value.options[parameter_value.options.length] = new Option('Both', 'Both');
			parameter_value.options[parameter_value.options.length] = new Option('None', 'None');
		}
		
		@if(MyHelper::hasAccess([20], $configs))
		if(subject_value == 'membership_level'){
			document.getElementsByName(parameter)[0].style.display = "none";
			document.getElementsByName(parameter)[0].required = false;
			document.getElementsByName("conditions["+index+"][parameter_select]")[0].required = true;
			document.getElementsByName("conditions["+index+"][parameter_select_div]")[0].style.display = "block";
			
			var operator_value = document.getElementsByName("conditions["+index+"][operator]")[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			
			
			var parameter_value = document.getElementsByName("conditions["+index+"][parameter_select]")[0];
			for(i = parameter_value.options.length - 1 ; i >= 0 ; i--) parameter_value.remove(i);
			<?php
			foreach($membership as $row){
			?>
			parameter_value.options[parameter_value.options.length] = new Option('<?php echo $row['membership_name']; ?>', '<?php echo $row['id_membership']; ?>');
			<?php
			}
			?>
		}
		@endif
		
	}

</script>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject font-dark sbold uppercase font-yellow">Filter User</span>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="form-group mt-repeater">
				<div data-repeater-list="conditions">
					<div data-repeater-item class="mt-repeater-item mt-overflow">
						<div class="mt-repeater-cell">
							<div class="col-md-12" style="padding: 10px 0;">
								<div class="col-md-1">
									<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
										<i class="fa fa-close"></i>
									</a>
								</div>
								<div class="col-md-4">
									<div class="input-group">
										<select name="subject" class="form-control input-sm select2" placeholder="Search Subject" onChange="changeSubject(this.name)" style="width:100%" required>
											<option value="name" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'name') selected @endif>Name</option>
											<option value="phone" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'phone') selected @endif>Phone</option>
											<option value="email" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'email') selected @endif>Email</option>
											<option value="city_name" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'city_name') selected @endif>City</option>
											<option value="province_name" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'province_name') selected @endif>Province</option>
											<option value="city_postal_code" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'city_postal_code') selected @endif>Postal Code</option>
											<option value="gender" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'gender') selected @endif>Gender</option>
											<option value="provider" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'provider') selected @endif>Provider</option>
											<option value="age" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'age') selected @endif>Age</option>
											<option value="birthday_date" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'birthday_date') selected @endif>Birthday Date</option>
											<option value="birthday_month" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'birthday_month') selected @endif>Birthday Month</option>
											<option value="birthday_year" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'birthday_year') selected @endif>Birthday Year</option>
											<option value="phone_verified" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'phone_verified') selected @endif>Phone Verified</option>
											<option value="email_verified" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'email_verified') selected @endif>Email Verified</option>
											<option value="email_unsubscribed" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'email_unsubscribed') selected @endif>Email Unsubscribed</option>
											@if(MyHelper::hasAccess([18], $configs))
												<option value="points" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'points') selected @endif>Points</option>
											@endif
											@if(MyHelper::hasAccess([19], $configs))
												<option value="balances" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'balances') selected @endif>Balances</option>
											@endif
											<option value="transaction_count" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'transaction_count') selected @endif>Total Transaction Count</option>
											<option value="transaction_nominal" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'transaction_nominal') selected @endif>Total Transaction Nominal</option>
											<option value="device" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'device') selected @endif>Device</option>
											<option value="created_at" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'created_at') selected @endif>Register Date</option>
											<option value="is_suspended" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'is_suspended') selected @endif>Suspend Status</option>
											@if(MyHelper::hasAccess([20], $configs))
												<option value="membership_level" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'membership_level') selected @endif>Membership Level</option>
												<option value="membership_retain_date" @if(isset($result['autocrm_rules'][0]['autocrm_rule_subject']) && $result['autocrm_rules'][0]['autocrm_rule_subject'] == 'membership_retain_date') selected @endif>Membership Retain Date</option>
											@endif
										</select>
										<span class="input-group-addon">
											<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="pilih field yang akan dijadikan condition filter" data-container="body"></i>
										</span>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" style="width:100%" onchange="changeRule(this.value, this.name)" required>
											<option value="=" selected>=</option>
											<option value="like">like</option>
										</select>
										<span class="input-group-addon">
											<i style="color: #333;" class="fa fa-question-circle tooltips" data-original-title='pillih operator untuk membandingkan kondisi dengan keyword' name='tooltip' data-container="body"id="tooltip_operator"></i>
										</span>
									</div>
								</div>
								<div class="col-md-5">
									<div class="input-group">
										<div class="col-md-12" name="div_param" style="padding:0">
										<div class="md-radio-inline radioDate" style="display:none">
											<div class="md-radio">
												<input type="radio" style="hidden" name="radio_parameter" class="md-radiobtn">
												<input type="radio" id="radioDate20" name="radio_parameter" class="md-radiobtn" value="now" onclick="changeRadioDate(this.name, this.value)">
												<label for="radio1" class="labelRadio" name="radio_text">
													<span></span>
													<span class="check"></span>
													<span class="box"></span> Date Now </label>
											</div>
											<div class="md-radio">
												<input type="radio" id="radioDate0" name="radio_parameter" class="md-radiobtn" value="date" onclick="changeRadioDate(this.name, this.value)">
												<label for="radio16" class="labelRadio2" name="radio_text">
													<span></span>
													<span class="check"></span>
													<span class="box"></span> Custom Date </label>
											</div>
										</div>
										<input type="text" placeholder="Parameter" class="form-control" name="parameter" required/>
										<div style="display:none" name = 'parameter_select_div'>
											<select name="parameter_select" class="form-control input-sm select2" style="width:100%; display:none">
											</select>
										</div>
										<input type="text" placeholder="Parameter" class="form-control price" name="parameter_price" style="display:none">
										</div>
										<span class="input-group-addon">
											<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title='keyword untuk pencarian' data-container="body"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-action col-md-12">
					<div class="col-md-12">
						<a href="javascript:;" id="btn_new_condition" data-repeater-create class="btn btn-success mt-repeater-add" onClick="changeSelect();">
						<i class="fa fa-plus"></i> Add New Condition</a>
					</div>
				</div>
				
				<div class="form-action col-md-12" style="margin-top:15px">
					<div class="col-md-6">
						<div class="input-group">
							<select name="autocrm_cron_rule" class="form-control" placeholder="Search Rule" required onChange="changeRule(this.value, 'tooltip_rule')">
								<option value="and" @if(old('autocrm_cron_rule') == 'and') selected @else @if(isset ($result['autocrm_cron_rule']) && $result['autocrm_cron_rule'] == 'and') selected @endif @endif>Valid when all conditions are met</option>
								<option value="or" @if(old('autocrm_cron_rule') == 'or') selected @else @if(isset ($result['autocrm_cron_rule']) && $result['autocrm_cron_rule'] == 'or') selected @endif @endif>Valid when minimum one condition is met</option>
							</select>
							<span class="input-group-addon">
									<i style="color:#333" class="fa fa-question-circle tooltips" data-original-title="Valid when all conditions are met = melakukan filter pencarian dengan semua kondisi.
								
								Valid when minimum one condition is met = melakukan filter pencarian dengan salah satu kondisi
								" data-container="body"></i>
							</span>
						</div>
					</div>
					@if(isset($tombolsubmit))
					@else
						<div class="col-md-4">
						{{ csrf_field() }}
						 <button type="submit" class="btn yellow"><i class="fa fa-search"></i> Search</button>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>