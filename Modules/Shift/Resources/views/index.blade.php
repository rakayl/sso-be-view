<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs     		= session('configs');
?>
@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.js') }}" type="text/javascript"></script>
    
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <script src="https://www.amcharts.com/lib/3/themes/none.js"></script>

    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $('#shift_list').dataTable({
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
				<a href="{{url('/')}}">Home</a>
                <i class="fa fa-circle"></i>
			</li>
			<li>
				<a href="{{url('/shift')}}">Shift</a>
			</li>
		</ul>
	</div>
    @include('layouts.notifications')
    
    <div class="portlet light bordered" style="margin-top:20px">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-equalizer font-blue-hoki"></i>
                <span class="caption-subject font-blue-hoki bold uppercase">Filter Shift</span>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ url('report/shift/summary') }}" class="horizontal-form" method="post">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Start Date</label>
                                <input type="date" class="form-control" name="shift_start_date" placeholder="dd/mm/yyyy"  @if(isset($post['shift_start_date'])) value="{{ date('Y-m-d', strtotime($post['shift_start_date'])) }}" @elseif(old('shift_start_date') !== null) value="{{date('Y-m-d', strtotime(old('shift_start_date')))}}" @else value="{{ date('Y-m-d') }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">End Date</label>
                                <input type="date" class="form-control" name="shift_end_date" placeholder="dd/mm/yyyy" @if(isset($post['shift_end_date'])) value="{{ date('Y-m-d', strtotime($post['shift_end_date'])) }}" @elseif(old('shift_end_date') !== null) value="{{date('Y-m-d', strtotime(old('shift_end_date')))}}" @else value="{{ date('Y-m-d') }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Outlet</label>
                                <select class="form-control input-sm select2" name="id_outlet">
                                    <option value="">All</option>
                                    @if (isset($outlets))
                                        @foreach ($outlets as $key => $outlet)
                                            <option value="{{ $outlet['id_outlet'] }}" @if (isset($post['id_outlet']) && $post['id_outlet'] == $outlet['id_outlet']) selected @elseif (old('id_outlet') == $outlet['id_outlet']) selected @endif>{{ $outlet['outlet_code'] }} - {{ $outlet['outlet_name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Outlet App User</label>
                                <select class="form-control input-sm select2" name="id_user_outletapp">
                                    <option value="">All</option>
                                    @if (isset($user_outletapps))
                                        @foreach ($user_outletapps as $key => $user_outletapp)
                                            <option value="{{ $user_outletapp['id_user_outletapp'] }}" @if (isset($post['id_user_outletapp']) && $post['id_user_outletapp'] == $user_outletapp['id_user_outletapp']) selected @elseif (old('id_user_outletapp') == $user_outletapp['id_user_outletapp']) selected @endif>{{ $user_outletapp['username'] }} - {{ $user_outletapp['level'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cash Start (Range Start)</label>
                                <input type="number" class="form-control" name="cash_start[range_start]" @if (isset($post['cash_start']['range_start'])) value="{{ $post['cash_start']['range_start'] }}" @else value="{{ old('cash_start')['range_start'] }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cash Start (Range End)</label>
                                <input type="number" class="form-control" name="cash_start[range_end]" @if (isset($post['cash_start']['range_end'])) value="{{ $post['cash_start']['range_end'] }}" @else value="{{ old('cash_start')['range_end'] }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cash End (Range Start)</label>
                                <input type="number" class="form-control" name="cash_end[range_start]" @if (isset($post['cash_end']['range_start'])) value="{{ $post['cash_end']['range_start'] }}" @else value="{{ old('cash_end')['range_start'] }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cash End (Range End)</label>
                                <input type="number" class="form-control" name="cash_end[range_end]" @if (isset($post['cash_end']['range_end'])) value="{{ $post['cash_end']['range_end'] }}" @else value="{{ old('cash_end')['range_end'] }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cash Difference (Range Start)</label>
                                <input type="number" class="form-control" name="cash_difference[range_start]" @if (isset($post['cash_difference']['range_start'])) value="{{ $post['cash_difference']['range_start'] }}" @else value="{{ old('cash_difference')['range_start'] }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cash Difference (Range End)</label>
                                <input type="number" class="form-control" name="cash_difference[range_end]" @if (isset($post['cash_difference']['range_end'])) value="{{ $post['cash_difference']['range_end'] }}" @else value="{{ old('cash_difference')['range_end'] }}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Difference Status</label>
                                <select class="form-control" name="difference_status">
                                	<option value=""></option>
                                    <option value="{{ 1 }}" @if (isset($post['difference_status']) && $post['difference_status'] == 1) selected @elseif (old('difference_status') !== null && old('difference_status') == 1) selected @endif>Difference</option>
                                    <option value="{{ 0 }}" @if (isset($post['difference_status']) && $post['difference_status'] == 0) selected @elseif (old('difference_status') !== null && old('difference_status') == 0) selected @endif>No Difference</option>
                                </select>
                            </div>
                        </div>
                    </div>
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

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered" >
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase"><i class="fa fa-list"></i> Shift</span>
					</div>
				</div>
				<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover dt-responsive" id="shift_list">
							<thead>
							<tr>
								<th scope="col"> No </th>
								<th scope="col"> Shift Date </th>
                                <th scope="col"> Outlet Code</th>
                                <th scope="col"> Outlet Name</th>
								<th scope="col"> Opened By </th>
								<th scope="col"> Open Time </th>
                                <th scope="col"> Close Time </th>
                                <th scope="col"> Cash Start </th>
                                <th scope="col"> Cash End </th>
                                <th scope="col"> Difference Status </th>
								<th scope="col"> Cash Difference </th>
							</tr>
							</thead>
							<tbody>
								@if(!empty($shifts))
									@foreach($shifts as $no => $shift)
                                        <tr>
                                            <td> {{$no+1}}</td>
                                            <td> {{date('d F Y', strtotime($shift['created_at']))}}</td>
											<td> {{$shift['outlet']['outlet_code']}} </td>
                                            <td> {{$shift['outlet']['outlet_name']}} </td>
                                            <td> {{$shift['user_outletapp']['username']}} </td>
                                            <td> {{$shift['open_time']}} </td>
                                            <td> {{$shift['close_time']}} </td>
                                            <td> {{$shift['cash_start']}} </td>
                                            <td> {{$shift['cash_end']}} </td>
											@if ($shift['cash_difference'] == 0 || $shift['cash_difference'] == null)
												<td style="color: red">False</td>
											@else
												<td>True</td>
											@endif
											<td>{{$shift['cash_difference']}}</td>
											{{-- <td> {!!str_replace(" ","&nbsp;", date('d F Y H:i', strtotime($shift['created_at'])))!!} </td>
											<td> {!!str_replace(" ","&nbsp;", date('d F Y H:i', strtotime($shift['updated_at'])))!!} </td> --}}
                                        </tr>
							        @endforeach
							    @endif
							</tbody>
						</table>
				</div>
			</div>
		</div>
	</div>
@endsection