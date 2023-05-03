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

        if(subject_value == 'outlet_dont_have_account') {
            var parameter = "conditions["+index+"][parameter]";
            var operator = "conditions["+index+"][operator]";
            document.getElementsByName(parameter)[0].required = false;
            document.getElementsByName(operator)[0].required = false;
            $('[name="' + parameter + '"]').closest('.param').hide();
            $('[name="' + operator + '"]').closest('.oper').hide();
        }else{
            var operator = "conditions["+index+"][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for(i = operator_value.options.length - 1 ; i >= 0 ; i--) operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('=', '=');
            operator_value.options[operator_value.options.length] = new Option('like', 'like');

            var parameter = "conditions["+index+"][parameter]";
            console.log(operator);
            console.log(parameter);
            document.getElementsByName(parameter)[0].required = true;
            document.getElementsByName(operator)[0].required = true;
            $('[name="' + parameter + '"]').closest('.param').show();
            $('[name="' + operator + '"]').closest('.oper').show();

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
                                                    <option value="outlet_code" @if ($con['subject'] == 'outlet_code') selected @endif>Outlet Code</option>
                                                    <option value="outlet_name" @if ($con['subject'] == 'outlet_name') selected @endif>Outlet Name</option>
                                                    <option value="outlet_dont_have_account" @if ($con['subject'] == 'outlet_dont_have_account') selected @endif>Outlet don't Have Account</option>
                                                    <option value="beneficiary_name" @if ($con['subject'] == 'beneficiary_name') selected @endif>Beneficiary Name</option>
                                                    <option value="beneficiary_alias" @if ($con['subject'] == 'beneficiary_alias') selected @endif>Beneficiary Alias</option>
                                                    <option value="beneficiary_account" @if ($con['subject'] == 'beneficiary_account') selected @endif>Beneficiary Account</option>
                                                    <option value="beneficiary_email" @if ($con['subject'] == 'beneficiary_email') selected @endif>Beneficiary Email</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="oper" @if($con['subject'] === 'outlet_dont_have_account') style="display: none" @endif>
                                                    <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                        <option value="=" @if (isset($con['operator']) && $con['operator'] == '=') selected @endif>=</option>
                                                        <option value="like" @if (isset($con['operator']) && $con['operator']  == 'like') selected @endif>Like</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="param" @if($con['subject'] === 'outlet_dont_have_account') style="display: none" @endif>
                                                    <input type="text" placeholder="Keyword" class="form-control" name="parameter" @if($con['subject'] !== 'outlet_dont_have_account') required @endif  @if (isset($con['parameter'])) value="{{ $con['parameter'] }}" @endif/>
                                                </div>
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
                                                    <option value="outlet_code">Outlet Code</option>
                                                    <option value="outlet_dont_have_account">Outlet don't Have Account</option>
                                                    <option value="outlet_name">Outlet Name</option>
                                                    <option value="beneficiary_name">Beneficiary Name</option>
                                                    <option value="beneficiary_alias">Beneficiary Alias</option>
                                                    <option value="beneficiary_account">Beneficiary Account</option>
                                                    <option value="beneficiary_email">Beneficiary Email</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="oper">
                                                    <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                        <option value="=" selected>=</option>
                                                        <option value="like">Like</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="param">
                                                    <input type="text" placeholder="Keyword" class="form-control" name="parameter" />
                                                </div>
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
                                            <option value="outlet_dont_have_account">Outlet don't Have Account</option>
                                            <option value="beneficiary_name">Beneficiary Name</option>
                                            <option value="beneficiary_alias">Beneficiary Alias</option>
                                            <option value="beneficiary_account">Beneficiary Account</option>
                                            <option value="beneficiary_email">Beneficiary Email</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="oper">
                                            <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                                <option value="=" selected>=</option>
                                                <option value="like">Like</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="param">
                                            <input type="text" placeholder="Keyword" class="form-control" name="parameter" />
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