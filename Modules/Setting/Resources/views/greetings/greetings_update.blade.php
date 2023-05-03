@extends('body')

@section('page-plugin-styles')
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('page-plugin-js')
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
@endsection

@section('page-scripts')
  <script type="text/javascript">var something = "Greetings";</script>
  <script type="text/javascript" src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/delete.js')}}"></script>
  <script type="text/javascript" src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/app.min.js')}}"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
  		$(document).ready(function() {
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
		        columnDefs: [{
		            className: "control",
		            orderable: !1,
		            targets: 0
		        }],
		        order: [0, "asc"],
		        lengthMenu: [
		            [5, 10, 15, 20, -1],
		            [5, 10, 15, 20, "All"]
		        ],
		        pageLength: 10,
		        "bPaginate" : true,
		        "bInfo" : true,
		        dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
  			});

  		});
  	</script>
<?php
if(isset($data)){
	$old = session()->getOldInput();
	if(!$old){
		$old = $data;
		/* if($old['news_video'])
		$old['news_video'] = 'https://www.youtube.com/watch?v='.$old['news_video']; */

	}
}
?>
@endsection

@section('content')
  <div id="loadingDiv" style="
    display:none;
    position:fixed;
    top:0px;
    right:0px;
    width:100%;
    height:100%;
    background-color:rgba(0, 0, 0, 0.1);
    background-image:url('{{URL::to('assets/pages/img/gears.gif')}}');
    background-repeat:no-repeat;
    background-position:center;
    z-index:10000000;
  "></div>
<div class="page-bar">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<a href="{{url('/')}}">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Settings</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="javascript:;">Greeting</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="#">Update</a>
		</li>
	</ul>
</div>

@include('notifications')
	@if(isset($data))
		@if($old)
			<form class="form-horizontal form-row-separated" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
			{{csrf_field()}}
				<div class="portlet light bordered row">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wrench font-green-sharp"></i>
							<span class="caption-subject font-green-sharp sbold">{{session('data')['title']}}</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="form-body">
							<div class="form-group" style="margin-left:40px;">
								<label class="col-md-3 control-label">When to Display <span class="required" aria-required="true"> * </span></label>
								<div class="col-md-9">
									<div class="input-icon right">
										<div class="radio-list" style="padding-left:20px">
											<label class="radio-inline">
												<input type="radio" name="when" id="optionsRadios4" value="morning" @if($data['when'] == 'morning') checked @endif> Morning </label>
											<label class="radio-inline">
												<input type="radio" name="when" id="optionsRadios5" value="afternoon"@if($data['when'] == 'afternoon') checked @endif> Afternoon </label>
											<label class="radio-inline">
												<input type="radio" name="when" id="optionsRadios6" value="evening" @if($data['when'] == 'evening') checked @endif> Evening </label>
											<label class="radio-inline">
												<input type="radio" name="when" id="optionsRadios7" value="late_night" @if($data['when'] == 'late_night') checked @endif> Late Night </label>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group" style="margin-left:40px">
								<label class="col-md-3 control-label">Text <span class="required" aria-required="true"> * </span></label>
								<div class="col-md-9">
									<div class="input-icon right">
										<input type="text" name="greeting" class="form-control" value = "{{$data['greeting']}}">
									</div>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<div class="col-md-2"></div>
							<div class="col-md-5">
							  <button type="submit" class="btn btn md green">Update</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		@endif
  @endif
@include('delete')
@endsection
