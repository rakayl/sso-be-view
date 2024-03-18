@php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
    $codeColor = [
            1 => 'badge-danger',
            2 => 'badge-warning',
            3 => 'badge-secondary',
            4 => 'badge-warning',
            5 => 'badge-warning',
            6 => 'badge-success',
        ];
@endphp
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <style>


#chartdiv_bussiness {
  width: 100%;
  height: 400px;
}
#chartdiv_vendor_category {
  width: 100%;
  height: 300px;
}
#vendorCategory {
  width: 100%;
  height: 300px;
}
#departPemesananNominal {
  width: 100%;
  height: 400px;
}
#departPemesananQty {
  width: 100%;
  height: 400px;
}
#departPiutangNominal {
  width: 100%;
  height: 400px;
}
#departPiutangQty {
  width: 100%;
  height: 400px;
}
#vendorOmsetNominal {
  width: 100%;
  height: 400px;
}
#vendorOmsetQty {
  width: 100%;
  height: 400px;
}
#vendorHutangNominal {
  width: 100%;
  height: 400px;
}
#vendorHutangQty {
  width: 100%;
  height: 400px;
}
</style>
@endsection

@section('page-plugin')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection

@section('page-script')
<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Responsive.js"></script>
    
    
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
<script type="text/javascript">
  $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    @if(Session::get('dari') && Session::get('sampai') )
            var dari = new Date("{{Session::get('dari')}}");
            var sampai = new Date("{{Session::get('sampai')}}");
            var dariFormatted = moment(dari);
            var sampaiFormatted = moment(sampai);
        @else
            
            var start = moment().subtract(29, 'days');
            var end = moment();
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')); 
        @endif    
    
    function cb(e, a,t ,r=true) {
            var i = "",
                n = "";
            n = e.format("D MMMM YYYY") + " - " + a.format("D MMMM YYYY");
            $("#reportrange span").html(n);
            if (r==true) {
                var data = {
                    'dari' : e.format('YYYY-MM-DD'),
                    'sampai' : a.format('YYYY-MM-DD'),
                    'rangeLabel' : t,
                };
                  $.ajax({
                     type    : "get",
                    url     : "{{route('setrange')}}"+"?dari="+e.format('YYYY-MM-DD')+"&sampai="+a.format('YYYY-MM-DD'),
                    success: function (data) {
                        location.reload();
                    },
                    error: function (data) {
                       console.log(data);
                    }
                });
            }
        }
        @if(Session::get('dari') && Session::get('sampai') )
            cb(dariFormatted,sampaiFormatted,"{{Session::get('rangeLabel')}}",false);
        @endif

    $('#reportrange').daterangepicker({
        @if(Session::get('dari') && Session::get('sampai'))
                startDate: "{{Session::get('dari')}}",
                endDate: "{{Session::get('sampai')}}",
            @else
                startDate: start.format('YYYY-MM-DD'),
                endDate: end.format('YYYY-MM-DD'),    
            @endif
            
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            showDropdowns: true,
            opens: "right",
            locale: {
                "format": "YYYY-MM-DD",
                "separator": " - ",
                "applyLabel": "Sumbit",
                "cancelLabel": "Batal",
                "fromLabel": "Dari",
                "toLabel": "Sampai",
                "customRangeLabel": "Pilih Tanggal",
                "daysOfWeek": [
                    "Min",
                    "Sen",
                    "Sel",
                    "Rab",
                    "Kam",
                    "Jum",
                    "Sab"
                ],
                "monthNames": [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember"
                ],
                "firstDay": 1
            },
            ranges: {
               'Hari Ini': [moment(), moment()],
               '7 Hari Lalu': [moment().subtract(6, 'days'), moment()],
               '30 Hari Lalu': [moment().subtract(29, 'days'), moment()],
               'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
               'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
    }, cb);
    
      $.ajax({
                type: "get",
                url: "{{ url('dashboard/home') }}",
                dataType: 'json',
                cache: false,
                success: function(data) {
                    var html = [];
                    $.each(data, function(i, f) {
                         html +='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">\n\
                                    <div class="dashboard-stat dashboard-stat-v2 '+f.color+'">\n\
                                        <div class="visual"><i class="'+f.icon+'"></i></div>\n\
                                    <div class="details">\n\
                                     <div class="number"><span data-counter="counterup" data-value="'+f.amount+'">'+f.amount+'</span></div>\n\
                                             <div class="desc"> '+f.title+'</div> </div> </div> </div>'
                                
                               
                         $('#summary').html(html);      
                    });
                },
                error: function(data) {
                    console.log('gagal')
                }
            });
        $.ajax({
            type: "get",
            url: "{{ url('dashboard/cogs') }}",
            dataType: 'json',
            cache: false,
            success: function(data) {
                omset(data)
            },
            error: function(data) {
                console.log('gagal')
            }
        });
        $.ajax({
            type: "get",
            url: "{{ url('dashboard/categori') }}",
            dataType: 'json',
            cache: false,
            success: function(data) {
                vendorCategory(data)
            },
            error: function(data) {
                console.log('gagal')
            }
        });
        
       
});
</script>
<script>
function omset(data) {



// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv_bussiness");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  paddingLeft: 0,
  wheelX: "panX",
  wheelY: "zoomX",
  layout: root.verticalLayout
}));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(
  am5.Legend.new(root, {
    centerX: am5.p50,
    x: am5.p50
  })
);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {
  cellStartLocation: 0.1,
  cellEndLocation: 0.9,
  minorGridEnabled: true
})

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "date",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

xRenderer.grid.template.setAll({
  location: 1
})

xAxis.data.setAll(data);

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  renderer: am5xy.AxisRendererY.new(root, {
    strokeOpacity: 0.1
  })
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function makeSeries(name, fieldName) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: fieldName,
    categoryXField: "date"
  }));

  series.columns.template.setAll({
    tooltipText: "{name},pada minggu ke-{categoryX}:total {valueY}",
    width: am5.percent(90),
    tooltipY: 0,
    strokeOpacity: 0
  });

  series.data.setAll(data);

  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  series.appear();

  series.bullets.push(function () {
    return am5.Bullet.new(root, {
      locationY: 0,
      sprite: am5.Label.new(root, {
        text: "{valueY}",
        fill: root.interfaceColors.get("alternativeText"),
        centerY: 0,
        centerX: am5.p50,
        populateText: true
      })
    });
  });

  legend.data.push(series);
}

makeSeries("Pengosongan Tangki", "sedot");
makeSeries("Bangun & Renovasi", "renov");

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

};

function vendorCategory(data) {

// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("vendorCategory");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
var chart = root.container.children.push(
  am5percent.PieChart.new(root, {
    endAngle: 270
  })
);

// Create series
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
var series = chart.series.push(
  am5percent.PieSeries.new(root, {
    valueField: "value",
    categoryField: "category",
    endAngle: 270
  })
);

series.states.create("hidden", {
  endAngle: -90
});

// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
series.data.setAll(data);

series.appear(1000, 100);
};



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
            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
    </div>
    
    <div class="row"><div id='summary'></div></div>
    <div class="portlet light bordered">
            <div class="row" style=" margin-top: 25px;margin-bottom: 25px;">
             <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-primary">Omset Transaksi</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div id="chartdiv_bussiness"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="portlet light bordered">
            <div class="row" style=" margin-top: 25px;margin-bottom: 25px;">
             <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-primary">Recent Transaction</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Jenis Layanan</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($dashboard))
                                    @foreach($dashboard as $res)
                                        <tr>
                                            <td>{{ $res['transaction_receipt_number'] }}</td>
                                            <td>{{ $res['name'] }}</td>
                                            <td>{{ $res['layanan'] }}</td>
                                           
                                            <td><span class="badge badge-sm {{$codeColor[$res['status']]??'badge-default'}}" @if($res['status'] == 6) style="background-color: #28a745;" @endif>{{ $res['status_text'] }}</span></td>
                                            <td>
                                               <a class="btn btn-block yellow btn-xs" href="{{ url('transaction/detail', $res['id_transaction']) }}"><i class="icon-pencil"></i> Detail </a>
                                               
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
             <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-primary">Presentase Transaction</span>
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <div id="vendorCategory"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
     

@endsection
