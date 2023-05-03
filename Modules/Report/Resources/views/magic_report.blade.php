@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />

    <style type="text/css">
        #recurring {
          width: 100%;
          height: 500px;
        }

        .amcharts-export-menu-top-right {
          top: 10px;
          right: 0;
        }
    </style>

    <style type="text/css">
        #quantity {
          width: 100%;
          height: 500px;
        }

        .amcharts-export-menu-top-right {
          top: 10px;
          right: 0;
        }
    </style>

    <style type="text/css">
        #recurringTag {
          width: 100%;
          height: 500px;
        }

        .amcharts-export-menu-top-right {
          top: 10px;
          right: 0;
        }
    </style>

    <style type="text/css">
        #quantityTag {
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
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#sample_1').dataTable({
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
                aaSorting: [],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
        });
    </script>

    <script>
    var chart = AmCharts.makeChart("recurringTag", {
        "type": "serial",
        "theme": "light",
        "marginRight": 70,
        "dataProvider": <?php echo $dataRecTag ?>,
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "Total Recurring Tag"
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "rec"
        }],
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "tag",
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
      var chart = AmCharts.makeChart("quantityTag", {
        "type": "serial",
        "theme": "light",
        "marginRight": 70,
        "dataProvider": <?php echo $dataQtyTag ?>,
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "Total Quantity Tag"
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
        "categoryField": "tag",
        "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
        },
        "export": {
            "enabled": true
        }
      } );
    </script>
    <script type="text/javascript">
      var chart = AmCharts.makeChart("recurring", {
        "type": "serial",
        "theme": "light",
        "marginRight": 70,
        "dataProvider": <?php echo $dataRecProduct ?>,
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "Total Recurring Product"
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "rec"
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
      } );
    </script>
    <script type="text/javascript">
      var chart = AmCharts.makeChart("quantity", {
        "type": "serial",
        "theme": "light",
        "marginRight": 70,
        "dataProvider": <?php echo $dataQtyProduct ?>,
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
            "labelRotation": 45,
        },
        "export": {
            "enabled": true
        }
      } );
    </script>

    <script>
        $('#other_rec').click(function(){
            var rec = $('#recommendation').text();
            $.get("{{url('report/other/recommendation')}}"+"/"+rec, function(result){
                $('#recommendation').text(result);
            })
        })
    </script>

    <script>
        $('#selectmonth').change(function(){
            var month = $(this).val();
            var year = $('#selectyear').val();
            var token  = "{{ csrf_token() }}";
            $.ajax({
                type : "POST",
                url : "{{ url('report/newtop') }}",
                data : "_token="+token+"&month="+month+"&year="+year,
                success : function(result) {
                    $('#newTopRec').empty();
                    $('#newTopQty').empty();
                    if(result.rec.length > 0){
                        $.each(result.rec, function(i, datarec){
                           $('#newTopRec').append('<li>'+datarec.product_name+'</li>')
                        })
                    }else{
                        $('#newTopRec').append('<p>There are no new top products</p>')
                    }
                    if(result.qty.length > 0){
                        $.each(result.qty, function(i, dataqty){
                           $('#newTopQty').append('<li>'+dataqty.product_name+'</li>')
                        })
                    }else{
                        $('#newTopQty').append('<p>There are no new top products</p>')
                    }
                }
            });
        })
        $('#selectyear').change(function(){
            var year = $(this).val();
            var month = $('#selectmonth').val();
            var token  = "{{ csrf_token() }}";
            $.ajax({
                type : "POST",
                url : "{{ url('report/newtop') }}",
                data : "_token="+token+"&month="+month+"&year="+year,
                success : function(result) {
                    $('#newTopRec').empty();
                    $('#newTopQty').empty();
                    if(result.rec.length > 0){
                        $.each(result.rec, function(i, datarec){
                           $('#newTopRec').append('<li>'+datarec.product_name+'</li>')
                        })
                    }else{
                        $('#newTopRec').append('<p>There are no new top products</p>')
                    }
                    if(result.qty.length > 0){
                        $.each(result.qty, function(i, dataqty){
                           $('#newTopQty').append('<li>'+dataqty.product_name+'</li>')
                        })
                    }else{
                        $('#newTopQty').append('<p>There are no new top products</p>')
                    }
                }
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

    <form class="form-horizontal" role="form" action="{{ url()->current() }}" method="post" enctype="multipart/form-data">

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject sbold uppercase font-blue">Exclude Product & Tag</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Select Product </label>
                        <div class="col-md-6">
                            <select class="form-control select2-multiple" multiple data-placeholder="Select Product" name="exclude_product[]">
                                @foreach ($allProducts as $item)
                                    <option @if(is_array($exclude_product) && in_array($item['id_product'], $exclude_product)) selected @endif value="{{$item['id_product']}}" >{{$item['product_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Select Tag </label>
                        <div class="col-md-6">
                            <select class="form-control select2-multiple" multiple data-placeholder="Select Tag" name="exclude_tag[]">
                                @foreach ($allTags as $itemTag)
                                    <option @if(is_array($exclude_tag) && in_array($itemTag['id_tag'], $exclude_tag)) selected @endif value="{{$itemTag['id_tag']}}" >{{$itemTag['tag_name']}}</option>
                                @endforeach
                            </select>
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
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject sbold uppercase font-blue">New Product Recommendation</span>
                </div>
                <div class="pull-right">
                    <a class="btn blue" id="other_rec">Other Recommendation</a>
                </div>
            </div>
            <div class="portlet-body">
                <h4 id="recommendation">{{$recommendation}}</h4>
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject sbold uppercase font-blue">New Top Product in
                        <span>
                            <select id="selectmonth" name="month" class="form-control" style="width:auto; display:inline; color:#3598dc; font-size:16px; padding:0">
                                <option value="1" @if($month == '1') selected @endif>JANUARY</option>
                                <option value="2" @if($month == '2') selected @endif>FEBRUARY</option>
                                <option value="3" @if($month == '3') selected @endif>MARCH</option>
                                <option value="4" @if($month == '4') selected @endif>APRIL</option>
                                <option value="5" @if($month == '5') selected @endif>MAY</option>
                                <option value="6" @if($month == '6') selected @endif>JUNE</option>
                                <option value="7" @if($month == '7') selected @endif>JULY</option>
                                <option value="8" @if($month == '8') selected @endif>AUGUST</option>
                                <option value="9" @if($month == '9') selected @endif>SEPTEMBER</option>
                                <option value="10" @if($month == '10') selected @endif>OCTOBER</option>
                                <option value="11" @if($month == '11') selected @endif>NOVEMBER</option>
                                <option value="12" @if($month == '12') selected @endif>DECEMBER</option>
                            </select>
                            <select id="selectyear" name="year" class="form-control" style="width:auto; display:inline; color:#3598dc; font-size:16px; padding:0">
                                @php $thisYear = date('Y'); @endphp
                                @for($i = $thisYear; $i>=$minYear; $i--)
                                    <option value="{{$i}}" @if($year == $i) selected @endif>{{$i}}</option>
                                @endfor
                            </select>
                    </span>
                    </span>
                </div>
            </div>
            <div class="portlet-body row">
                <div class="col-md-6 col-xs-12">
                    <b><p style="font-size:16px">By Recurring</p></b>
                    <div id="newTopRec">
                        @if(count($newTopQty) <= 0)
                            <p>There are no new top products</p>
                        @endif
                        @foreach($newTopRec as $new)
                            <li>{{$new['product_name']}}</li>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <b><p style="font-size:16px">By Quantity</p></b>
                    <div id="newTopQty">
                        @if(count($newTopQty) <= 0)
                            <p>There are no new top products</p>
                        @endif
                        @foreach($newTopQty as $new)
                            <li>{{$new['product_name']}}</li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject sbold uppercase font-blue">Report</span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption ">
                            <span class="caption-subject sbold uppercase font-yellow">Filter Report</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
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
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <select class="form-control select2" name="id_outlet" data-placeholder="select outlet" required>
                                        <optgroup label="Outlet List">
                                            <option value="0" selected>All</option>
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
                    </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption ">
                            <span class="caption-subject sbold uppercase font-yellow">Top 10 Tag By Recurring</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div id="recurringTag"></div>
                    </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption ">
                            <span class="caption-subject sbold uppercase font-yellow">Top 10 Tag By Quantity</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div id="quantityTag"></div>
                    </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption ">
                            <span class="caption-subject sbold uppercase font-yellow">Top 10 Product By Recurring</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div id="recurring"></div>
                    </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption ">
                            <span class="caption-subject sbold uppercase font-yellow">Top 10 Product By Quantity</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div id="quantity"></div>
                    </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-yellow sbold uppercase">Data Tag </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                            <thead>
                                <tr>
                                    <th> Tag Name </th>
                                    <th> Recurring </th>
                                    <th> Quantity </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($dataTag))
                                    @foreach($dataTag as $value)
                                        <tr>
                                            <td>{{ $value['tag_name'] }}</td>
                                            <td>{{ $value['total_rec'] }}</td>
                                            <td>{{ $value['total_qty'] }}</td>
                                            <td>
                                                @php
                                                    if(!isset($id_outlet)){
                                                        $id_outlet = 0;
                                                    }
                                                @endphp
                                                <a href="{{ url('report/tag/detail') }}/{{ $value['id_tag'] }}/{{ $date_start }}/{{ $date_end }}/{{ $id_outlet }}" data-popout="true" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
