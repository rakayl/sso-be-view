@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        #chartdiv {
          width: 100%;
          height: 500px;
        }

        .amcharts-export-menu-top-right {
          top: 10px;
          right: 0;
        }
    </style>
    <style type="text/css">
        #uang {
          width: 100%;
          height: 500px;
        }

        .amcharts-export-menu-top-right {
          top: 10px;
          right: 0;
        }
    </style>

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

    <script>
    var chartData = <?php echo $dataOutlet; ?>;

    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "light",
        "legend": {
            "useGraphSettings": true
        },
        "dataProvider": chartData,
        "synchronizeGrid":true,
        "valueAxes": [{
            "id":"v1",
            "axisColor": "#FF6600",
            "axisThickness": 2,
            "axisAlpha": 1,
            "position": "left"
        }, {
            "id":"v2",
            "axisColor": "#FCD202",
            "axisThickness": 2,
            "axisAlpha": 1,
            "position": "right"
        }],
        "graphs": [{
            "valueAxis": "v1",
            "lineColor": "#FF6600",
            "bullet": "round",
            "bulletBorderThickness": 1,
            "hideBulletsCount": 30,
            "title": "Transaction Value",
            "valueField": "value",
            "fillAlphas": 0
        }, {
            "valueAxis": "v2",
            "lineColor": "#FCD202",
            "bullet": "square",
            "bulletBorderThickness": 1,
            "hideBulletsCount": 30,
            "title": "Transaction Count",
            "valueField": "count",
            "fillAlphas": 0
        }],
        "chartScrollbar": {},
        "chartCursor": {
            "cursorPosition": "mouse"
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "axisColor": "#DADADA",
            "minorGridEnabled": true
        },
        "export": {
            "enabled": true,
            "position": "bottom-right"
         }
    });

    chart.addListener("dataUpdated", zoomChart);
    zoomChart();

    function zoomChart(){
        chart.zoomToIndexes(chart.dataProvider.length - 20, chart.dataProvider.length - 1);
    }

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

    <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-settings font-red"></i>
                <span class="caption-subject sbold uppercase font-yellow">Info Outlet</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable table-scrollable-borderless">
                <table class="table table-hover table-light">
                    <tbody>
                        <tr>
                            <td> <b> Code </b> </td>
                            <td> {{ $outlet[0]['outlet_code'] }} </td>
                        </tr>
                        <tr>
                            <td> <b> Name </b> </td>
                            <td> {{ $outlet[0]['outlet_name'] }} </td>
                        </tr>
                        <tr>
                            <td> <b> Address </b> </td>
                            <td> {{ $outlet[0]['outlet_address'] }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="m-heading-1 border-green m-bordered">
        <h3>Data Range</h3>
        <p> From <b> {{ date('d F Y', strtotime($date_start)) }} </b> Up To <b> {{ date('d F Y', strtotime($date_end)) }} </b> </p>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject sbold uppercase font-yellow">Transaction Value & Transaction Count Detail</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div id="chartdiv"></div>
            </div>
        </div>
      </div>
    </div>

@endsection
