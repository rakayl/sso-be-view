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
        #chartdiv1 {
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
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        var chart = AmCharts.makeChart("chartdiv", {
          "type": "serial",
          "theme": "light",
          "marginRight": 70,
          "dataProvider": {!! $total !!},
          "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "Quantity product"
          }],
          "startDuration": 1,
          "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "visits"
          }],
          "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
          },
          "categoryField": "country",
          "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
          },
          "export": {
            "enabled": true
          }

        });
    </script>

    <script type="text/javascript">
        var chart = AmCharts.makeChart("chartdiv1", {
          "type": "serial",
          "theme": "light",
          "marginRight": 70,
          "dataProvider": {!! $total !!},
          "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "Reccuring product"
          }],
          "startDuration": 1,
          "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "visits"
          }],
          "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
          },
          "categoryField": "country",
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
                <span class="caption-subject sbold uppercase font-blue">Date Range</span>
            </div>
        </div>
        <div class="portlet-body form">
            <form class="form-horizontal" role="form" action="{{ url('report/product/detail') }}" method="post" enctype="multipart/form-data">
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
                    </div><hr>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Product <span class="required" aria-required="true"> * </span> </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <select class="form-control" name="id_product">
                                    @if (isset($product['list']))
                                        @foreach ($product['list'] as $key => $c)
                                            <option value="{{ $c['id_product'] }}" @if (isset($product['select']['id_product']) && $product['select']['id_product'] == $c['id_product']) selected @elseif (old('product') == $c['id_product']) selected @endif>{{ $c['product_name'] }}</option>
                                        @endforeach
                                    @endif
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

    @if (isset($product))
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject sbold uppercase font-blue">Report Product</span>
                </div>
            </div>
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Total Product ({{ $product['select']['product_name'] }})</span>
            </div><br>
            <div id="chartdiv"></div>
            <br><hr>
            <div class="caption ">
                <span class="caption-subject sbold uppercase font-blue">Reccuring Product ({{ $product['select']['product_name'] }})</span>
            </div><br>
            <div id="chartdiv1"></div>
            <br>
        </div>
    @endif
@endsection
