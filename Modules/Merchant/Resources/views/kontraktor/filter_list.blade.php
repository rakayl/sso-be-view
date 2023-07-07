<script>
    function changeSelect() {
        setTimeout(function () {
            $(".select2").select2({
                placeholder: "Search"
            });
        }, 100);
    }
    function changeSubject(val) {
        var subject = val;
        var temp1 = subject.replace("conditions[", "");
        var index = temp1.replace("][subject]", "");
        var subject_value = document.getElementsByName(val)[0].value;

        if (subject_value == 'merchant_completed_step') {
            var operator = "conditions[" + index + "][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for (i = operator_value.options.length - 1; i >= 0; i--)
                operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('Completed', '1');
            operator_value.options[operator_value.options.length] = new Option('Not Complete', '0');

            var parameter = "conditions[" + index + "][parameter]";
            document.getElementsByName(parameter)[0].type = 'hidden';
        }else{
            var operator = "conditions[" + index + "][operator]";
            var operator_value = document.getElementsByName(operator)[0];
            for (i = operator_value.options.length - 1; i >= 0; i--)
                operator_value.remove(i);
            operator_value.options[operator_value.options.length] = new Option('=', '=');
            operator_value.options[operator_value.options.length] = new Option('like', 'like');

            var parameter = "conditions[" + index + "][parameter]";
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
                <label class="col-md-2 control-label">{{ $title_date_start??'Date Start' }} :</label>
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

                <label class="col-md-2 control-label">{{ $title_date_end??'Date End' }} :</label>
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
                                        @if($type == 'candidate')
                                        <option value="merchant_completed_step" @if ($con['subject'] == 'merchant_completed_step') selected @endif>Complete Step</option>
                                        @endif
                                        <option value="outlet_name" @if ($con['subject'] == 'merchant_name') selected @endif>Name</option>
                                        <option value="outlet_phone" @if ($con['subject'] == 'merchant_phone') selected @endif>Phone</option>
                                        <option value="outlet_email" @if ($con['subject'] == 'merchant_email') selected @endif>Email</option>
                                        <option value="merchant_pic_name" @if ($con['subject'] == 'merchant_pic_name') selected @endif>PIC Name</option>
                                        <option value="merchant_pic_phone" @if ($con['subject'] == 'merchant_pic_phone') selected @endif>PIC Phone</option>
                                        <option value="merchant_pic_email" @if ($con['subject'] == 'merchant_pic_email') selected @endif>PIC Email</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="operator" class="form-control input-sm select2" placeholder="Search Operator" id="test" style="width:100%">
                                        @if($con['subject'] == 'merchant_completed_step')
                                            <option value="1" @if ($con['operator'] == '1') selected @endif>Completed</option>
                                            <option value="0" @if ($con['operator']  == '0') selected @endif>Not Complete</option>
                                        @else
                                            <option value="=" @if ($con['operator'] == '=') selected @endif>=</option>
                                            <option value="like" @if ($con['operator']  == 'like') selected @endif>Like</option>
                                        @endif
                                    </select>
                                </div>

                                @if ($con['subject'] == 'merchant_completed_step')
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
                                        @if($type == 'candidate')
                                        <option value="merchant_completed_step">Complete Step</option>
                                        @endif
                                        <option value="outlet_name">Name</option>
                                        <option value="outlet_phone">Phone</option>
                                        <option value="outlet_email">Email</option>
                                        <option value="merchant_pic_name">PIC Name</option>
                                        <option value="merchant_pic_phone">PIC Phone</option>
                                        <option value="merchant_pic_email">PIC Email</option>
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
                                        @if($type == 'candidate')
                                        <option value="merchant_completed_step">Complete Step</option>
                                        @endif
                                        <option value="outlet_name">Name</option>
                                        <option value="outlet_phone">Phone</option>
                                        <option value="outlet_email">Email</option>
                                        <option value="merchant_pic_name">PIC Name</option>
                                        <option value="merchant_pic_phone">PIC Phone</option>
                                        <option value="merchant_pic_email">PIC Email</option>
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