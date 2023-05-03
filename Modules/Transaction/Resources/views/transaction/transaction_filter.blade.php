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

		if(['receipt', 'name', 'phone', 'email', 'product_name', 'product_code', 'outlet_name', 'outlet_code', 'product_category'].includes(subject_value)){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('=', '=');
			operator_value.options[operator_value.options.length] = new Option('like', 'like');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'text';
		}
		
		if(subject_value == 'product_weight' || subject_value == 'product_price' || subject_value == 'product_tax'){
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
			operator_value.options[operator_value.options.length] = new Option('Completed', 'Completed');
			operator_value.options[operator_value.options.length] = new Option('Pending', 'Pending');
			operator_value.options[operator_value.options.length] = new Option('Cancelled', 'Cancelled');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}

		if(subject_value == 'transaction_status'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Pending', 'pending');
			operator_value.options[operator_value.options.length] = new Option('Received', 'receive_at');
			operator_value.options[operator_value.options.length] = new Option('Ready', 'ready_at');
			operator_value.options[operator_value.options.length] = new Option('Taken by driver', 'taken_by_driver');
			operator_value.options[operator_value.options.length] = new Option('Taken by customer', 'taken_by_customer');
			operator_value.options[operator_value.options.length] = new Option('Taken by system', 'taken_by_system');
			operator_value.options[operator_value.options.length] = new Option('Reject', 'reject_at');

			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}

		if(subject_value == 'pickup_by'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			operator_value.options[operator_value.options.length] = new Option('Pickup Order', 'Customer');
			operator_value.options[operator_value.options.length] = new Option('Delivery GO-SEND', 'GO-SEND');
			operator_value.options[operator_value.options.length] = new Option('Delivery WeHelpYou', 'Wehelpyou');
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}

		if(subject_value == 'id_product'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			@foreach($products as $product)
			operator_value.options[operator_value.options.length] = new Option("{{$product['product_code']}} - {{$product['product_name']}}", "{{$product['id_product']}}");
			@endforeach
			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}
		if(subject_value == 'id_outlet'){
			var operator = "conditions["+index+"][operator]";
			var operator_value = document.getElementsByName(operator)[0];
			for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
			@foreach($outlets as $outlet)
			operator_value.options[operator_value.options.length] = new Option("{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}", "{{$outlet['id_outlet']}}");
			@endforeach

			
			var parameter = "conditions["+index+"][parameter]";
			document.getElementsByName(parameter)[0].type = 'hidden';
		}
	}

</script>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-blue ">
			<i class="icon-settings font-blue "></i>
			<span class="caption-subject bold uppercase">Filter Transaction</span>
		</div>
	</div>
	<div class="portlet-body form">
		
		<div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">Date Start :</label>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_start" value="{{ $date_start }}">
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
                        <input type="date" class="form-control" name="date_end" value="{{ $date_end }}">
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
												<option value="receipt" @if ($con['subject'] == 'receipt') selected @endif>Receipt Number</option>
												<option value="pickup_by" @if ($con['subject'] == 'pickup_by') selected @endif>Transaction Type</option>
												<option value="name"  @if ($con['subject'] == 'name') selected @endif>Customer Name</option>
												<option value="phone" @if ($con['subject'] == 'phone') selected @endif>Customer Phone</option>
												<option value="email" @if ($con['subject'] == 'email') selected @endif>Customer Email</option>
												<option value="gender" @if ($con['subject'] == 'gender') selected @endif>Customer Gender</option>
												<option value="id_outlet" @if ($con['subject'] == 'id_outlet') selected @endif>Outlet</option>
												<option value="outlet_code" @if ($con['subject'] == 'outlet_code') selected @endif>Outlet Code</option>
												<option value="outlet_name" @if ($con['subject'] == 'outlet_name') selected @endif>Outlet Name</option>
												<option value="id_product" @if ($con['subject'] == 'id_product') selected @endif>Product</option>
												<option value="product_name" @if ($con['subject'] == 'product_name') selected @endif>Product Name</option>
												<option value="product_code" @if ($con['subject'] == 'product_code') selected @endif>Product Code</option>
												<option value="product_category" @if ($con['subject'] == 'product_category') selected @endif>Product Category</option>
												<option value="product_weight" @if ($con['subject'] == 'product_weight') selected @endif>Product Weight</option>
												<option value="product_price" @if ($con['subject'] == 'product_price') selected @endif>Product Price</option>
												<option value="product_tax" @if ($con['subject'] == 'product_tax') selected @endif>Product Tax</option>
												<option value="grand_total" @if ($con['subject'] == 'grand_total') selected @endif>Grand Total</option>
												<option value="status" @if ($con['subject'] == 'status') selected @endif>Payment Status</option>
												<option value="transaction_status" @if ($con['subject'] == 'transaction_status') selected @endif>Transaction Status</option>
												<!-- <option value="courier" @if ($con['subject'] == 'courier') selected @endif>Courier</option> -->
												<option value="order_id" @if ($con['subject'] == 'order_id') selected @endif>Order ID</option>
											</select>
										</div>
										<div class="col-md-4">
										<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
											@if ($con['subject'] == 'gender')
												<option value="Male" @if ($con['operator'] == 'Male') selected @endif>Male</option>
												<option value="Female" @if ($con['operator']  == 'Female') selected @endif>Female</option>
											@elseif ($con['subject'] == 'status')
												<option value="Completed" @if ($con['operator'] == 'Completed') selected @endif>Completed</option>
												<option value="Pending" @if ($con['operator'] == 'Pending') selected @endif>Pending</option>
												<option value="Cancelled" @if ($con['operator'] == 'Cancelled') selected @endif>Cancelled</option>
											@elseif ($con['subject'] == 'transaction_status')
												<option value="pending" @if ($con['operator'] == 'pending') selected @endif>Pending</option>
												<option value="receive_at" @if ($con['operator'] == 'receive_at') selected @endif>Received</option>
												<option value="ready_at" @if ($con['operator'] == 'ready_at') selected @endif>Ready</option>
												<option value="taken_by_driver" @if ($con['operator'] == 'taken_by_driver') selected @endif>Taken by driver</option>
												<option value="taken_by_customer" @if ($con['operator'] == 'taken_by_customer') selected @endif>Taken by customer</option>
												<option value="taken_by_system" @if ($con['operator'] == 'taken_by_system') selected @endif>Taken  by system</option>
												<option value="reject_at" @if ($con['operator'] == 'reject_at') selected @endif>Reject</option>
											@elseif ($con['subject'] == 'pickup_by')
												<option value="Customer" @if ($con['operator'] == 'Customer') selected @endif>Pickup Order</option>
												<option value="GO-SEND" @if ($con['operator'] == 'GO-SEND') selected @endif>Delivery GO-SEND</option>
												<option value="Wehelpyou" @if ($con['operator'] == 'Wehelpyou') selected @endif>Delivery Wehelpyou</option>
											@elseif ($con['subject'] == 'courier')
												<option value="psc" @if ($con['operator'] == 'psc') selected @endif>psc</option>
												<option value="jne" @if ($con['operator'] == 'jne') selected @endif>jne</option>
												<option value="pos" @if ($con['operator'] == 'pos') selected @endif>pos</option>
												<option value="tiki" @if ($con['operator'] == 'tiki') selected @endif>tiki</option>
												<option value="pcp" @if ($con['operator'] == 'pcp') selected @endif>pcp</option>
												<option value="esl" @if ($con['operator'] == 'esl') selected @endif>esl</option>
												<option value="rpx" @if ($con['operator'] == 'rpx') selected @endif>rpx</option>
												<option value="pandu" @if ($con['operator'] == 'pandu') selected @endif>pandu</option>
												<option value="wahana" @if ($con['operator'] == 'wahana') selected @endif>wahana</option>
												<option value="sicepat" @if ($con['operator'] == 'sicepat') selected @endif>sicepat</option>
												<option value="jnt" @if ($con['operator'] == 'jnt') selected @endif>jnt</option>
												<option value="pahala" @if ($con['operator'] == 'pahala') selected @endif>pahala</option>
												<option value="cahaya" @if ($con['operator'] == 'cahaya') selected @endif>cahaya</option>
												<option value="sap" @if ($con['operator'] == 'sap') selected @endif>sap</option>
												<option value="jet" @if ($con['operator'] == 'jet') selected @endif>jet</option>
												<option value="indah" @if ($con['operator'] == 'indah') selected @endif>indah</option>
												<option value="slis" @if ($con['operator'] == 'slis') selected @endif>slis</option>
												<option value="dse" @if ($con['operator'] == 'dse') selected @endif>dse</option>
												<option value="first" @if ($con['operator'] == 'first') selected @endif>first</option>
												<option value="ncs" @if ($con['operator'] == 'ncs') selected @endif>ncs</option>
												<option value="star" @if ($con['operator'] == 'star') selected @endif>star</option>
											@elseif ($con['subject'] == 'product_weight' || $con['subject'] == 'product_price' || $con['subject'] == 'product_tax')
												<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
												<option value=">=" @if ($con['operator'] == '>=') selected @endif>>=</option>
												<option value=">" @if ($con['operator'] == '>') selected @endif>></option>
												<option value="<=" @if ($con['operator'] == '<=') selected @endif><=</option>
												<option value="<" @if ($con['operator'] == '<') selected @endif><</option>
											@elseif ($con['subject'] == 'id_outlet')
												@foreach($outlets as $outlet)
												<option value="{{$outlet['id_outlet']}}" @if ($con['operator'] == $outlet['id_outlet']) selected @endif>{{$outlet['outlet_code']}} - {{$outlet['outlet_name']}}</option>
												@endforeach
											@elseif ($con['subject'] == 'id_product')
												@foreach($products as $product)
												<option value="{{$product['id_product']}}" @if ($con['operator'] == $product['id_product']) selected @endif>{{$product['product_code']}} - {{$product['product_name']}}</option>
												@endforeach
											@else
												<option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
												<option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
											@endif
										</select>
										</div>

										@if (in_array($con['subject'], ['gender', 'status', 'courier', 'id_outlet', 'id_product', 'pickup_by', 'transaction_status']))
											<div class="col-md-3">
												<input type="hidden" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
											</div>
										@else
											<div class="col-md-3">
												<input type="text" placeholder="Keyword" class="form-control" name="parameter" required @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
											</div>
										@endif
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
											<option value="receipt">Receipt Number</option>
											<option value="name">Customer Name</option>
											<option value="phone">Customer Phone</option>
											<option value="email">Customer Email</option>
											<option value="gender">Customer Gender</option>
											<option value="id_outlet">Outlet</option>
											<option value="outlet_code">Outlet Code</option>
											<option value="outlet_name">Outlet Name</option>
											<option value="id_product">Product</option>
											<option value="product_name">Product Name</option>
											<option value="product_code">Product Code</option>
											<option value="product_category">Product Category</option>
											<option value="product_weight">Product Weight</option>
											<option value="product_price">Product Price</option>
											<option value="product_tax">Product Tax</option>
											<option value="grand_total">Grand Total</option>
											<option value="status">Payment Status</option>
											<option value="transaction_status">Transaction Status</option>
											<!-- <option value="courier">Courier</option> -->
											<option value="order_id">Order ID</option>
										</select>
									</div>
									<div class="col-md-4">
									<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
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
											<option value="receipt">Receipt Number</option>
											<option value="pickup_by">Transaction Type</option>
											<option value="name">Customer Name</option>
											<option value="phone">Customer Phone</option>
											<option value="email">Customer Email</option>
											<option value="gender">Customer Gender</option>
											<option value="id_outlet">Outlet</option>
											<option value="outlet_code">Outlet Code</option>
											<option value="outlet_name">Outlet Name</option>
											<option value="id_product">Product</option>
											<option value="product_name">Product Name</option>
											<option value="product_code">Product Code</option>
											<option value="product_category">Product Category</option>
											<option value="product_weight">Product Weight</option>
											<option value="product_price">Product Price</option>
											<option value="product_tax">Product Tax</option>
											<option value="grand_total">Grand Total</option>
											<option value="status">Payment Status</option>
											<option value="transaction_status">Transaction Status</option>
											<!-- <option value="courier">Courier</option> -->
											<option value="order_id">Order ID</option>
										</select>
									</div>
									<div class="col-md-4">
									<select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" onChange="changeSubject(this.name)" style="width:100%">
										<option value="=" selected>=</option>ororororor
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>