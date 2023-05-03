@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
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
    </div><br>

    @include('layouts.notifications')
    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Total Transaction</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="form-group mt-repeater">
                    <div data-repeater-list="list">
                        <div data-repeater-item class="mt-repeater-item mt-overflow">
                            <div class="mt-repeater-cell">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control total_transaction" name="total_transaction" placeholder="Total Transaction" @if (isset($lists)) value="{{ count($lists) }}" @else value="0" @endif>
                                            <span class="input-group-addon">
                                                X
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <a href="javascript:;" class="btn btn-success submit_total">
                                        <i class="fa fa-plus"></i> Create Setting</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>


    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">{{env('POINT_NAME', 'Points')}} Received</span>
            </div>
        </div>
        <div class="portlet-body">
            <form action="{{ url('transaction/setting/cashback/update') }}" method="POST" name="sub" id="form">
                {{ csrf_field() }}
        	<div class="form-group mt-repeater">
                @if (empty($lists))
                    <div data-repeater-list="list" class="parent">

                    </div>
                @else
                    <div data-repeater-list="list" class="parent">
                    @foreach ($lists as $key => $val)
                        <div data-repeater-item class="mt-repeater-item mt-overflow child style{{ $key }}">
                            <div class="mt-repeater-cell">
                            	<div class="col-md-12">
                                    <div class="col-md-3">
                                        <label for="exampleInputPassword1" style="padding-bottom: 15px;"></label>
                                        <div class="input-group">
                                            <label for="exampleInputPassword1">Transaction #{{ $key + 1 }} : </label>
                                        </div>
                                    </div>
                            		<div class="col-md-3">
                            			<label for="exampleInputPassword1">{{env('POINT_NAME', 'Points')}} Percent : </label>
                            			<div class="input-group">
                                            <input type="text" class="form-control price" name="cashback_percent" placeholder="Cashback Percent" value="{{ $val['cashback_percent'] }}" required>
                                            <span class="input-group-addon">
                                                %
                                            </span>
                                        </div>
                            		</div>

                            		<div class="col-md-4">
                            			<label for="exampleInputPassword1">{{env('POINT_NAME', 'Points')}} Maximum : </label>
                            			<input type="text" class="form-control price" name="cashback_maximum" placeholder="Cashback Maximum" value="{{ $val['cashback_maximum'] }}" required>
                            		</div>
                            	</div>

                                <input type="hidden" name="id" value="{{ $val['id_transaction_setting'] }}">
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>

            <input type="submit" class="btn btn-primary" name="submit" value="Save">
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        function check() {
            var total_class = $('.child').length;
            if (total_class == '') {
                $('input[type=submit]').attr('disabled', 'disabled');
            } else {
                $('input[type=submit]').removeAttr('disabled');
            }
        }

    	window.onload = function() {
            check();

            $('.price').each(function() {
                var input = $(this).val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $(this).val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "id" );
                });
            });

            $('#form').submit(function() {
                $('.price').each(function() {
                    var number = $( this ).val().replace(/[($)\s\._\-]+/g, '');
                    $(this).val(number);
                });
            });



            $(document).on('keyup', '.price', numberFormat);
            $(document).on('blur', '.price', checkFormat);

            function checkFormat(event){
                var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
                if(!$.isNumeric(data)){
                    $( this ).val("");
                }
            }

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
              } );
            }

            $(document).on('click', '.submit_total', function() {
                var input_total = $('.total_transaction').val();

                if ($.isNumeric(input_total)) {

                } else {
                    swal('Error', 'Total transaction should be numeric.', 'error')
                    .then((value) => {
                        $('.total_transaction').val('');
                        $('.total_transaction').focus();
                    });

                    return false;
                }

                if (input_total == '') {
                    swal('Error', 'Total transaction cannot be empty.', 'error')
                    .then((value) => {
                        $('.total_transaction').focus();
                    });

                    return false;
                }

                var total_class = $('.child').length;
                if (total_class == input_total) {
                    return false;
                }

                if (total_class < input_total) {
                    var key_input = total_class;
                    for (var i = total_class + 1; i <= input_total; i++) {
                        var new_input = '<div data-repeater-item class="mt-repeater-item mt-overflow child style'+key_input+'">\
                            <div class="mt-repeater-cell">\
                                <div class="col-md-12">\
                                    <div class="col-md-3">\
                                        <label for="exampleInputPassword1" style="padding-bottom: 15px;"></label>\
                                        <div class="input-group">\
                                            <label for="exampleInputPassword1">Transaction #'+i+' : </label>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-3">\
                                        <label for="exampleInputPassword1">Cashback Percent : </label>\
                                        <div class="input-group">\
                                            <input type="text" class="form-control price" name="list['+key_input+'][cashback_percent]" placeholder="Cashback Percent" value="" required>\
                                            <span class="input-group-addon">\
                                                %\
                                            </span>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-4">\
                                        <label for="exampleInputPassword1">Cashback Maximum : </label>\
                                        <input type="text" class="form-control price" name="list['+key_input+'][cashback_maximum]" placeholder="Cashback Maximum" value="" required>\
                                    </div>\
                                </div>\
                                <input type="hidden" name="list['+key_input+'][id]" value="">\
                            </div>\
                        </div>';

                        $(new_input).appendTo('.parent');

                        key_input = key_input + 1;
                    }
                }

                if (total_class > input_total) {
                    for (var i = total_class - 1; i >= input_total; i--) {
                        $('.style'+i).remove();
                    }
                }

                check();
            });
        }

    </script>
@endsection
