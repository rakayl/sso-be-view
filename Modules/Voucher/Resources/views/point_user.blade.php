@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <style type="text/css">
        .amcharts-export-menu-top-right {
            top: 10px;
            right: 0;
        }
    </style>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/datemultiselect/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            var voucherTotal = $("#voucherTotal").val();
            var trxTotal     = $("#trxTotal").val();
            var voucherPoint = $("#voucherPoint").val();
            var trxPoint     = $("#trxPoint").val();

           $('.voucherTotal').data('value', voucherTotal);
           $('.voucherTotal').html(voucherTotal);
           $('.voucherPoint').html(voucherPoint);

           $('.trxTotal').data('value', trxTotal);
           $('.trxTotal').html(trxTotal);
           $('.trxPoint').html(trxPoint);


        });

        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    emptyTable: "No data available in table",
                    zeroRecords: "No matching records found"
                },
                buttons: [],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                "paging":   false,
                "searching": false,
                order: [0, "asc"],
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
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


    <div class="portlet light bordered col-md-6" style="height: 480px;">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">User Info</span>
            </div>
        </div>
        <div class="portlet-body form">
            <table class="table table-hover table-light">
                <tbody>

                    @php
                        $except = [
                            'photo',
                            'id',
                            'password_k',
                            'id_city',
                            'password_k',
                            'phone_verified',
                            'email_verified',
                            'email_unsubscribed',
                            'android_device',
                            'ios_device',
                            'created_at',
                            'updated_at',
                            'point',
                            'point_transaction',
                            'point_voucher',
                            'city'
                        ];
                    @endphp

                    @foreach ($user[0] as $key => $value)
                    <tr>
                        @if (!in_array($key, $except))
                        <td> <b> {{ ucwords($key) }} </b></td>
                        <td>
                            @if ($key == "is_suspended")
                                @if ($value == 1)
                                    <span class="label label-sm label-danger"> Suspended </span>
                                @else
                                    <span class="label label-sm label-info"> Active </span>
                                @endif
                            @else
                                {{ $value }}
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    <tr>
                        <td> <b> City </b></td>
                        <td> {{ $user[0]['city']['city_name'] }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- INI UNTUK DATA RESUME POINT -->
    <div class="portlet light bordered col-md-6" style="height: 480px;">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Resume Point</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="0" class="voucherTotal"></span>
                            </h3>
                            <small>TOTAL VOUCHER</small>
                        </div>
                        <div class="icon">
                            <i class="icon-pie-chart"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success red-haze">
                                <span class="sr-only"></span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> Point Spend </div>
                            <div class="status-number voucherPoint"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="dashboard-stat2 ">
                    <div class="display">
                        <div class="number">
                            <h3 class="font-green-sharp">
                                <span data-counter="counterup" data-value="0" class="trxTotal"></span>
                            </h3>
                            <small>TOTAL TRANSACTION</small>
                        </div>
                        <div class="icon">
                            <i class="icon-basket"></i>
                        </div>
                    </div>
                    <div class="progress-info">
                        <div class="progress">
                            <span style="width: 100%;" class="progress-bar progress-bar-success green-sharp">
                                <span class="sr-only"></span>
                            </span>
                        </div>
                        <div class="status">
                            <div class="status-title"> Point Earned </div>
                            <div class="status-number trxPoint"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">Point History</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
            <thead>
              <tr>
                  <th>Date</th>
                  <th>Point</th>
                  <th>Type</th>
                  <th>References</th>
              </tr>
            </thead>
                <tbody>
                    @if(!empty($user[0]['point']))
                        @php
                            $voucherTotal = 0;
                            $trxTotal     = 0;
                            $voucherPoint = 0;
                            $trxPoint     = 0;
                        @endphp

                        @foreach($user[0]['point'] as $res)
                            @php
                                if ($res['source'] == "voucher") {
                                    $voucherTotal = $voucherTotal + 1;
                                    $voucherPoint = $voucherPoint + $res['point'];
                                }
                                else {
                                    $trxTotal     = $trxTotal + 1;
                                    $trxPoint     = $trxPoint + $res['point'];
                                }
                            @endphp


                        @endforeach
                    @endif

                    @if (!empty($user[0]['point_transaction']))
                        @foreach ($user[0]['point_transaction'] as $res)
                        <tr>
                            <td>{{ date('d F Y', strtotime($res['created_at'])) }}</td>
                            <td>{{ number_format($res['point'], 0) }}</td>
                            <td>{{ ucwords($res['source']) }}</td>
                            <td>{{ $res['transaction']['transaction_receipt_number'] }}</td>
                        </tr>
                        @endforeach
                    @endif

                    @if (!empty($user[0]['point_voucher']))
                        @foreach ($user[0]['point_voucher'] as $res)
                        <tr>
                            <td>{{ date('d F Y', strtotime($res['created_at'])) }}</td>
                            <td>{{ number_format($res['point'], 0) }}</td>
                            <td>{{ ucwords($res['source']) }}</td>
                            <td>@if (empty($res['voucher']['trx_id'])) <small>Bought at {{ date('d F Y', strtotime($res['voucher']['created_at'])) }} </small> @else {{ $res['voucher']['trx_id'] }} @endif</td>
                        </tr>
                        @endforeach
                    @endif

                    <input style="display: none;" type="text" value="{{ $voucherTotal }}" id="voucherTotal">
                    <input style="display: none;" type="text" value="{{ $trxTotal }}" id="trxTotal">
                    <input style="display: none;" type="text" value="{{ $voucherPoint }}" id="voucherPoint">
                    <input style="display: none;" type="text" value="{{ $trxPoint }}" id="trxPoint">
                </tbody>
            </table>
        </div>
    </div>

@endsection