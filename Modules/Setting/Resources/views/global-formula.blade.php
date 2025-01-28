
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	   
<script>
  $(document).ready(function () {
        $("input[data-type='currency']").on({
            keyup: function() {
              formatCurrency($(this));
            },
            blur: function() { 
              formatCurrency($(this), "blur");
            }
        });


        function formatNumber(n) {
          // format number 1000000 to 1,234,567
          return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
          // appends $ to value, validates decimal side
          // and puts cursor back in right position.

          // get input value
          var input_val = input.val();

          // don't validate empty input
          if (input_val === "") { return; }

          // original length
          var original_len = input_val.length;

          // initial caret position 
          var caret_pos = input.prop("selectionStart");

          // check for decimal
          if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);


            // join number by .
            input_val = left_side ;

          } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            
          }

          // send updated string to input
          input.val(input_val);

          // put caret back in the right position
          var updated_len = input_val.length;
          caret_pos = updated_len - original_len + caret_pos;
          input[0].setSelectionRange(caret_pos, caret_pos);
        }
    })
    function addFormula(param){
		var textvalue = $('#formula').val();
		var textvaluebaru = textvalue+" "+param;
		$('#formula').val(textvaluebaru);
        }
    </script>
@endsection

@section('content')
 <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{ $title }}</span>
                @if (!empty($sub_title))
                    <i class="fa fa-circle"></i>
                @endif
            </li>
            @if (!empty($sub_title))
            <li>
                <span>{{ $sub_title }}</span>
            </li>
            @endif
        </ul>
    </div>
@include('layouts.notifications')
<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">This menu is used to set a Formula Pengosongan Tangki</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form role="form" class="form-horizontal" action="{{url('setting/setting-global-formula')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Formula<span class="required" aria-required="true">*</span>
                                            <i class="fa fa-question-circle tooltips" data-original-title="Rumus insentif yang digunakan dalam perhitungan pendapatan hairstylist (value * frekuensi)" data-container="body"></i>
                                        </label>
                                        <div class="col-md-6">
                                            <textarea name="value" id="formula" class="form-control" placeholder="Enter rumus perhitungan pengosongan tangki">{{$result['value']??''}}</textarea>
                                            <br>
                                            <div class="row">
                                                  @foreach($textreplace as $key=>$row)
                                                          <div class="col-md-6" style="margin-bottom:5px;">
                                                                  <span class="btn dark btn-xs btn-block btn-outline var" data-toggle="tooltip" title="{{ $row['message'] }}" onClick="addFormula('{{ $row['keyword'] }}');">{{ str_replace('_',' ',$row['keyword']) }}</span>
                                                          </div>
                                                  @endforeach
                                            </div>
                                        </div>
                                    </div>
                                              
					</div>
                                        
					<div class="form-actions" style="text-align:center;">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection 
