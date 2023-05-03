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

        if(subject_value == 'status'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('Booking is received', '1');
            operator_value.options[operator_value.options.length] = new Option('Driver is found and on their way to pick-up location', '8');
            operator_value.options[operator_value.options.length] = new Option('Driver is enroute to deliver the item', '9');
            operator_value.options[operator_value.options.length] = new Option('Booking is cancelled by CS', '91');
            operator_value.options[operator_value.options.length] = new Option('Completed', '2');
            operator_value.options[operator_value.options.length] = new Option('Driver not found', '95');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        }else if(subject_value == 'transaction_shipment' || subject_value == 'transaction_grandtotal'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('=', '=');
            operator_value.options[operator_value.options.length] = new Option('>', '>');
            operator_value.options[operator_value.options.length] = new Option('>=', '>=');
            operator_value.options[operator_value.options.length] = new Option('<', '<');
            operator_value.options[operator_value.options.length] = new Option('<=', '<=');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'text';
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
                                                    <option value="outlet_code" @if ($con['subject'] == 'outlet_code') selected @endif>Outlet Code</option>
                                                    <option value="outlet_name" @if ($con['subject'] == 'outlet_name') selected @endif>Outlet Name</option>
                                                    <option value="transaction_receipt_number" @if ($con['subject'] == 'transaction_receipt_number') selected @endif>Receipt Number</option>
                                                    <option value="order_id" @if ($con['subject'] == 'order_id') selected @endif>Order ID Number</option>
                                                    <option value="transaction_grandtotal" @if ($con['subject'] == 'transaction_grandtotal') selected @endif>Grand Total</option>
                                                    <option value="transaction_shipment" @if ($con['subject'] == 'transaction_shipment') selected @endif>Price Wehelpyou</option>
                                                    <option value="destination_name" @if ($con['subject'] == 'destination_name') selected @endif>Receiver Name</option>
                                                    <option value="destination_phone" @if ($con['subject'] == 'destination_phone') selected @endif>Receiver Phone</option>
                                                    <option value="driver_name" @if ($con['subject'] == 'driver_name') selected @endif>Driver Name</option>
                                                    <option value="driver_phone" @if ($con['subject'] == 'driver_phone') selected @endif>Driver Phone</option>
                                                    <option value="status" @if ($con['subject'] == 'status') selected @endif>Status</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                   @if($con['subject'] == 'status')
                                                        <option value="1" @if ($con['operator']  == '1') selected @endif>Booking is received</option>
                                                        <option value="8" @if ($con['operator']  == '8') selected @endif>Driver is found and on their way to pick-up location</option>
                                                        <option value="9" @if ($con['operator']  == '9') selected @endif>Driver is enroute to deliver the item</option>
                                                        <option value="91" @if ($con['operator']  == '91') selected @endif>Booking is cancelled by CS</option>
                                                        <option value="2" @if ($con['operator']  == '2') selected @endif>Completed</option>
                                                        <option value="95" @if ($con['operator']  == '95') selected @endif>Driver not found</option>
                                                    @elseif($con['subject'] == 'transaction_shipment' || $con['subject'] == 'transaction_grandtotal')
                                                        <option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
                                                        <option value=">" @if ($con['operator']  == '>') selected @endif>></option>
                                                        <option value=">=" @if ($con['operator'] == '>=') selected @endif>>=</option>
                                                        <option value="<" @if ($con['operator'] == '<') selected @endif><</option>
                                                        <option value="<=" @if ($con['operator'] == '<=') selected @endif><=</option>
                                                    @else
                                                        <option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
                                                        <option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
                                                    @endif
                                                </select>
                                            </div>

                                            @if ($con['subject'] == 'status')
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
                                                    <option value="outlet_code">Outlet Code</option>
                                                    <option value="outlet_name">Outlet Name</option>
                                                    <option value="transaction_grandtotal">Grand Total</option>
                                                    <option value="transaction_receipt_number">Receipt Number</option>
                                                    <option value="order_id">Order ID Number</option>
                                                    <option value="transaction_shipment">Price Wehelpyou</option>
                                                    <option value="destination_name">Receiver Name</option>
                                                    <option value="destination_phone">Receiver Phone</option>
                                                    <option value="driver_name">Driver Name</option>
                                                    <option value="driver_phone">Driver Phone</option>
                                                    <option value="status">Status</option>
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
                                            <option value="outlet_code">Outlet Code</option>
                                            <option value="outlet_name">Outlet Name</option>
                                            <option value="transaction_receipt_number">Receipt Number</option>
                                            <option value="order_id">Order ID Number</option>
                                            <option value="transaction_grandtotal">Grand Total</option>
                                            <option value="transaction_shipment">Price Wehelpyou</option>
                                            <option value="destination_name">Receiver Name</option>
                                            <option value="destination_phone">Receiver Phone</option>
                                            <option value="driver_name">Driver Name</option>
                                            <option value="driver_phone">Driver Phone</option>
                                            <option value="status">Status</option>
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
                        @if(!empty($trx))
                        <a class="btn green-jungle" id="btn-export" href="{{url()->current()}}/export">Export</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>