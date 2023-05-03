<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>
@extends('layouts.main')
@include('filter-v2')

@section('page-style')
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" /> 
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dropleft .dropdown-menu{
        	top: -100% !important;
        	left: -180px !important;
        	right: auto;
        }
		.btn-group > .dropdown-menu::after, .dropleft > .dropdown-toggle > .dropdown-menu::after, .dropdown > .dropdown-menu::after {
            opacity: 0;
		}
		.btn-group > .dropdown-menu::before, .dropleft > .dropdown-toggle > .dropdown-menu::before, .dropdown > .dropdown-menu::before {
            opacity: 0;
		}
        .modal-open .select2-container--open { z-index: 999999 !important; width:100% !important; }
    </style>
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
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
	@yield('filter_script')
<script>
    rules={
        all_transaction:{
            display:'All Consultation',
            operator:[],
            opsi:[]
        },
        transaction_receipt_number:{
            display:'Transaction Receipt Number',
            operator:[
                ['=','='],
                ['like','like'],
            ],
            opsi:[],
            placeholder:'Transaction Receipt Number'
        },
		outlet:{
            display:'Outlet',
            operator:[],
            opsi:{!!json_encode(array_map(function($outlet) {
                return [$outlet, $outlet];
            }, $outlet))!!},
            placeholder:'Outlet Clinic'
        },
		consultation_type:{
            display:'Consultation Type',
            operator:[
                ['=','=']
            ],
			opsi:[
                ['scheduled', 'Scheduled Consultation'],
                ['now', 'Now [Instant] Consultation']
            ],
            placeholder: 'Select Quest Benefit'
        },
		consultation_status:{
            display:'Consultation Status',
            operator:[
                ['=','=']
            ],
			opsi:[
                ['soon', 'Scheduled'],
                ['done', 'Waiting Result'],
				['completed', 'Completed'],
				['missed', 'Missed'],
				['canceled', 'Canceled'],
            ],
            placeholder: 'Select Quest Benefit'
        },
    };
    var table;
</script>
	<script>
		$(document).ready(function() {
			$('#table-consultation').dataTable({
				ajax: {
					url : "{{url()->current()}}",
					type: 'GET',
					data: function (data) {
						console.log(data);
						const info = $('#table-consultation').DataTable().page.info();
						data.page = (info.start / info.length) + 1;
					},
					dataSrc: (res) => {
						$('#list-filter-result-counter').text(res.total);
						return res.data;
					}
				},
				serverSide: true,
				columns: [
					{
						data: "id_transaction",
						render: function(value, type, row) {
							return `
								@if(MyHelper::hasAccess([330], $grantedFeature))
								<a href="{{url('consultation/be')}}/${value}/detail" class="btn btn-block yellow btn-xs"><i class="icon-pencil"></i> Detail</a>
								@endif
							`;
						},
					},
					// {
					// 	data: "consultation.consultation_status",
					// 	render: function(data){return `<span class="badge badge-default badge-sm" style="background-color:#ff0000">${data}</span>`;}
					// },
					{ 
						data: 'consultation.consultation_status',
						render: function(data){
							console.log('Content of data is : '+data);
							sev='';
							switch (data){
							case 'soon':
							sev = '<span class="badge badge-sm badge-secondary">Scheduled</span>';
							break;
							case 'ongoing':
							sev = '<span class="badge badge-sm badge-warning">Ongoing</span>';
							break;
							case 'done':
							sev = '<span class="badge badge-sm badge-success" style="background-color: #28a745;">Waiting Result</span>';
							break;
							case 'completed':
							sev = '<span class="badge badge-sm badge-success" style="background-color: #28a745;">Completed</span>';
							break;
							case 'canceled':
							sev = '<span class="badge badge-sm badge-danger">Canceled</span>';
							break;
							case 'missed':
							sev = '<span class="badge badge-sm badge-danger">Missed</span>';
							break;
							}
							return sev;
							console.log('Content of sev is : '+data);
						},
					},
					{
						data: "transaction_receipt_number",
						render: function(data) {return `${data}`;},
					},
					{
						data: "transaction_date",
						render: function(data) {return moment(data).format('DD MMMM YYYY HH:mm');},
					},
					{
						data: "outlet.outlet_name",
					},
					{
						data: "consultation.doctor.doctor_name",
					},
					{
						data: "consultation.user.name",
					},
					{
						data: "consultation.consultation_type"
					}
				],
				searching: false,
				ordering: false
			});
		})
	</script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#">Home</a>
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

	<div style="margin-top:20px">
		@yield('filter_view')
	</div>

	<div class="row" style="margin-top:20px">
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered" >
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-blue sbold uppercase"><i class="fa fa-list"></i> {{$title}} </span>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered table-hover" id="table-consultation">
						<thead>
						<tr>
							<th> </th>
							<th scope="col"> Consulation Status </th>
							<th scope="col"> Transaction Receipt Number </th>
							<th scope="col"> Date </th>
							<th scope="col"> Outlet </th>
							<th scope="col"> Doctor </th>
							<th scope="col"> Customer </th>
							<th scope="col"> Consultation Type </th>
						</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection