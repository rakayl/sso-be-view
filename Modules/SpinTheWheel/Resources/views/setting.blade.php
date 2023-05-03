@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        // count weight value
        const total_weight_value = 100.0;
        var num_input_items = $('.spin-value').length;
        var weight_value;
        var spin_value;

        $('.spin-item').on('keydown keyup change focus', '.spin-value', function(e){
        	// mask input 100
        	if ( $(this).val()>100 && e.keyCode!==46 && e.keyCode!==8 ) {
        		// 46 = delete, 8 = backspace
        		e.preventDefault();
        		$(this).val(100);
        	}
        	else{
	        	updateWeightValue($(this));
        	}
        });

        function updateWeightValue(element){
        	weight_value = 0;
        	countSpinValue();
		    // console.log("sp  " + spin_value);

			// get the rest of weight value
	    	weight_value = total_weight_value - spin_value;
	    	// console.log("ww " + weight_value);

	    	// get order of row
	    	var index = element.parent().parent().index();
	    	var next_spin_value = nextSpinValue(index);

	    	// add weight_value to next or 1st element
	    	if(next_spin_value.length > 0){
	    		var next_value_e = next_spin_value;
	    	}
	    	else{
        		var next_value_e = $('.spin-item .mt-repeater-item').eq(0).find('.spin-value');
	    	}
	    	var next_value = next_value_e.val();
	    	// console.log("======== " + next_value);
	    	next_value = parseFloat(next_value);
    		// convert any falsey value to 0
    		next_value = next_value || 0;

	    	// if next_value + weight_value = negative, share value to other input
	    	if (next_value + weight_value < 0) {
	    		var this_value = element.val();
	    		weight_value = total_weight_value - parseFloat(this_value);
	    		// get average value for other input
	    		next_value = weight_value / (num_input_items-1);
	    		// fill other input with average
	    		for (var i = 0; i < num_input_items; i++) {
	    			if (i != index) {
	    				$('.spin-item .mt-repeater-item').eq(i).find('.spin-value').val(next_value);
	    			}
        		}
	    	}
	    	else {
		    	next_value += weight_value;
		    	// update value
		    	next_value_e.val(next_value);
	    	}
        }

        // update spin_value (total input value)
        function countSpinValue(){
        	spin_value = 0;
        	$('.spin-value').each(function() {
	    		var value = $(this).val();
	    		if (value > 100) {
	    			$(this).val(100);
	    			value = 100;
	    		}
	    		else if (value < 0) {
	    			$(this).val(0);
	    			value = 0;
	    		}
	    		value = parseFloat(value);
	    		// convert any falsey value to 0
	    		value = value || 0;
	    		spin_value += value;
			});
        }

        function nextSpinValue(index) {
        	return $('.spin-item .mt-repeater-item').eq( index+1 ).find('.spin-value');
        }

        // validate form
        $('form').on('submit', function(e){
        	countSpinValue();

        	if (spin_value != 100) {
        		e.preventDefault();
        		alert("Total chance value should be = 100");
    		}
        });

        //  form repeater
        $('.mt-repeater').repeater({
            show: function () {
                $(this).slideDown();
                // init select2
                $('.mt-repeater-item').last().find('.select2').select2();
                // weight value
                num_input_items += 1;
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    var input_spin_next = $(this).next().find('.spin-value');
                    var spin_value_removed = $(this).find('.spin-value').val();
                    var spin_value_next = input_spin_next.val();
                    // remove element
                    $(this).slideUp(deleteElement);
                    // update after element removed
                    // add removed value to the next value
                    var new_value = parseFloat(spin_value_removed) + parseFloat(spin_value_next);
                    input_spin_next.val(new_value);
                    // input weight value counter
                    num_input_items -= 1;
                }
            },
        });


    </script>
@endsection

@section('content')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">Home</a>
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
    </div><br>

    @include('layouts.notifications')

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-dark sbold uppercase font-red">Spin The Wheel Setting</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Spin The Wheel Point
                            <span class="required" aria-required="true"> *
                            </span>
                            <i class="fa fa-question-circle tooltips" data-original-title="Poin yang diperlukan untuk bermain spin the wheel" data-container="body"></i>
                        </label>
                        <div class="col-md-7">
                            <div class="input-icon right">
                                <input type="text" placeholder="Spin The Wheel Point" class="form-control" name="spin_the_wheel_point" value="{{ $spin_the_wheel_point }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-body">
                    <div class="form-group">
		                <div class="col-md-8">Item
		                	<span class="required" aria-required="true"> *
	                        </span>
		                </div>
		                <div class="col-md-4">Chance
		                	<span class="required" aria-required="true"> *
	                        </span>
	                        <i class="fa fa-question-circle tooltips" data-original-title="Bobot atau kesempatan memenangkan sebuah item. Isi dengan angka 0-100. Jumlah keseluruhan item harus = 100." data-container="body"></i>
		                </div>
	                </div>

                    <div class="mt-repeater spin-item">
                        <div class="form-group" data-repeater-list="spin_weighted_items">
			            @if($spin_weighted_items != null)
			                @foreach($spin_weighted_items as $key => $spin_item)
			                <div class="mt-repeater-item mt-overflow" data-repeater-item>
			                	<input type="hidden" name="id_spin_the_wheel" value="{{ $spin_item['id_spin_the_wheel'] }}">
				                <div class="col-md-8">
			                        <div class="input-icon right">
			                            <select class="form-control select2" name="id_deals" data-placeholder="Select Item" required>
			                            <optgroup label="Item List">
			                                @if (!empty($items))
		                                        @foreach ($items as $item)
		                                            <option value="{{ $item['id_deals'] }}" {{ ($item['id_deals']==$spin_item['id_deals']) ? 'selected' : '' }}>{{ str_limit($item['deals_title'], 20) }}</option>
		                                        @endforeach
			                                @endif
			                            </optgroup>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="col-md-2">
			                    	<input type="text" name="value" class="form-control spin-value" required value="{{ $spin_item['value'] }}">
			                    </div>
	                            <div class="col-md-2">
	                                <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-del-right mt-repeater-btn-inline">
	                                    <i class="fa fa-close"></i>
	                                </a>
	                            </div>
			                </div>
			                @endforeach
			            @else
                            <div class="mt-repeater-item mt-overflow" data-repeater-item>
				                <div class="col-md-4">
			                        <div class="input-icon right">
			                            <select class="form-control select2" name="id_deals" data-placeholder="Select Item" required>
			                            <optgroup label="Item List">
			                                @if (!empty($items))
		                                        @foreach ($items as $item)
		                                            <option value="{{ $item['id_deals'] }}">{{ str_limit($item['deals_title'], 20) }}</option>
		                                        @endforeach
			                                @endif
			                            </optgroup>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="col-md-4">
			                    	<input type="text" name="value" class="form-control spin-value" required>
			                    </div>
	                            <div class="col-md-2">
	                                <a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-del-right mt-repeater-btn-inline">
	                                    <i class="fa fa-close"></i>
	                                </a>
	                            </div>
			                </div>
			            @endif
			            </div>
                        <!-- add btn -->
                        <a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
                        <i class="fa fa-plus"></i> Add Item</a>
                    </div>

                </div>

                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="text-center">
                            <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection