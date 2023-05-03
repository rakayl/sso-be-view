@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
@endphp

@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
     $(document).ready(function(){
        $('.datepicker').datepicker({
            'format' : 'd-M-yyyy',
            'todayHighlight' : true,
            'autoclose' : true
        });
    })
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
    </div><br>

    @include('layouts.notifications')

    <form role="form" action="" method="post">
		@include('transaction::payment.filter_manualpayment')
    </form>

    @if(isset($conditions))
    <div class="alert alert-block alert-info fade in">
        <button type="button" class="close" data-dismiss="alert"></button>
        <h4 class="alert-heading">Displaying search result with parameter(s):</h4>
            @foreach($conditions as $row)
                @if(isset($row['subject']))
                    @if($row['subject'] == 'cancelled_at')
                        @php $row['subject'] = 'decline_date' @endphp
                    @elseif($row['subject'] == 'confirmed_at')
                        @php $row['subject'] = 'accept_date' @endphp
                    @endif
                <p>{{ucwords(str_replace("_"," ",$row['subject']))}}
                @if(isset($row['parameter']) && $row['parameter'] != "") {{str_replace("-"," - ",$row['operator'])}}{{str_replace("-"," - ",$row['parameter'])}}
                @else = {{str_replace("-"," - ",$row['operator'])}}
                @endif
                </p>
                @endif
            @endforeach
            @if(isset($search_param['take']))<p>Show = {{$search_param['take']}}</p> @endif
            @if(isset($search_param['order_field']))<p>Order By = {{$search_param['order_field']}} @if(isset($search_param['order_method'])) {{$search_param['order_method']}} @endif</p> @endif
            <br>
            <p>
                <a href="{{ url('transaction/manualpayment/reset/'.$type) }}" class="btn yellow">Reset</a>
            </p>

        </div>
    @endif

    <div class="portlet light bordered" style="padding-bottom:45px">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Manual Payment Transaction</span>
            </div>
            <ul class="nav nav-tabs">
                <li @if(isset($unconfirmed)) class="active" @endif>
                    <a href="{{url('transaction/manualpayment/list/unconfirmed')}}"> Unconfirmed </a>
                </li>
                <li @if(isset($accepted)) class="active" @endif>
                    <a href="{{url('transaction/manualpayment/list/accepted')}}"> Accepted </a>
                </li>
                <li @if(isset($declined)) class="active" @endif>
                    <a href="{{url('transaction/manualpayment/list/declined')}}"> Declined </a>
                </li>
            </ul>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active">
                    <table class="table table-striped table-bordered table-hover dt-responsive sample-1" width="100%" id="">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Receipt Number</th>
                                <th>Payment Date</th>
                                <th>Payment Method</th>
                                <th>Nominal</th>
                                <th>Account Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($list))
                            @foreach($list as $res)
                                <tr>
                                    <td>
                                        @if(empty($res['confirmed_at']) && empty($res['cancelled_at']))
                                            <a class="btn btn-sm blue" href="{{ url('transaction/manualpayment/confirm', $res['transaction']['transaction_receipt_number']) }}"><i class="icon-pencil"></i> confirm</a>
                                        @else
                                            <a class="btn btn-sm blue" href="{{ url('transaction/manualpayment/confirm', $res['transaction']['transaction_receipt_number']) }}"><i class="fa fa-search"></i> detail</a>
                                        @endif
                                    </td>
                                    <td>{{ $res['transaction']['transaction_receipt_number'] }}</td>
                                    <td>{{ date('Y-m-d', strtotime($res['payment_date'])) }}{{ date('H:i:s', strtotime($res['payment_time'])) }}</td>
                                    <td>{{ $res['payment_method'] }}</td>
                                    <td>Rp {{ number_format($res['payment_nominal']) }}</td>
                                    <td>{{ $res['payment_account_name'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" style="text-align:center">No data available in table</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            Showing {{$from}} to {{$to}} of {{$total}} entries
        </div>
        <div class="pagination pull-right" style="margin-top:-28px;margin-bottom: 0px;">
            @if ($paginator)
            {{ $paginator->links() }}
            @endif
        </div>
    </div>
@endsection
