@section('child-script')
<script>
	rules={
		subscription_title:{
			display:'Title',
			operator:[
			['=','='],
			['like','like']
			],
			opsi:[]
		},
		subscription_second_title:{
			display:'Second Title',
			operator:[
			['=','='],
			['like','like']
			],
			opsi:[]
		},
		subscription_promo_id_type:{
			display:'Promo Type',
			operator:[],
			opsi:[
			['promoid','Promo Id'],
			['nominal','Nominal']
			]
		},
		subscription_promo_id:{
			display:'Promo Id',
			operator:[
			['=','='],
			['like','like']
			],
			opsi:[]
		},
		voucher_code:{
			display:'Voucher Code',
			operator:[
			['=','='],
			['like','like']
			],
			opsi:[]
		},
		used_by:{
			display:'Claimed By',
			operator:[
			['=','='],
			['like','like']
			],
			opsi:[]
		},
		id_outlet:{
			display:'Outlet',
			operator:[],
			opsi:{!!json_encode($outlets ?? [])!!}
		},
		subscription_total_voucher:{
			display:'Subscription Total Voucher',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'number'
		},
		subscription_start:{
			display:'Subscription Start',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'date'
		},
		subscription_end:{
			display:'Subscription End',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'date'
		},
		subscription_publish_start:{
			display:'Subscription Publish Start',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'date'
		},
		subscription_publish_end:{
			display:'Subscription Publish End',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'date'
		},
		subscription_voucher_start:{
			display:'Subscription Voucher Start',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'date'
		},
		subscription_voucher_expired:{
			display:'Subscription Voucher Expired',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'date'
		},
		subscription_voucher_duration:{
			display:'subscription Voucher Duration',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'number'
		},
		voucher_claim_time:{
			display:'Date & Time Claim Subscription',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'datetime'
		},
		voucher_redeem_time:{
			display:'Date & Time Redeem Voucher',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'datetime'
		},
		voucher_used_time:{
			display:'Date & Time Used Voucher',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'datetime'
		},
		user_limit:{
			display:'User Limit',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'number'
		},
		total_voucher_subscription:{
			display:'Total Voucher Subscription',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'number'
		},
		subscription_total_claimed:{
			display:'Subscription Total Claimed',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'number'
		},
		subscription_total_redeemed:{
			display:'Subscription Total Redeemed',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'number'
		},
		subscription_total_used:{
			display:'Subscription Total Used',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'number'
		},
		subscription_total_available:{
			display:'Subscription Total Available',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'number'
		},
		created_at:{
			display:'Created Date',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'date'
		},
		updated_at:{
			display:'Last Update',
			operator:[
			['=','='],
			['<','<'],
			['>','>'],
			['<=','<='],
			['>=','>=']
			],
			opsi:[],
			type:'date'
		},
	};
	database={
		operator: 'or',
		value: {!!json_encode(array_values($rule??[]))!!}
	};
	var updatedatetime=false;
	function optionWriter(value,show,option=''){
		return '<option value="'+value+'" '+option+'>'+show+'</option>'
	}
	function selectSubjectBuilder(rules,selected='',id='::n::'){
		var html='<select name="rule['+id+'][subject]" class="form-control input-sm select2 inputSubject" placeholder="Search Subject" style="width:100%" required>';
		ruless=Object.entries(rules);
		ruless.forEach(function(x){
			if(selected==x[0]){
				html+=optionWriter(x[0],x[1].display,'selected');
			}else{
				html+=optionWriter(x[0],x[1].display);
			}
		});
		html+='</select>';
		return html;
	}
	function selectOperatorBuilder(rules,selected='',id='::n::'){
		var html='<select name="rule['+id+'][operator]" class="form-control input-sm select2 inputOperator" placeholder="Search Operator" id="test" style="width:100%" required>';
		rules.forEach(function(x){
			if(selected==x[0]){
				html+=optionWriter(x[0],x[1],'selected');
			}else{
				html+=optionWriter(x[0],x[1]);
			}
		});
		html+='</select>';
		return html;
	}
	function selectOpsiBuilder(rules,selected='',id='::n::'){
		var html='<select name="rule['+id+'][parameter]" class="form-control input-sm select2 inputOpsi" placeholder="Search Operator" id="test" style="width:100%" required>';
		rules.forEach(function(x){
			if(selected==x[0]){
				html+=optionWriter(x[0],x[1],'selected');
			}else{
				html+=optionWriter(x[0],x[1]);
			}
		});
		html+='</select>';
		return html;
	}
	function inputBuilder(type,value='',id='::n::'){
		if(type==undefined){
			type='text';
		}
		if(type=='datetime'){
			updatedatetime=true;
			return '<input type="text" placeholder="Insert datetime" class="form-control datetime" name="rule['+id+'][parameter]" value="'+value+'"  required/>';
		}
		return '<input type="'+type+'" placeholder="Keyword" class="form-control" name="rule['+id+'][parameter]" value="'+value+'"  required/>';

	}
	function rowBuilder(val){
		var html='<div class="mt-repeater-cell" style="padding-bottom:10px" data-id="::n::">\
		<div class="col-md-12">\
		<div class="col-md-1">\
		<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline btnDelete">\
		<i class="fa fa-close"></i>\
		</a>\
		</div>\
		<div class="col-md-4">\
		::subjectOption::\
		</div>\
		<div class="col-md-4 optionCol">\
		::operatorOption::\
		</div>\
		<div class="col-md-3 valCol">\
		::otherVal::\
		</div>\
		</div>\
		</div>';
		html=html.replace('::subjectOption::',selectSubjectBuilder(rules,val[0]));
		if(rules[val[0]].operator.length>0){//is operator exist
			html=html.replace('::operatorOption::',selectOperatorBuilder(rules[val[0]].operator,val[1]));
			html=html.replace('::otherVal::',inputBuilder(rules[val[0]].type,val[2]));
		}else{
			html=html.replace('::operatorOption::',selectOpsiBuilder(rules[val[0]].opsi,val[1]));
			html=html.replace('::otherVal::','');
		}
		var lastId=$('#repeaterContainer .mt-repeater-cell').last().data('id');
		if(lastId==undefined){lastId=-1};
		html=html.replace(/::n::/g,lastId+1);
		return html;
	}
	function updateColumn(data){
		data.forEach(function(i){
			add(i);
		});
	}
	function add(newValue){
		if(newValue==undefined){
			var defaultCol=Object.keys(rules)[0];
			var defaultOperator=rules[defaultCol].operator[0][0];
			var newValue=[defaultCol,defaultOperator,''];
		}
		$('#repeaterContainer').append(rowBuilder(newValue));
		$('.select2').select2();
		if(updatedatetime){
			$('.datetime').datetimepicker({
		        format: "dd M yyyy hh:ii",
		        autoclose: true,
		        todayBtn: true,
		        minuteStep:5
		    });
			updatedatetime=false;
		}
	}
	$(document).ready(function(){
		if(database.value.length<1){
			var defaultCol=Object.keys(rules)[0];
			var defaultOperator=rules[defaultCol].operator[0][0];
			var newValue=[defaultCol,defaultOperator,''];
			database.value.push(newValue);
		}
		updateColumn(database.value);
		$('#addNewBtn').on('click',function(){add()});
		$('.form-body').on('click','.btnDelete',function(x){
			$(this).parents('.mt-repeater-cell').first().fadeOut(500,function(){$(this).remove()});
		});
		$('.form-body').on('change','.inputSubject',function(){
			var value=$(this).val();
			var parId=$(this).parents('.mt-repeater-cell').first().data('id');
			if(rules[value].operator.length>0){
				var oprview=selectOperatorBuilder(rules[value].operator,'',parId);
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').html(oprview);
				$(this).parents('.mt-repeater-cell').first().find('.valCol').html(inputBuilder(rules[value].type,'',parId));
				$(this).parents('.mt-repeater-cell').first().find('.valCol').show();
				$('.select2').select2();
			}else if(rules[value].opsi.length>0){
				var oprview=selectOpsiBuilder(rules[value].opsi,'',parId);
				$(this).parents('.mt-repeater-cell').first().find('.optionCol').html(oprview);
				$(this).parents('.mt-repeater-cell').first().find('.valCol').hide();
				$(this).parents('.mt-repeater-cell').first().find('.valCol').html('');
				$('.select2').select2();
			}
			if(updatedatetime){
				$('.datetime').datetimepicker({
			        format: "dd M yyyy hh:ii",
			        autoclose: true,
			        todayBtn: true,
			        minuteStep:5
			    });
				updatedatetime=false;
			}
		});
		$('input[name="operator"]').val(database.operator);
	})
</script>
@endsection
@section('filter')
<form action="#" method="post">
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption font-blue ">
				<i class="icon-settings font-blue "></i>
				<span class="caption-subject bold uppercase">Filter Subscription List</span>
			</div>
		</div>
		<div class="portlet-body form">
			<div class="form-body">
				<div class="form-group mt-repeater">
					<div data-repeater-list="conditions">
						<div data-repeater-item class="mt-repeater-item mt-overflow" id="repeaterContainer">
						</div>
					</div>
					<div class="form-action col-md-12">
						<div class="col-md-12">
							<button class="btn btn-success mt-repeater-add" type="button" id="addNewBtn">
								<i class="fa fa-plus"></i> Add New Condition
							</button>
						</div>
					</div>

					<div class="form-action col-md-12" style="margin-top:15px">
						<div class="col-md-5">
							<select name="operator" class="form-control input-sm " placeholder="Search Rule" required>
								<option value="and" @if (isset($operator) && $operator == 'and') selected @endif>Valid when all conditions are met</option>
								<option value="or" @if (isset($operator) && $operator == 'or') selected @endif>Valid when minimum one condition is met</option>
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
</form>
@if(isset($rule))
<div class="alert alert-block alert-info fade in">
	<button type="button" class="close" data-dismiss="alert"></button>
	<h4 class="alert-heading">Displaying search result :</h4>
	<p>{{count($subscription)}}</p><br>
	<form action="{{ url('subscription') }}" method="post">
		{{csrf_field()}}
		<button class="btn btn-sm btn-warning" name="clear" value="session">Reset</button>
	</form>
	<br>
</div>
@endif
@endsection