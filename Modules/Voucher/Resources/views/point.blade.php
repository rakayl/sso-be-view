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

    @if (isset($post))
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>

    <script src="https://www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
    <script src="https://www.amcharts.com/lib/3/radar.js" type="text/javascript"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var point      = <?php echo empty($point['chart']['point']) ? "[]" : $point['chart']['point']; ?>;
            var pointValue = <?php echo empty($point['chart']['pointValue']) ? "[]" : $point['chart']['pointValue']; ?>;

            var chart = AmCharts.makeChart("chartdiv", {
              "type": "serial",
              "theme": "light",
              "marginRight": 70,
              "dataProvider": pointValue,
              "startDuration": 1,
              "graphs": [{
                "balloonText": "<b>[[category]]: [[value]]</b>",
                "fillColorsField": "color",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "point"
              }],
              "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
              },
              "categoryField": "type",
              "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 45
              },
              "export": {
                "enabled": true
              }

            });

            var chart = AmCharts.makeChart("chartdivpie", {
              "type": "pie",
              "theme": "light",
              "dataProvider": point,
              "valueField": "point",
              "titleField": "type",
               "balloon":{
               "fixedPosition":true
              },
              "export": {
                "enabled": true
              }
            } );
        });
    </script>
    <script type="text/javascript">
        var totalVoucher   = '<?php echo $user['total']-1; ?>';
        var voucherPerPage = '<?php echo $user['per_page']; ?>';
        var voucherUpTo    = '<?php echo $user['to']; ?>';

        $('#sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    info: "Showing "+ voucherPerPage +" to "+ voucherUpTo +" of "+ totalVoucher +" entries",
                    emptyTable: "No data available in table",
                    infoEmpty: "No entries found",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "print",
                    className: "btn dark btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "copy",
                  className: "btn blue btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                },{
                  extend: "pdf",
                  className: "btn yellow-gold btn-outline",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }, {
                    extend: "excel",
                    className: "btn green btn-outline",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                    extend: "csv",
                    className: "btn purple btn-outline ",
                    exportOptions: {
                         columns: "thead th:not(.noExport)"
                    },
                }, {
                  extend: "colvis",
                  className: "btn red",
                  exportOptions: {
                       columns: "thead th:not(.noExport)"
                  },
                }],
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
    @endif
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
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Date Range</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Start <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control" name="date_start" value="{{ $date_start }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <label class="col-md-2 control-label">End <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control" name="date_end" value="{{ $date_end }}" required>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Phone</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="phone_number" value="{{ $phone_number }}" placeholder="Customer's Phone Number">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-2 col-md-2">
                            <button type="submit" class="btn green">Submit</button>
                            <!-- <button type="button" class="btn default">Cancel</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (isset($post))
    <div class="portlet light bordered col-md-6">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Amount Point</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div id="chartdiv" style="height: 500px;"></div>
        </div>
    </div>
    <div class="portlet light bordered col-md-6">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Total Point</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div id="chartdivpie" style="height: 500px;"></div>
        </div>
    </div>

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue sbold uppercase">User</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
            <thead>
              <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>City</th>
                  <th>Point</th>
                  <th>Detail</th>
              </tr>
            </thead>
            <tbody>
                @if(!empty($user['data']))
                    @foreach($user['data'] as $res)
                        <tr>
                            <td>{{ $res['name'] }}</td>
                            <td>{{ $res['phone'] }}</td>
                            <td>{{ $res['email'] }}</td>
                            <td>{{ $res['city']['city_name'] }}</td>
                            <td>{{ number_format($res['points'], 0) }}</td>
                            <td>
                                <a href="{{ url('voucher/point/detail', $res['phone']) }}" class="btn blue"><i class="fa fa-search"></i></a>
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
            </table>
            @if ($user['paginator'])
                {{ $user['paginator']->links() }}
            @endif
        </div>
    </div>
    @endif
@endsection