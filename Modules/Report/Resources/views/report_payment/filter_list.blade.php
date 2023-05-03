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
            operator_value.options[operator_value.options.length] = new Option('Pending', 'Pending');
            operator_value.options[operator_value.options.length] = new Option('Paid', 'Paid');
            operator_value.options[operator_value.options.length] = new Option('Completed', 'Completed');
            operator_value.options[operator_value.options.length] = new Option('Cancelled', 'Cancelled');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        }else if(subject_value == 'reject_type'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('No Reject', '0');
            operator_value.options[operator_value.options.length] = new Option('Reject To Point', '1');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        }else if(subject_value == 'type'){
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('Deals', 'Deals');
            operator_value.options[operator_value.options.length] = new Option('Subscription', 'Subscription');
            operator_value.options[operator_value.options.length] = new Option('Transaction', 'Transaction');

            var parameter = "conditions["+index+"][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        }else if(subject_value == 'grandtotal' || subject_value == 'amount'){
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
                        <input type="date" class="form-control date-picker" name="date_start" value="{{ $date_start }}">
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
                        <input type="date" class="form-control date-picker" name="date_end" value="{{ $date_end }}">
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
                                                    <option value="type" @if ($con['subject'] == 'type') selected @endif>Type</option>
                                                    <option value="reject_type" @if ($con['subject'] == 'reject_type') selected @endif>Reject Type</option>
                                                    <option value="name" @if ($con['subject'] == 'name') selected @endif>Customer Name</option>
                                                    <option value="phone" @if ($con['subject'] == 'phone') selected @endif>Customer Phone</option>
                                                    <option value="transaction_receipt_number" @if ($con['subject'] == 'transaction_receipt_number') selected @endif>Receipt Number</option>
                                                    <option value="grandtotal" @if ($con['subject'] == 'grandtotal') selected @endif>Grand Total</option>
                                                    <option value="amount" @if ($con['subject'] == 'amount') selected @endif>Amount</option>
                                                    <option value="status" @if ($con['subject'] == 'status') selected @endif>Status</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                    @if($con['subject'] == 'status')
                                                        <option value="Pending" @if ($con['operator']  == 'Pending') selected @endif>Pending</option>
                                                        <option value="Paid" @if ($con['operator']  == 'Paid') selected @endif>Paid</option>
                                                        <option value="Completed" @if ($con['operator']  == 'Completed') selected @endif>Completed</option>
                                                        <option value="Cancelled" @if ($con['operator']  == 'Cancelled') selected @endif>Cancelled</option>
                                                    @elseif($con['subject'] == 'reject_type')
                                                        <option value="0" @if ($con['operator']  == '0') selected @endif>No Reject</option>
                                                        <option value="1" @if ($con['operator']  == '1') selected @endif>Reject To Point</option>
                                                    @elseif($con['subject'] == 'type')
                                                        <option value="Deals" @if ($con['operator']  == 'Deals') selected @endif>Deals</option>
                                                        <option value="Subscription" @if ($con['operator']  == 'Subscription') selected @endif>Subscription</option>
                                                        <option value="Transaction" @if ($con['operator']  == 'Transaction') selected @endif>Transaction</option>
                                                    @elseif($con['subject'] == 'amount' || $con['subject'] == 'grandtotal')
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

                                            @if ($con['subject'] == 'status' || $con['subject'] == 'type' || $con['subject'] == 'reject_type')
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
                                                    <option value="type">Type</option>
                                                    <option value="reject_type">Reject Type</option>
                                                    <option value="name">Customer Name</option>
                                                    <option value="phone">Customer Phone</option>
                                                    <option value="transaction_receipt_number">Receipt Number</option>
                                                    <option value="grandtotal">Grand Total</option>
                                                    <option value="amount">Amount</option>
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
                                            <option value="type">Type</option>
                                            <option value="reject_type">Reject Type</option>
                                            <option value="name">Customer Name</option>
                                            <option value="phone">Customer Phone</option>
                                            <option value="transaction_receipt_number">Receipt Number</option>
                                            <option value="grandtotal">Grand Total</option>
                                            <option value="amount">Amount</option>
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
                        @if(!empty($data))
                        <a class="btn green-jungle" id="btn-export" href="{{url('report/payment/export')}}/{{$type}}">Export</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>