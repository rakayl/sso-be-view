@php
	use App\Lib\MyHelper;
    $configs = session('configs');
@endphp
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        #chartdiv {
            width   : 100%;
            height  : 500px;
        }
        #chartdiv1 {
          width: 100%;
          height: 500px;
        }

        .amcharts-export-menu-top-right {
          top: 10px;
          right: 0;
        }

        #chartdiv2 {
          width: 100%;
          height: 500px;
        }
    </style>
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

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
                order: [0, "asc"],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
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

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-blue-hoki"></i>
                <span class="caption-subject font-blue-hoki bold uppercase">Summary</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row widget-row">
                <div class="col-md-4">
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">New Registration</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-red icon-layers"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="1,293">{{ $customer['new_customer']}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                </div>
                <div class="col-md-4">
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">Linked Customer</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-purple icon-screen-desktop"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="815">{{ $customer['linked_cust']}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                </div>
                <div class="col-md-4">
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">Android Customer</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="5,071">{{ $customer['android_cust']}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                </div>
                <div class="col-md-4">
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">Ios Customer</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green icon-bar-chart"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="1,293">{{ $customer['ios_customer']}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                </div>
                <div class="col-md-4">
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">Male Customer</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-dark icon-bulb"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="815">{{ $customer['male_customer']}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                </div>
                <div class="col-md-4">
                    <!-- BEGIN WIDGET THUMB -->
                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                        <h4 class="widget-thumb-heading">Female Customer</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-yellow icon-layers"></i>
                            <div class="widget-thumb-body">
                                <span class="widget-thumb-body-stat" data-counter="counterup" data-value="5,071">{{ $customer['female_customer']}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- END WIDGET THUMB -->
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-blue-hoki"></i>
                <span class="caption-subject font-blue-hoki bold uppercase">Customer By Age</span>
            </div>
        </div>
        <div class="portlet-body form">
            <div class="row widget-row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red">
                                    <span data-counter="counterup" data-value="{{ $customer['customer_age']['teens'] }}">{{ $customer['customer_age']['teens'] }}</span>
                                </h3>
                                <small>TEENS</small>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: 100%;" class="progress-bar progress-bar-success red">
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> Age </div>
                                <div class="status-number"> 11-17 </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green">
                                    <span data-counter="counterup" data-value="{{ $customer['customer_age']['young_adult'] }}">{{ $customer['customer_age']['young_adult'] }}</span>
                                </h3>
                                <small>YOUNG ADULT</small>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: 100%;" class="progress-bar progress-bar-success green">
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> Age </div>
                                <div class="status-number"> 18-24 </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue">
                                    <span data-counter="counterup" data-value="{{ $customer['customer_age']['adult'] }}">{{ $customer['customer_age']['adult'] }}</span>
                                </h3>
                                <small>ADULT</small>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: 100%;" class="progress-bar progress-bar-success blue">
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> Age </div>
                                <div class="status-number"> 25-34 </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-purple">
                                    <span data-counter="counterup" data-value="{{ $customer['customer_age']['old'] }}">{{ $customer['customer_age']['old'] }}</span>
                                </h3>
                                <small>OLD</small>
                            </div>
                        </div>
                        <div class="progress-info">
                            <div class="progress">
                                <span style="width: 100%;" class="progress-bar progress-bar-success purple">
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> Age </div>
                                <div class="status-number"> 35-100 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-blue-hoki"></i>
                <span class="caption-subject font-blue-hoki bold uppercase">Filter Customer</span>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ url('report/customer/summary') }}" class="horizontal-form" method="post">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <select class="form-control" name="status">
                                	<option value="">...</option>
                                    <option value="active" @if (isset($post['status']) && $post['status'] == 'active') selected @elseif (old('status') == 'active') selected @endif>Active</option>
                                    <option value="suspended" @if (isset($post['status']) && $post['status'] == 'suspended') selected @elseif (old('status') == 'suspended') selected @endif>Suspended</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Register From</label>
                                <select class="form-control" name="from">
                                	<option value="">...</option>
                                    <option value="app" @if (isset($post['from']) && $post['from'] == 'app') selected @elseif (old('from') == 'app') selected @endif>Apps</option>
                                    <option value="outlet" @if (isset($post['from']) && $post['from'] == 'outlet') selected @elseif (old('from') == 'outlet') selected @endif>Outlet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Gender</label>
                                <select class="form-control" name="gender">
                                	<option value="">...</option>
                                    <option value="male" @if (isset($post['gender']) && $post['gender'] == 'male') selected @elseif (old('gender') == 'male') selected @endif>Male</option>
                                    <option value="female" @if (isset($post['gender']) && $post['gender'] == 'female') selected @elseif (old('gender') == 'female') selected @endif>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">City</label>
                                <select class="form-control input-sm select2" name="city">
                                	<option value="">...</option>
                                	@if (isset($city))
                                		@foreach ($city as $key => $c)
                                			<option value="{{ $c['id_city'] }}" @if (isset($post['city']) && $post['city'] == $c['id_city']) selected @elseif (old('city') == $c['id_city']) selected @endif>{{ $c['city_name'] }}</option>
                                		@endforeach
                                	@endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Age Range Start</label>
                                <input type="number" class="form-control" name="age_start" @if (isset($post['age_start'])) value="{{ $post['age_start'] }}" @else value="{{ old('age_start') }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Age Range End</label>
                                <input type="number" class="form-control" name="age_end" @if (isset($post['age_end'])) value="{{ $post['age_end'] }}" @else value="{{ old('age_end') }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Registration Date Start</label>
                                <input type="date" class="form-control" name="regis_date_start" placeholder="dd/mm/yyyy" @if (isset($post['regis_date_start'])) value="{{ $post['regis_date_start'] }}" @else value="{{ old('regis_date_start') }}"  @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Registration Date End</label>
                                <input type="date" class="form-control" name="regis_date_end" placeholder="dd/mm/yyyy" @if (isset($post['regis_date_end'])) value="{{ $post['regis_date_end'] }}" @else value="{{ old('regis_date_end') }}"  @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Device Type</label>
                                <select class="form-control" name="device">
                                	<option value="">...</option>
                                    <option value="android" @if (isset($post['device']) && $post['device'] == 'android') selected @elseif (old('device') == 'android') selected @endif>Android</option>
                                    <option value="ios" @if (isset($post['device']) && $post['device'] == 'ios') selected @elseif (old('device') == 'ios') selected @endif>Ios</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" class="form-control" name="name" @if (isset($post['name'])) value="{{ $post['name'] }}" @else value="{{ old('name') }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email" @if (isset($post['email'])) value="{{ $post['email'] }}" @else value="{{ old('email') }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Phone</label>
                                <input type="text" class="form-control" name="phone" @if (isset($post['phone'])) value="{{ $post['phone'] }}" @else value="{{ old('phone') }}" @endif>
                            </div>
                        </div>
                    </div>
                    @if(MyHelper::hasAccess([18], $configs))
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Total Point Start</label>
                                <input type="number" class="form-control" name="point_start" @if (isset($post['point_start'])) value="{{ $post['point_start'] }}" @else value="{{ old('point_start') }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Total Point End</label>
                                <input type="number" class="form-control" name="point_end" @if (isset($post['point_end'])) value="{{ $post['point_end'] }}" @else value="{{ old('point_end') }}" @endif>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(MyHelper::hasAccess([20], $configs))
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Membership Level</label>
                                <select class="form-control input-sm select2" name="id_membership">
                                    <option value="0">...</option>
                                    @foreach ($membership as $dataMembership)
                                        <option value="{{$dataMembership['id_membership']}}" @if (isset($post['id_membership']) && $post['id_membership'] == $dataMembership['id_membership']) selected @elseif (old('id_membership') == $dataMembership['id_membership']) selected @endif>{{$dataMembership['membership_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                {{ csrf_field() }}
                <div class="form-actions left">
                    <button type="submit" class="btn blue">
                        <i class="fa fa-check"></i> Submit</button>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
    @if (isset($cust))
        <div class="portlet light portlet-fit bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-red sbold uppercase">Customer</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
            <thead>
              <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Gender</th>
                  <th>Provider</th>
                  <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                @if(!empty($customer['data_customer']))
                    @foreach($customer['data_customer'] as $res)
                        <tr>
                            <td>{{ $res['name'] }}</td>
                            <td>{{ $res['phone'] }}</td>
                            <td>{{ $res['email'] }}</td>
                            <td>{{ $res['gender'] }}</td>
                            <td>{{ $res['provider'] }}</td>
                            <td>
                                <a class="btn btn-block yellow btn-xs" href="{{ url('report/customer/detail/'.$res['phone'].'/transactions') }}"><i class="icon-pencil"></i> Detail </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection
