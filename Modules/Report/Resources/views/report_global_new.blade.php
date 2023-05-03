@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .amcharts-export-menu-top-right {
          top: 10px;
          right: 0;
        }
    </style>

    <style type="text/css">
        #customer {
          width: 100%;
          height: 500px;
        }
    </style>

    <style type="text/css">
        #product {
          width: 100%;
          height: 500px;
        }
    </style>

    <style type="text/css">
        #transx {
            width   : 100%;
            height  : 500px;
        }
    </style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>

    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/none.js"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('.sample_1').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
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
                }],
                responsive: {
                    details: {
                        type: "column",
                        target: "tr"
                    }
                },
                "paging": false,
                "searching": false,
                order: [0, "desc"],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>

    <script>
    var chartData = <?php echo $nominal; ?>;

    var chart = AmCharts.makeChart("transx", {
        "type": "serial",
        "theme": "light",
        "marginRight": 80,
        "autoMarginOffset": 20,
        "marginTop": 7,
        "dataProvider": chartData,
        "valueAxes": [{
            "axisAlpha": 0.2,
            "dashLength": 1,
            "position": "left"
        }],
        "mouseWheelZoomEnabled": true,
        "graphs": [{
            "id": "g1",
            "balloonText": "[[value]]",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "hideBulletsCount": 50,
            "title": "red line",
            "valueField": "nominal",
            "useLineColorForBulletBorder": true,
            "balloon":{
                "drop":true
            }
        }],
        "chartScrollbar": {
            "autoGridCount": true,
            "graph": "g1",
            "scrollbarHeight": 40
        },
        "chartCursor": {
           "limitToGraph":"g1"
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "axisColor": "#DADADA",
            "dashLength": 1,
            "minorGridEnabled": true
        },
        "export": {
            "enabled": true
        }
    });

    chart.addListener("rendered", zoomChart);
    zoomChart();

    // this method is called when chart is first inited as we listen for "rendered" event
    function zoomChart() {
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
    }
    </script>

    <script type="text/javascript">
      var chart = AmCharts.makeChart("customer", {
        "type": "pie",
        "theme": "none",
        "dataProvider": <?php echo $customer; ?>,
        "valueField": "nominal",
        "titleField": "name",
         "balloon":{
         "fixedPosition":true
        },
        "export": {
          "enabled": true
        }
      } );
    </script>

    <script>
    var chart = AmCharts.makeChart("product", {
      "type": "serial",
      "theme": "none",
      "marginRight": 70,
      "dataProvider": <?php echo $product; ?>,
      "valueAxes": [{
        "axisAlpha": 0,
        "position": "left",
        "title": "Total Quantity Product"
      }],
      "startDuration": 1,
      "graphs": [{
        "balloonText": "<b>[[category]]: [[value]]</b>",
        "fillColorsField": "color",
        "fillAlphas": 0.9,
        "lineAlpha": 0.2,
        "type": "column",
        "valueField": "qty"
      }],
      "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
      },
      "categoryField": "product",
      "categoryAxis": {
        "gridPosition": "start",
        "labelRotation": 45
      },
      "export": {
        "enabled": true
      }

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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-yellow">Date Range</span>
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
                        <label class="col-md-2 control-label">Outlet <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-10">
                            <div class="input-icon right">
                                <select class="form-control select2" name="id_outlet" data-placeholder="select outlet" required>
                                <optgroup label="Outlet List">
                                    <option value="0" @if ($id_outlet == "0") selected @endif>All</option>
                                    @if (!empty($outlet))
                                        @foreach ($outlet as $key => $out)
                                            <option value="{{ $out['id_outlet'] }}" @if (isset($id_outlet) && $id_outlet == $out['id_outlet']) selected @elseif (old('id_outlet') == $out['id_outlet']) selected @endif>{{ $out['outlet_name'] }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                            </div>
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-yellow">Transaction</span>
            </div>
        </div>
        <div class="row">
            <div class="portlet-body form">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $totalNominal }}" style="font-size: 20px">Rp{{ number_format($totalNominal) }}</span>
                            </div>
                            <div class="desc"> Nominal Transaction </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $totalCountTrx }}">{{ $totalCountTrx }}</span></div>
                            <div class="desc"> Total Transaction </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $totalAvg }}" style="font-size: 20px">Rp{{ number_format($totalAvg) }}</span>
                            </div>
                            <div class="desc"> Average (day) </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                        <div class="visual">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $totalAvgTrx }}" style="font-size: 20px">Rp{{ number_format($totalAvgTrx) }}</div>
                            <div class="desc"> Average (transaction) </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div id="transx"></div>
        </div>
    </div>

    {{-- <!-- <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-yellow">POINT</span>
            </div>
        </div>
        <div class="row">
            <div class="portlet-body form">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                        <div class="visual">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $pointGiven }}">{{ $pointGiven }}</span>
                            </div>
                            <div class="desc"> Point Given </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $pointRedeem }}">{{ $pointRedeem }}</span></div>
                            <div class="desc"> Point Redeem </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                        <div class="visual">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $pointTotal }}">{{ $pointTotal }}</span>
                            </div>
                            <div class="desc"> Point Total </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div> --> --}}

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-yellow">TOP 10 Customer</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div id="customer"></div>
            </div>
            <div class="col-md-5">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-yellow sbold uppercase"></span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
                            <thead>
                                <tr>
                                    <th> Nominal </th>
                                    <th> Name </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($dataCustomer))
                                    @foreach($dataCustomer as $value)
                                        <tr>
                                            <td>{{ number_format($value['nominal'], 2) }}</td>
                                            <td><a href="{{ url('report/customer/detail') }}/{{ $value['user']['phone'] }}"> {{ $value['user']['name'] }} </a></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-yellow">TOP 10 Product</span>
            </div>
        </div>
        <div class="row">
            <div id="product"></div>
        </div>
        <hr>
        <div class="row">
            <div class="portlet-body form">
                <table class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
                    <thead>
                        <tr>
                            <th> Quantity </th>
                            <th> Code </th>
                            <th> Product </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($dataProduct))
                            @foreach($dataProduct as $key=>$value)
                                @if ($key < 10)
                                <tr>
                                    <td>{{ $value['total_qty'] }}</td>
                                    <td>{{ $value['product_code'] }}</td>
                                    <td>{{ $value['product_name'] }}</td>
                                    <td>
                                        <a href="{{ url('report/product/detail') }}/{{ $value['id_product'] }}/{{ $date_start }}/{{ $date_end }}" data-popout="true" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
