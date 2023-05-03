@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('css/custom.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('js/courier.js') }}" type="text/javascript"></script>
@endsection

@section('content')
@php
    // print_r($list['courier']);die();
@endphp
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
    {{ csrf_field() }}
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-green">
                <i class="icon-pin font-green"></i>
                <span class="caption-subject bold uppercase"> Internal Courier Setting </span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <h3 class="">Update Setting Delivery Standar <i class="fa fa-question-circle tooltips" data-original-title="Rumus untuk menghitung minimum value saat menggunakan kurir internal" data-container="body"></i> </h3>
                    <hr>
                    <div class="m-grid m-grid-demo">
                        <div class="m-grid-row">
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center">Value
                                <i class="fa fa-question-circle tooltips" data-original-title="Klik salah satu value di samping untuk di masukkan kedalam kolom result dan dijadikan rumus" data-container="body"></i>
                            </div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="subtotal" type="button" class="button-drag btn blue-hoki value" data-text="Subtotal" onclick="setCourier(event, 'subtotal')">Subtotal
                                <i class="fa fa-question-circle tooltips" data-original-title="Hasil Subtotal Transaksi" data-container="body"></i>
                            </button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="discount" type="button" class="button-drag btn green-meadow value" data-text="Discount" onclick="setCourier(event, 'discount')">Discount
                                <i class="fa fa-question-circle tooltips" data-original-title="Total diskon Transaksi" data-container="body"></i>
                            </button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="shipping" type="button" class="button-drag btn btn-success value" data-text="Shipping" onclick="setCourier(event, 'shipping')">Shipping
                                <i class="fa fa-question-circle tooltips" data-original-title="Total biaya pengiriman Transaksi" data-container="body"></i>
                            </button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="tax" type="button" class="button-drag btn yellow-crusta value" data-text="Tax" onclick="setCourier(event, 'tax')">Tax
                                <i class="fa fa-question-circle tooltips" data-original-title="Total pajak Transaksi" data-container="body"></i>
                            </button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center" ><button id="service" type="button" class="button-drag btn blue-madison value" data-text="Tax" onclick="setCourier(event, 'service')">Service
                                <i class="fa fa-question-circle tooltips" data-original-title="Total service Transaksi" data-container="body"></i>
                            </button></div>
                        </div>
                    </div>
                    <div class="m-grid m-grid-demo">
                        <div class="m-grid-row">
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonOperator" style="width: 16.6%;">Operators
                                <i class="fa fa-question-circle tooltips" data-original-title="Operator digunakan jika dalam perhitunga rumus menggunakan lebih dari 1 value dan menghubungkan nilai antar value, cara penggunaan sama seperti pada kolom value" data-container="body"></i>
                            </div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kali" type="button" class="button-drag btn btn-default operator" data-text="*" onclick="setCourier(event, 'kali')">*</button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="bagi" type="button" class="button-drag btn btn-default operator" data-text="/" onclick="setCourier(event, 'bagi')">/</button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kurang" type="button" class="button-drag btn btn-default operator" data-text="-" onclick="setCourier(event, 'kurang')">-</button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="tambah" type="button" class="button-drag btn btn-default operator" data-text="+" onclick="setCourier(event, 'tambah')">+</button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="kbuka" type="button" class="button-drag btn btn-default kbuka" data-text="(" onclick="setCourier(event, 'kbuka')">(</button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center"><button id="ktutup" type="button" class="button-drag btn btn-default ktutup" data-text=")" onclick="setCourier(event, 'ktutup')">)</button></div>
                            <div class="m-grid-col m-grid-col-middle m-grid-col-center buttonDelete"><button id="delete" type="button" class="button-drag btn btn-danger delete">Delete
                                <i class="fa fa-question-circle tooltips" data-original-title="Tombol delete digunakan jika rumus yang sudah dimasukkan pada kolom result salah" data-container="body"></i>
                            </button>
                            </div>
                        </div>
                    </div><br>
                    <div class="m-grid m-grid-demo">
                    <div class="m-grid-row">
                        <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-2">Result
                            <i class="fa fa-question-circle tooltips" data-original-title="Hasil akhir yang akan digunakan untuk menghitung rumus minimum value internal kurir" data-container="body"></i>
                        </div>
                        <div class="m-grid-col m-grid-col-middle m-grid-col-center m-grid-col-md-10">
                            <div id="targetCourier">
                                @if (isset($list['courier']['courier']))
                                    @foreach ($list['courier']['courier'] as $key => $result)
                                        @if ($result != '')
                                            <button style="color: <?php echo $list['courier']['attrColor'][$key]; ?>" id="result<?php echo $result; ?>" type="button" class="button-drag btn btn-default"><?php echo ucwords($result); ?></button>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="portlet light bordered">
                <h3 class="">Update Setting Delivery</h3>
                    <hr>
                <div class="portlet-body">
                    <form class="form-horizontal" role="form" action="{{ url('transaction/setting/rule/update') }}" method="post" enctype="multipart/form-data" id="form">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Minimum Value
                                    <i class="fa fa-question-circle tooltips" data-original-title="Minimal transaksi untuk menggunakan kurir internal" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Delivery Minimal Value" class="form-control price" name="min_value" value="{{ $list[1]['value'] }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Maximum Distance (KM)
                                    <i class="fa fa-question-circle tooltips" data-original-title="Jarak maksimal untuk menggunakan kurir internal" data-container="body"></i>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Delivery Maximal Distance" class="form-control" name="max_distance" value="{{ $list[2]['value'] }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Delivery Pricing
                                    <i class="fa fa-question-circle tooltips" data-original-title="Type biaya jasa kurir" data-container="body"></i>
                                </label>
                                <div class="col-md-4">
                                        <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" id="radio14" name="delivery_pricing" class="md-radiobtn pricing" value="By KM" @if ($list[3]['value'] == 'By KM') checked @endif>
                                            <label for="radio14">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> By KM </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" id="radio16" name="delivery_pricing" class="md-radiobtn pricing" value="Fixed" @if ($list[3]['value'] == 'Fixed') checked @endif>
                                            <label for="radio16">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Fixed </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label delivery-price">Delivery Price
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <input type="text" placeholder="Delivery Price" class="form-control price" name="delivery_price" value="{{ $list[4]['value'] }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="key" value="delivery">
                        <div class="form-actions">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-offset-3 col-md-8">
                                    <button type="submit" class="btn blue">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            $('.value').prop('disabled', false);
            $('.operator').prop('disabled', true);
            $('.kbuka').prop('disabled', true);
            $('.ktutup').prop('disabled', true);

            var type = $('input[name=delivery_pricing]:checked').val();
            if (type == 'By KM') {
                $('.delivery-price').html('Delivery Price (By KM)');
            } else {
                $('.delivery-price').html('Delivery Price (Fixed)');
            }

            var jlm = $("#targetCourier > button").length;

            if (jlm < 1) {
                return false;
            } else {
                checkAwal();
            }

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

            $( ".price" ).on( "keyup", numberFormat);
            $( ".price" ).on( "blur", checkFormat);

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

            $('.pricing').change(function() {
                if (this.value == 'By KM') {
                    $('.delivery-price').html('Delivery Price (By KM) <i class="fa fa-question-circle tooltips" data-original-title="Nominal biaya jasa kurir" data-container="body"></i>');
                } else {
                    $('.delivery-price').html('Delivery Price (Fixed) <i class="fa fa-question-circle tooltips" data-original-title="Nominal biaya jasa kurir" data-container="body"></i>');
                }
            });
        }
    </script>

    <script type="text/javascript">
        function checkAwal() {
            var checkShow = $("#targetCourier button:last")[0].id;
            part = checkShow.substring(6);
            console.log(part);

            if (part == 'subtotal' || part == 'service' || part == 'shipping' || part == 'discount' || part == 'tax') {
                var button = 'value';
            } else if (part == 'kali' || part == 'bagi' || part == 'tambah' || part == 'kurang') {
                var button = 'operator';
            } else if (part == '(') {
                var button = 'kbuka';
            } else {
                var button = 'ktutup';
            }
            // console.log(button);
            eval("click" + button + "()");
        }
    </script>
@endsection
