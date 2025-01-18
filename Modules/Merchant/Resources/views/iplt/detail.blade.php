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
                                                                <div class="col-md-4">Nomor Dumping</div>
                                                                <div class="col-md-7"><b>: {{$detail['number_dumping_iplt']}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Order Status</div>
                                                                <div class="col-md-7">
                                                                    <?php
                                                                    $codeColor = [
                                                                        'Rejected' => '#ff0000',
                                                                        'Completed' => '#009900',
                                                                        'Pending' => '#ffd633'
                                                                    ];
                                                                    ?>
                                                                    :  <span class="badge" style="background-color: {{$codeColor[$detail['status']]??'#cccccc'}};">{{$detail['status']}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Vendor Penyedotan </div>
                                                                <div class="col-md-7"><b>: {{$detail['outlet_name']}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Kota</div>
                                                                <div class="col-md-7"><b>: {{$detail['city_name']}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Tanggal</div>
                                                                <div class="col-md-7"><b>: {{$detail['date']}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Volume</div>
                                                                <div class="col-md-7"><b>: {{$detail['volume_dumping']}}</b></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portlet light portlet-fit bordered">
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <h4><b>Armada Info</b></h4>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-4">Name Armada </div>
                                                                <div class="col-md-7"><b>: {{$detail['accommodation']['name']??null}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Nomor Armada</div>
                                                                <div class="col-md-7"><b>: {{$detail['accommodation']['number_accommodation']??null}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Merk Armada</div>
                                                                <div class="col-md-7"><b>: {{$detail['accommodation']['merk']??null}}</b></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">Tipe Armada</div>
                                                                <div class="col-md-7"><b>: {{$detail['accommodation']['type']??null}}</b></div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="portlet light portlet-fit bordered">
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <h4><b>Armada Info</b></h4>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <thead>
                                                                <tr style="text-align: center">
                                                                    <th scope="col" width="10%"> Nomor Transaksi </th>
                                                                    <th scope="col" width="10%"> Nama Customer </th>
                                                                    <th scope="col" width="10%"> Volume </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(!empty($detail['sedot']))
                                                                    @foreach($detail['sedot'] as $val)
                                                                        <tr style="text-align: center">
                                                                            <td>{{ $val['transaction_receipt_number'] }}</td>
                                                                            <td>{{ $val['name'] }}</td>
                                                                            <td>{{ $val['volume_sedot_wc'] }} L</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr><td colspan="3" style="text-align: center">Data Not Available</td></tr>
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                            
                                                        </div>
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