@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
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
    <div class="tabbable-line boxless tabbable-reversed">
        	<ul class="nav nav-tabs">
            <li class="active" >
                <a href="#transaction-info" data-toggle="tab"> Info </a>
            </li>
        </ul>
    </div>
    
		<div class="tab-content">
			<div class="tab-pane active form" id="transaction-info">
				<br>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <div class="portlet light portlet-fit bordered">
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <h4><b>Dumping Info</b></h4>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-4">Receipt Number</div>
                                                                <div class="col-md-7"><b>: {{$detail['transaction_receipt_number']}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Time & date</div>
                                                                <div class="col-md-7"><b>: {{$detail['transaction_date']}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Order Status</div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                    $codeColor = [
                                                                        1 => '#ff0000',
                                                                        2 => '#ffd633',
                                                                        3 => '#cccccc',
                                                                        4 => '#ffd633',
                                                                        5 => '#ffd633',
                                                                        6 => '#009900',
                                                                    ];
                                                                    ?>
                                                                    : <span class="badge" style="background-color: {{$codeColor[$detail['transaction_status_code']]??'#cccccc'}};">{{$detail['transaction_status_text']}}</span>
                                                                </div>
                                                            </div>
                                                            @if($detail['transaction_status_code'] == 1)
                                                                <div class="row">
                                                                    <div class="col-md-4">Reject at</div>
                                                                    <div class="col-md-7"><b>: {{$detail['transaction_reject_at']}}</b></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">Reject reason</div>
                                                                    <div class="col-md-7"><b>: {{$detail['transaction_reject_reason']}}</b></div>
                                                                </div>
                                                            @endif
                                                            <br>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4><b>Customer Info</b></h4>
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Name</div>
                                                                <div class="col-md-7"><b>: {{$detail['user']['name']??null}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Email</div>
                                                                <div class="col-md-7"><b>: {{$detail['user']['email']??null}} </b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">phone</div>
                                                                <div class="col-md-7"><b>: {{$detail['user']['phone']??null}}</b></div>
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h4><b>Address Info</b></h4>
                                                                    <hr>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Adress Name</div>
                                                                <div class="col-md-7"><b>: {{$detail['address']['destination_name']??null}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Address</div>
                                                                <div class="col-md-7"><b>: {{$detail['address']['destination_address']??null}} ({{$detail['address']['destination_city']??null}} - {{$detail['address']['destination_province']??null}})</b></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portlet light portlet-fit bordered">
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-6" style="text-align: left"><h5><b>PAYMENT</b></h5></div>
                                                        <div class="col-md-6" style="text-align: right"></div>
                                                    </div>
                                                    @foreach($detail['payment_detail'] as $pd)
                                                        @if(strpos($pd['text'],"Discount") === false && strpos(strtolower($pd['text']),"point") === false)
                                                            <div class="row">
                                                                <div class="col-md-6" style="text-align: left"><h5>{{$pd['text']}}</h5></div>
                                                                <div class="col-md-6" style="text-align: right"><h5>{{$pd['value']}}</h5></div>
                                                            </div>
                                                        @else
                                                            <div class="row" style="color: red">
                                                                <div class="col-md-6" style="text-align: left"><h5>{{$pd['text']}}</h5></div>
                                                                <div class="col-md-6" style="text-align: right"><h5>{{$pd['value']}}</h5></div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-6" style="text-align: left"><h5><b>GRAND TOTAL</b></h5></div>
                                                        <div class="col-md-6" style="text-align: right"><h5><b>{{$detail['transaction_grandtotal']}}</b></h5></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6" style="text-align: left"><h5><b>PAYMENT USE</b></h5></div>
                                                        <div class="col-md-6" style="text-align: right"><h5><b>@if(!empty($detail['payment'])) {{$detail['payment']}} @else - @endif</b></h5></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                </div>
			</div>
			
		</div>
@endsection