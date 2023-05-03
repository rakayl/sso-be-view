@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.multidatespicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-bootstrap-select.min.js') }}"  type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue"> Promo Payment Gateway Validation Report Detail</span>
            </div>
        </div>
        <div class="portlet-body">
            <table style="width: 100%;">
                <tr>
                    <td width="25%">Status</td>
                    <td>:
                        @if($detail['processing_status'] == 'Success')
                            <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Success</span>
                        @elseif($detail['processing_status'] == 'Fail')
                            <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Fail</span>
                        @elseif($detail['processing_status'] == 'In Progress')
                            <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #fef647;padding: 5px 12px;color: #fff;">In Progress</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="25%">Validation by</td>
                    <td>: {{$detail['admin_name']}} ({{date('d M Y H:i', strtotime($detail['date_validation']))}})</td>
                </tr>
                <tr>
                    <td width="25%">ID</td>
                    <td>: {{$detail['promo_payment_gateway_code']}}</td>
                </tr>
                <tr>
                    <td width="25%">Name</td>
                    <td>: {{$detail['name']}}</td>
                </tr>
                <tr>
                    <td width="25%">Reference by</td>
                    <td>:
                        @if($detail['reference_by'] == 'transaction_receipt_number')
                            Receipt Number
                        @else
                            ID Payment
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="25%">Validation Cashback Type</td>
                    <td>: {{$detail['validation_cashback_type']}}</td>
                </tr>
                <tr>
                    <td width="25%">Override MDR Status</td>
                    <td>: {{($detail['override_mdr_status'] == 1 ? 'Override MDR':'Not Override MDR')}}</td>
                </tr>
                <tr>
                    <td>File</td>
                    <td>: <a href="{{url('disburse/rule-promo-payment-gateway/validation/report/download', $detail['id_promo_payment_gateway_validation'])}}"><i class="fa fa-download"></i> Download File</a></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>: {{date('d-M-Y', strtotime($detail['start_date']))}} / {{date('d-M-Y', strtotime($detail['end_date']))}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red">
                <div class="text-left" style="margin-left: 5%">
                    <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah data yang tidak ditemukan dan data payment tidak sesuai" data-skin="dark" style="color: #FFFFFF;"></i>
                </div>
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $detail['invalid_data']??0 }}">{{ number_format($detail['invalid_data']??0) }}</span>
                    </div>
                    <div class="desc"> Invalid Data </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue">
                <div class="text-left" style="margin-left: 5%">
                    <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah data yang sesuai untuk transaksi yang mendapatkan promo" data-skin="dark" style="color: #FFFFFF;"></i>
                </div>
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $detail['correct_get_promo']??0 }}">{{ number_format($detail['correct_get_promo']??0) }}</span>
                    </div>
                    <div class="desc"> Correct Get Promo </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green">
                <div class="text-left" style="margin-left: 5%">
                    <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah transaksi yang di sistem Jiwa+ mendapatkan promo tetapi berdasarkan file validasi dari PG tidak mendapatkan promo (pada sistem Jiwa+ di-update menjadi tidak mendapatkan promo)" data-skin="dark" style="color: #FFFFFF;"></i>
                </div>
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $detail['not_get_promo']??0 }}">{{ number_format($detail['not_get_promo']??0) }}</span>
                    </div>
                    <div class="desc"> Not Get Promo </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple">
                <div class="text-left" style="margin-left: 5%">
                    <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah transaksi yang di sistem Jiwa+ tidak mendapatkan promo tetapi berdasarkan file validasi dari PG mendapatkan promo (pada sistem Jiwa+ di-update menjadi mendapatkan promo)" data-skin="dark" style="color: #FFFFFF;"></i>
                </div>
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $detail['must_get_promo']??0 }}">{{ number_format($detail['must_get_promo']??0) }}</span>
                    </div>
                    <div class="desc"> Must Get Promo </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red">
                <div class="text-left" style="margin-left: 5%">
                    <i class="fa fa-info-circle tooltips" data-toggle="tooltip" data-placement="top" title="Jumlah transaksi dengan nilai cashback yang tidak sesuai (nilai cashback di-update berdasarkan nilai cashback dari file validasi)" data-skin="dark" style="color: #FFFFFF;"></i>
                </div>
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $detail['wrong_cashback']??0 }}">{{ number_format($detail['wrong_cashback']??0) }}</span>
                    </div>
                    <div class="desc"> Wrong Cashback</div>
                </div>
            </a>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue"> List Transaction</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-striped table-bordered table-hover dt-responsive" id="data_list">
                <thead>
                <tr>
                    <th> Receipt Number </th>
                    <th> Reference ID </th>
                    <th> Validation </th>
                    <th> Notes </th>
                    <th> Cashback New </th>
                    <th> Cashback Old </th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($detail['list_detail']))
                    @foreach($detail['list_detail'] as $key => $res)
                        <tr style="background-color: #fbfbfb;">
                            <?php
                            $status = [
                                'correct_get_promo' => 'Correct Get Promo',
                                'not_get_promo' => 'Not Get Promo',
                                'must_get_promo' => 'Must Get Promo',
                                'invalid_data' => 'Invalid Data'
                            ];
                            ?>
                            <td> {{ $res['transaction_receipt_number'] }} </td>
                            <td> {{ $res['reference_id'] }} </td>
                            <td> {{ $status[$res['validation_status']]??''}} </td>
                            <td> {{ $res['notes']}} </td>
                            <td> @if($detail['validation_cashback_type'] == 'Check Cashback') {{number_format($res['new_cashback'],2,",",".")}} @endif</td>
                            <td> @if($detail['validation_cashback_type'] == 'Check Cashback') {{number_format($res['old_cashback'],2,",",".")}} @endif</td>
                        </tr>
                    @endforeach
                @else
                    <tr style="text-align: center"><td colspan="5">Data Not Available</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection