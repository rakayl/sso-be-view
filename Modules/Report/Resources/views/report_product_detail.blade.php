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
    var chartData = <?php echo $dataRecQty; ?>;

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
            "title": "Quantity",
            "valueField": "qty",
            "fillAlphas": 0
        }, {
            "valueAxis": "v2",
            "lineColor": "#FCD202",
            "bullet": "square",
            "bulletBorderThickness": 1,
            "hideBulletsCount": 30,
            "title": "Recurring",
            "valueField": "rec",
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

    <script>
    var chart = AmCharts.makeChart("uang", {
        "type": "serial",
        "theme": "light",
        "marginRight": 80,
        "marginTop": 17,
        "autoMarginOffset": 20,
        "dataProvider": <?php echo $dataNominal; ?>,
        "valueAxes": [{
            "logarithmic": true,
            "dashLength": 1,
            "guides": [{
                "dashLength": 6,
                "inside": true,
                "label": "average",
                "lineAlpha": 1,
                "value": 90.4
            }],
            "position": "left"
        }],
        "graphs": [{
            "bullet": "round",
            "id": "g1",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletSize": 7,
            "lineThickness": 2,
            "title": "Price",
            "type": "smoothedLine",
            "useLineColorForBulletBorder": true,
            "valueField": "price"
        }],
        "chartScrollbar": {},
        "chartCursor": {
            "valueLineEnabled": true,
            "valueLineBalloonEnabled": true,
            "valueLineAlpha": 0.5,
            "fullWidth": true,
            "cursorAlpha": 0.05
        },
        "dataDateFormat": "YYYY-MM-DD",
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true
        },
        "export": {
            "enabled": true
        }
    });

    chart.addListener("dataUpdated", zoomChart);

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
                <span class="caption-subject sbold uppercase font-yellow">Info Product</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable table-scrollable-borderless">
                <table class="table table-hover table-light">
                    <tbody>
                        <tr>
                            <td> <b> Code </b> </td>
                            <td> {{ $product[0]['product_code'] }} </td>
                        </tr>
                        <tr>
                            <td> <b> Name </b> </td>
                            <td> {{ $product[0]['product_name'] }} </td>
                        </tr>
                        <tr>
                            <td> <b> Category </b> </td>
                            <td> @if (!empty($product[0]['category'])) {{ $product[0]['category']['product_category_name'] }} @endif</td>
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
                    <span class="caption-subject sbold uppercase font-yellow">Recurring & Quantity Detail</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div id="chartdiv"></div>
            </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject sbold uppercase font-yellow">Nominal Detail</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div id="uang"></div>
            </div>
        </div>
      </div>
    </div>

@endsection
