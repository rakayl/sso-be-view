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
                <span class="caption-subject sbold uppercase font-blue"> Detail Rule Promo Payment Gateway</span>
            </div>
        </div>
        <div class="portlet-body">
            <table style="width: 100%;">
                <tr>
                    <td width="25%">ID</td>
                    <td>: {{$detail['promo_payment_gateway_code']}}</td>
                </tr>
                <tr>
                    <td width="25%">Name</td>
                    <td>: {{$detail['name']}}</td>
                </tr>
                <tr>
                    <td>Payment Gateway</td>
                    <td>: {{$detail['payment_gateway']}}</td>
                </tr>
                <tr>
                    <td>Brands</td>
                    <td>: {{implode(',',array_column($detail['current_brand'], 'name_brand'))}} @if($detail['operator_brand'] == 'or') (one of the selected brand must exist) @else (all selected brand must exist) @endif </td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>: {{date('d-M-Y', strtotime($detail['start_date']))}} / {{date('d-M-Y', strtotime($detail['end_date']))}}</td>
                </tr>
                <tr>
                    <td>Maximum Total Cashback</td>
                    <td>: {{number_format($detail['maximum_total_cashback'])}}</td>
                </tr>
                <tr>
                    <td>Total Limit</td>
                    <td>: {{$detail['limit_promo_total']}}</td>
                </tr>
                <tr>
                    <td>Limit user per day</td>
                    <td>: {{$detail['limit_per_user_per_day']}}</td>
                </tr>
                <tr>
                    <td>Additional Limit Day</td>
                    <td>: {{$detail['limit_promo_additional_day']}}</td>
                </tr>
                <tr>
                    <td>Additional Limit Week</td>
                    <td>: {{$detail['limit_promo_additional_week']}}</td>
                </tr>
                <tr>
                    <td>Additional Limit Month</td>
                    <td>: {{$detail['limit_promo_additional_month']}}</td>
                </tr>
                <tr>
                    <td>Additional Limit Account</td>
                    <td>: {{$detail['limit_promo_additional_account']}} @if(!empty($detail['limit_promo_additional_account'])) (User : {{$detail['limit_promo_additional_account_type']}}) @endif</td>
                </tr>
                <tr>
                    <td>Cashback</td>
                    <td>: @if($detail['cashback_type'] == 'Nominal') IDR {{number_format((int)$detail['cashback'])}} @else {{$detail['cashback']}} % @endif</td>
                </tr>
                <tr>
                    <td>Maximum Cashback</td>
                    <td>: @if($detail['cashback_type'] == 'Nominal') - @else IDR {{number_format($detail['maximum_cashback'])}} @endif</td>
                </tr>
                <tr>
                    <td>Minimum Transaction</td>
                    <td>: IDR {{number_format($detail['minimum_transaction'])}}</td>
                </tr>
                <tr>
                    <td>Charged Payment Gateway</td>
                    <td>: @if($detail['charged_type'] == 'Nominal') IDR {{number_format((int)$detail['charged_payment_gateway'])}} @else {{$detail['charged_payment_gateway']}} % @endif</td>
                </tr>
                <tr>
                    <td>Charged Jiwa Group</td>
                    <td>: @if($detail['charged_type'] == 'Nominal') IDR {{number_format((int)$detail['charged_jiwa_group'])}} @else {{$detail['charged_jiwa_group']}} % @endif</td>
                </tr>
                <tr>
                    <td>Charged Central</td>
                    <td>: @if($detail['charged_type'] == 'Nominal') IDR {{number_format((int)$detail['charged_central'])}} @else {{$detail['charged_central']}} % @endif</td>
                </tr>
                <tr>
                    <td>Charged Outlet</td>
                    <td>: @if($detail['charged_type'] == 'Nominal') IDR {{number_format((int)$detail['charged_outlet'])}} @else {{$detail['charged_outlet']}} % @endif</td>
                </tr>
                <tr>
                    <td>MDR Setting</td>
                    <td>: {{$detail['mdr_setting']}} </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $summary['total_transaction']??0 }}">{{ number_format($summary['total_transaction']??0) }}</span>
                    </div>
                    <div class="desc"> Total Transaction </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $summary['total_amount']??0 }}">{{ number_format($summary['total_amount']??0) }}</span>
                    </div>
                    <div class="desc"> Total Amount </div>
                </div>
            </a>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $summary['total_cashback']??0 }}">{{ number_format($summary['total_cashback']??0) }}</span>
                    </div>
                    <div class="desc"> Total Cashback </div>
                </div>
            </a>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject sbold uppercase font-blue"> Report Transaction Rule Promo Payment Gateway</span>
            </div>
            <div class="actions">
                @if(isset($data) && !empty($data))
                    <a class="btn green-jungle" id="btn-export" href="{{url()->current()}}?export=1"><i class="fa fa-download"></i> Export</a>
                @endif
            </div>
        </div>
        <div class="portlet-body form">
            <div style="overflow-x: scroll; white-space: nowrap; overflow-y: hidden;">
                <table class="table table-striped table-bordered table-hover dt-responsive" id="data_list">
                    <thead>
                    <tr>
                        <th> Status </th>
                        <th> Transaction date</th>
                        <th> Customer name</th>
                        <th> Customer phone</th>
                        <th> Customer account PG</th>
                        <th> Receipt number </th>
                        <th> Amount </th>
                        <th> Chasback Received </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($data))
                        @foreach($data as $key => $res)
                            <tr style="background-color: #fbfbfb;">
                                <td>
                                    @if(!empty($res['reject_at']))
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #E7505A;padding: 5px 12px;color: #fff;">Rejected</span>
                                    @else
                                        <span class="sbold badge badge-pill" style="font-size: 14px!important;height: 25px!important;background-color: #26C281;padding: 5px 12px;color: #fff;">Success</span>
                                    @endif
                                </td>
                                <td> {{date('d M Y H:i', strtotime($res['transaction_date']))}} </td>
                                <td> {{ $res['customer_name'] }} </td>
                                <td> {{ $res['customer_phone'] }} </td>
                                <td>
                                    @if(!empty($res['user_contact']))
                                        {{ $res['user_contact'] }}
                                    @elseif(!empty($res['user_id_hash']))
                                        {{ $res['user_id_hash'] }}
                                    @endif
                                </td>
                                <td> <a target="_blank" href="{{ url('transaction/detail') }}/{{ $res['id_transaction'] }}/all">{{ $res['transaction_receipt_number'] }}</a> </td>
                                <td> {{ number_format($res['amount'],2,",",".") }} </td>
                                <td> {{ number_format($res['total_received_cashback'],2,",",".") }} </td>
                            </tr>
                        @endforeach
                    @else
                        <tr style="text-align: center"><td colspan="10">Data Not Available</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ($dataPaginator)
            {{ $dataPaginator->links() }}
        @endif
    </div>

@endsection