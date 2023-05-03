<?php
    use App\Lib\MyHelper;
    $grantedFeature     = session('granted_features');
 ?>
@extends('layouts.main')

@section('page-style')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
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

        $('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('autocrm/cron/delete') }}",
                data : "_token="+token+"&id_autocrm="+id,
                success : function(result) {
                    if (result == "success") {
                        $('#sample_1').DataTable().row(column).remove().draw();
                        toastr.info("Autocrm has been deleted.");
                    }
                    else if(result == "fail"){
                        toastr.warning("Failed to delete autocrm.");
                    }
                    else {
                        toastr.warning("Something went wrong. Failed to delete autocrm.");
                    }
                }
            });
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
</div>
@include('layouts.notifications')

<div class="row" style="margin-top:20px">
	<div class="col-md-12">
		<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-blue sbold uppercase ">{{ $sub_title }}</span>
                </div>
            </div>
			<div class="portlet-body">
				<div class="portlet-body form">
					@if(isset($result) && $result != '')
					<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
						<thead>
							<tr>
								<th>Title</th>
								<th>Trigger</th>
                                <th>Media</th>
                                @if(MyHelper::hasAccess([120,122,123], $grantedFeature))
                                    <th width=63x>Actions</th>
                                @endif
							</tr>
						</thead>
						<tbody>
							@foreach($result as $key => $data)
							<tr>
								<td>{{$data['autocrm_title']}}</td>
                                <td>{{$data['autocrm_trigger']}}
                                    @if($data['autocrm_trigger'] != 'Daily')
                                    : Every
                                        @if($data['autocrm_trigger'] == 'Yearly')
                                            @php $date = substr($data['autocrm_cron_reference'], 0, 2); $month = date('F', mktime(0,0,0,substr($data['autocrm_cron_reference'],-2),1,2011)) @endphp
                                            {{$month}}
                                            @if($date== '1' || $date== '21' || $date== '31')
                                                {{$date}}st
                                            @elseif($date== '2' || $date== '22')
                                                {{$date}}nd
                                            @elseif($date== '3' || $date== '23')
                                                {{$date}}rd
                                            @else
                                                {{$date}}th
                                            @endif
                                        @elseif($data['autocrm_trigger'] == 'Monthly')
                                            @if(strlen($data['autocrm_cron_reference']) <= 2)
                                                @if($data['autocrm_cron_reference'] == '1' || $data['autocrm_cron_reference'] == '21' || $data['autocrm_cron_reference'] == '31')
                                                {{$data['autocrm_cron_reference']}}st
                                                @elseif($data['autocrm_cron_reference'] == '2' || $data['autocrm_cron_reference'] == '22')
                                                {{$data['autocrm_cron_reference']}}nd
                                                @elseif($data['autocrm_cron_reference'] == '3' || $data['autocrm_cron_reference'] == '23')
                                                {{$data['autocrm_cron_reference']}}rd
                                                @else
                                                {{$data['autocrm_cron_reference']}}th
                                                @endif
                                            @else
                                                @php
                                                    $day = substr($data['autocrm_cron_reference'], 0, -2);
                                                    $week = substr($data['autocrm_cron_reference'], -1);
                                                @endphp
                                                {{$day}} on the
                                                @if($week == '1')
                                                    {{$week}}st week
                                                @elseif($week == '2')
                                                    {{$week}}nd week
                                                @elseif($week == '3')
                                                    {{$week}}rd week
                                                @elseif($week == '4')
                                                    {{$week}}th week
                                                @endif
                                            @endif
                                        @else
                                            {{$data['autocrm_cron_reference']}}
                                        @endif
                                    @endif
                                </td>
								<td>
									@if($data['autocrm_email_toogle'] == '1') Email <br> @endif
									@if($data['autocrm_sms_toogle'] == '1') SMS <br> @endif
									@if($data['autocrm_push_toogle'] == '1') Push <br> @endif
									@if($data['autocrm_inbox_toogle'] == '1') Inbox @endif
                                </td>
                                @if(MyHelper::hasAccess([120,122,123], $grantedFeature))
                                    <td>
                                        @if(MyHelper::hasAccess([123], $grantedFeature))
                                            <a data-toggle="confirmation" data-popout="true" class="btn btn-sm red delete" data-id="{{ $data['id_autocrm'] }}"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                        @if(MyHelper::hasAccess([120,122], $grantedFeature))
                                            <a href="{{ url('autocrm/edit') }}/{{ $data['id_autocrm'] }}" class="btn btn-sm blue"><i class="fa fa-search"></i></a>
                                        @endif
                                    </td>
                                @endif
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
						No User found with such conditions
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection