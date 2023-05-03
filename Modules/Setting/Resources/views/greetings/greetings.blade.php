@extends('body')

@section('page-plugin-styles')
<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('page-plugin-js')
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
@endsection

@section('page-scripts')
  <script type="text/javascript">var something = "Greetings";</script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
  <script type="text/javascript" src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/delete.js')}}"></script>
  <script type="text/javascript" src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/app.min.js')}}"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/portlet-draggable.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/portfolio-1.min.js')}}" type="text/javascript"></script>
  <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>
  <script>
	function hapus(value){
		swal({
		  title: "Anda yakin menghapus background image ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Ya, Hapus saja!",
		  closeOnConfirm: false
		},
		function(){
			document.getElementById('txtvalue').value = value;
			frmdelete.submit();
		});
	}

	</script>
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
    background-image:url('{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/img/gears.gif')}}');
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
		</li>
	</ul>
</div>

@include('notifications')
	@if(isset($data))
		@if($old)
			<div class="form">
				<form class="form-horizontal form-row-separated" action="{{Request::url()}}" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
					<div class="alert alert-danger display-hide">
						<button class="close" data-close="alert"></button> You have some form errors. Please check below.
					</div>
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class=" icon-layers font-green"></i>
								<span class="caption-subject font-green bold uppercase">{{session('data')['title']}}</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body">
								<div class="form-group" style="margin-left:40px">
									<label class="col-md-2 control-label">Morning <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="text" name="greetings_morning" class="form-control timepicker timepicker-default" value="{{$old['greetings_morning']}}">
										</div>
									</div>
								</div>
								<div class="form-group" style="margin-left:40px">
									<label class="col-md-2 control-label">Afternoon <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-10">
										<div class="input-icon right">
											<input type="text" name="greetings_afternoon" class="form-control timepicker timepicker-default" value="{{$old['greetings_afternoon']}}">
										</div>
									</div>
								</div>
								<div class="form-group" style="margin-left:40px">
									<label class="col-md-2 control-label">Evening <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-10">
										<div class="input-icon right">
											 <input type="text" name="greetings_evening" class="form-control timepicker timepicker-default" value="{{$old['greetings_evening']}}">
										</div>
									</div>
								</div>
								<div class="form-group" style="margin-left:40px">
									<label class="col-md-2 control-label">Late Night <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-10">
										<div class="input-icon right">
											 <input type="text" name="greetings_late_night" class="form-control timepicker timepicker-default" value="{{$old['greetings_late_night']}}">
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
				<form class="form-horizontal form-row-separated" action="{{url('settings/greeting/create')}}" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-wrench font-green-sharp"></i>
								<span class="caption-subject font-green-sharp sbold">Create New Greetings Text</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body">
								<div class="form-group" style="margin-left:40px">
									<label class="col-md-3 control-label">When to Display <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-9">
										<div class="input-icon right">
											<div class="radio-list" style="padding-left:20px">
												<label class="radio-inline">
													<input type="radio" name="when" id="optionsRadios4" value="morning" checked> Morning </label>
												<label class="radio-inline">
													<input type="radio" name="when" id="optionsRadios5" value="afternoon"> Afternoon </label>
												<label class="radio-inline">
													<input type="radio" name="when" id="optionsRadios6" value="evening"> Evening </label>
												<label class="radio-inline">
													<input type="radio" name="when" id="optionsRadios7" value="late_night"> Late Night </label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group" style="margin-left:40px">
									<label class="col-md-3 control-label">Text <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-9">
										<div class="input-icon right">
											<input type="text" name="greeting" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-2"></div>
								<div class="col-md-5">
								  <button type="submit" class="btn btn md green">Create</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wrench font-green-sharp"></i>
							<span class="caption-subject font-green-sharp sbold">Greetings Random Text</span>
						</div>
					</div>
					<div class="portlet-body">
						<table  class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
						<thead>
							<tr>
								<th class="all">No</th>
								<th class="all">When to Display</th>
								<th class="all">Text</th>
								<th class="noExport">Actions</th>
							</tr>
						</thead>
						<tbody>

						@if(!empty($data['greetings']))
							<?php $x = 1; ?>
							@foreach($data['greetings'] as $key=>$row)
							<tr>
								<td> {{ $x }} </td>
								<td> {{ str_replace('_',' ', $row['when']) }} </td>
								<td> {{ $row['greeting'] }} </td>
								<td class="noExport">
									<div class="btn-group pull-right">
									  <button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Actions
										  <i class="fa fa-angle-down"></i>
									  </button>
									  <ul class="dropdown-menu pull-right">
										  <li>
											  <a href="{{url('settings/greeting/update/'.$row['id_greetings'])}}" target="_blank" >
												  <i class="fa fa-edit"></i> Edit </a>
										  </li>
										  <li>
											<form id="delete-{{$key}}" action="<?php echo url('settings/greeting/delete')?>" method="post" hidden>
											  {{csrf_field()}}
											  <div hidden id="name-{{$key}}">{{ $row['greeting'] }}</div>
											  <input type="text" name="id_greetings" value="{{ $row['id_greetings'] }}" hidden>
											</form>
											<a class="delete" data-for="{{$key}}"><i class="fa fa-trash"></i> Delete</a>
										  </li>
									  </ul>
								  </div>
								</td>
							</tr>
							<?php $x++; ?>
							@endforeach
						@endif
						</tbody>
					</table>
					</div>
				</div>
				<form class="form-horizontal form-row-separated" action="{{url('settings/background/create')}}" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-wrench font-green-sharp"></i>
								<span class="caption-subject font-green-sharp sbold">Create New Home Background</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body">
								<div class="form-group" style="margin-left:40px">
									<label class="col-md-3 control-label">When to Display <span class="required" aria-required="true"> * </span></label>
									<div class="col-md-9">
										<div class="input-icon right">
											<div class="radio-list" style="padding-left:20px">
												<label class="radio-inline">
													<input type="radio" name="when" id="optionsRadios4" value="morning" checked> Morning </label>
												<label class="radio-inline">
													<input type="radio" name="when" id="optionsRadios5" value="afternoon"> Afternoon </label>
												<label class="radio-inline">
													<input type="radio" name="when" id="optionsRadios6" value="evening"> Evening </label>
												<label class="radio-inline">
													<input type="radio" name="when" id="optionsRadios7" value="late_night"> Late Night </label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group" style="margin-left:40px">
									<label class="col-md-3 control-label">Background Image</label>
									<div class="col-md-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 300px; height: 180px;">
												<img src="{{ env('STORAGE_URL_API')}}assets/pages/img/noimg-500-375.png" alt="">
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
											<div>
												<span class="btn default btn-file">
												<span class="fileinput-new"> Select image </span>
												<span class="fileinput-exists"> Change </span>
												<input type="file" accept="image/*" name="background">
												</span>
												<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-2"></div>
								<div class="col-md-5">
								  <button type="submit" class="btn btn md green">Create</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wrench font-green-sharp"></i>
							<span class="caption-subject font-green-sharp sbold">Home Background List</span>
						</div>
					</div>
					<div class="portlet-body row" style="padding:20px">
						@if(isset($data['background']))
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab"> Morning </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab"> Afternoon </a>
								</li>
								<li>
									<a href="#tab_1_3" data-toggle="tab"> Evening </a>
								</li>
								<li>
									<a href="#tab_1_4" data-toggle="tab"> Late Night </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">
									@foreach($data['background'] as $row)
										@if($row['when'] == 'morning')
										<div class="col-md-3 ui-state-default" id="photo-{{$row['id_home_background']}}" style="text-align:center;padding: 20px;margin-top:20px;background-color: #dedede;margin-right:30px" draggable="true">
											<img src="{{ env('STORAGE_URL_API')}}{{$row['picture']}}" alt="Category Image" width="150">
											<br><br>
											<a href="{{env('STORAGE_URL_API')}}{{$row['picture']}}" class="cbp-lightbox cbp-l-caption-buttonRight btn blue uppercase btn blue uppercase" style="font-size: 14px;padding: 6px;">View</a>

											<a onClick="hapus('{{$row['id_home_background']}}')" class="btn red uppercase" >Delete</a>
										</div>
										@endif
									@endforeach
								</div>
								<div class="tab-pane fade in" id="tab_1_2">
									@foreach($data['background'] as $row)
										@if($row['when'] == 'afternoon')
										<div class="col-md-3 ui-state-default" id="photo-{{$row['id_home_background']}}" style="text-align:center;padding: 20px;margin-top:20px;background-color: #dedede;margin-right:30px" draggable="true">
											<img src="{{ env('STORAGE_URL_API')}}{{$row['picture']}}" alt="Category Image" width="150">
											<br><br>
											<a href="{{env('STORAGE_URL_API')}}{{$row['picture']}}" class="cbp-lightbox cbp-l-caption-buttonRight btn blue uppercase btn blue uppercase" style="font-size: 14px;padding: 6px;">View</a>

											<a onClick="hapus('{{$row['id_home_background']}}')" class="btn red uppercase" >Delete</a>
										</div>
										@endif
									@endforeach
								</div>
								<div class="tab-pane fade in" id="tab_1_3">
									@foreach($data['background'] as $row)
										@if($row['when'] == 'evening')
										<div class="col-md-3 ui-state-default" id="photo-{{$row['id_home_background']}}" style="text-align:center;padding: 20px;margin-top:20px;background-color: #dedede;margin-right:30px" draggable="true">
											<img src="{{ env('STORAGE_URL_API')}}{{$row['picture']}}" alt="Category Image" width="150">
											<br><br>
											<a href="{{env('STORAGE_URL_API')}}{{$row['picture']}}" class="cbp-lightbox cbp-l-caption-buttonRight btn blue uppercase btn blue uppercase" style="font-size: 14px;padding: 6px;">View</a>

											<a onClick="hapus('{{$row['id_home_background']}}')" class="btn red uppercase" >Delete</a>
										</div>
										@endif
									@endforeach
								</div>
								<div class="tab-pane fade in" id="tab_1_4">
									@foreach($data['background'] as $row)
										@if($row['when'] == 'late_night')
										<div class="col-md-3 ui-state-default" id="photo-{{$row['id_home_background']}}" style="text-align:center;padding: 20px;margin-top:20px;background-color: #dedede;margin-right:30px" draggable="true">
											<img src="{{ env('STORAGE_URL_API')}}{{$row['picture']}}" alt="Category Image" width="150">
											<br><br>
											<a href="{{env('STORAGE_URL_API')}}{{$row['picture']}}" class="cbp-lightbox cbp-l-caption-buttonRight btn blue uppercase btn blue uppercase" style="font-size: 14px;padding: 6px;">View</a>

											<a onClick="hapus('{{$row['id_home_background']}}')" class="btn red uppercase" >Delete</a>
										</div>
										@endif
									@endforeach
								</div>
							</div>
						</div>
						<div class="portfolio-content portfolio-1">
							<div id="js-grid-juicy-projects" class="cbp">
								@foreach($data['background'] as $row)
								<div class="cbp-item graphic">

								</div>
								@endforeach
							</div>
						</div>
					@endif
				</div>
			</div>
		@endif
  @endif
@include('delete')
<form id="frmdelete" method="post" action="{{URL::to('settings/background/delete')}}">
	{{csrf_field()}}
	<input type="hidden" name="id_home_background" id="txtvalue">
</form>
@endsection