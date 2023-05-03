<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
?>

@extends('layouts.main')

@section('page-style')
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/css/profile-2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-script')
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-multi-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/ui-confirmations.min.js') }}" type="text/javascript"></script>
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/pages/scripts/components-editors.min.js') }}" type="text/javascript"></script>
	<script>
		$('.table-scrollable').on('show.bs.dropdown', function () {
			$('.table-scrollable').css( "overflow", "inherit" );
		});

		$('.table-scrollable').on('hide.bs.dropdown', function () {
			$('.table-scrollable').css( "overflow", "auto" );
		})

		$('#sample_1').on('click', '.delete', function() {
            var token  = "{{ csrf_token() }}";
            var column = $(this).parents('tr');
            var id     = $(this).data('id');

            $.ajax({
                type : "POST",
                url : "{{ url('promotion/delete') }}",
                data : "_token="+token+"&id_promotion="+id,
                success : function(result) {
					console.log(result)
                    if (result.status == "success") {
						column.remove();
                        toastr.info("Promotion has been deleted.");
                    }
                    else {
                        toastr.warning(result.messages[0]);
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
				<div class="caption font-blue ">
					<i class="icon-settings font-blue "></i>
					<span class="caption-subject bold uppercase">Promotion List</span>
				</div>
			</div>
			<div class="portlet-body row" style="margin-left:0; margin-right:0">
                <div class="pull-right" style="margin-top:20px;margin-bottom:15px">
                    @if(isset($post['promotion_name']) && $post['promotion_name'] != "")
                        <div class="col-md-6" style="padding-right:0">
                    @else
                        <div class="col-md-9" style="padding-right:0">
                    @endif
						<form action="" method="POST">
						<input type="text" class="form-control" name="promotion_name" placeholder="Search Promotion Name" @if(isset($post['promotion_name']) && $post['promotion_name'] != "") value = "{{$post['promotion_name']}}" @endif>
					</div>
					<div class="col-md-2" style="padding-left:0">
						{{ csrf_field() }}
						<button type="submit" class="btn blue" id="checkBtn">Search</button>
						</form>
					</div>
					<div class="col-md-3" style="padding:0">
						@if(isset($post['promotion_name']) && $post['promotion_name'] != "")
							<form method="post" action="">
								{{ csrf_field() }}
								<input hidden name="reset" value="reset">
								<button type="submit" class="btn red">Reset Search</button>
							</form>
						@endif
					</div>
				</div>
				<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover" id="sample_1">
						<thead>
							<tr>
								<th>No</th>
								<th>Promotion Name</th>
								<th>Type</th>
								<th>Send Time</th>
								@if(MyHelper::hasAccess([110,112,113], $grantedFeature))
									<th width=10%>Action</th>
								@endif
							</tr>
						</thead>
						<tbody>
                            @php $no = $from; @endphp
							@foreach($result as $key => $data)
							<tr>
								<td>{{$no}}</td>
								<td>{{$data['promotion_name']}}</td>
								<td>{{$data['promotion_type']}}</td>
								<td>
                                    @if(isset($data['promotion_type']) && $data['promotion_type'] == "Instant Campaign")
                                        {{date('d F Y', strtotime($data['schedules'][0]['schedule_exact_date']))}} at {{substr($data['schedules'][0]['schedule_time'],0,-3)}}
									@endif
									@if(isset($data['promotion_type']) && $data['promotion_type'] == "Scheduled Campaign")
                                        {{date('d F Y', strtotime($data['schedules'][0]['schedule_exact_date']))}} at {{substr($data['schedules'][0]['schedule_time'],0,-3)}}
									@endif

									@if(isset($data['promotion_type']) && ($data['promotion_type'] == "Recurring Campaign" || $data['promotion_type'] == "Campaign Series"))
										@if(isset($data['schedules'][0]['schedule_date_month']) && $data['schedules'][0]['schedule_date_month'] != "")
											<?php
												$year = date('Y');
												$x = explode('-',$data['schedules'][0]['schedule_date_month']);
											?>
											Every {{date('F', strtotime($year.'-'.$x[1].'-'.$x[0]))}}{{$x[0]}} each year at {{substr($data['schedules'][0]['schedule_time'],0,-3)}}
										@endif
										@if(isset($data['schedules'][0]['schedule_date_every_month']) && $data['schedules'][0]['schedule_date_every_month'] != "")
											<?php
												$ends = array('th','st','nd','rd','th','th','th','th','th','th');
												if (($data['schedules'][0]['schedule_date_every_month'] %100) >= 11 && ($data['schedules'][0]['schedule_date_every_month']%100) <= 13)
												   $abbreviation = $data['schedules'][0]['schedule_date_every_month']. 'th';
												else
												   $abbreviation = $data['schedules'][0]['schedule_date_every_month']. $ends[$data['schedules'][0]['schedule_date_every_month'] % 10];
											?>
											Every {{$abbreviation}} each month at {{substr($data['schedules'][0]['schedule_time'],0,-3)}}
										@endif

										@if(isset($data['schedules'][0]['schedule_day_every_week']) && $data['schedules'][0]['schedule_day_every_week'] != "")
											<?php
												$ends = array('th','st','nd','rd','th','th','th','th','th','th');
												if (($data['schedules'][0]['schedule_week_in_month'] %100) >= 11 && ($data['schedules'][0]['schedule_week_in_month']%100) <= 13)
												   $abbreviation = $data['schedules'][0]['schedule_week_in_month']. 'th';
												else
												   $abbreviation = $data['schedules'][0]['schedule_week_in_month']. $ends[$data['schedules'][0]['schedule_week_in_month'] % 10];
											?>
												Every {{$data['schedules'][0]['schedule_day_every_week']}}

												@if($data['schedules'][0]['schedule_week_in_month'] != 0)
													on {{$abbreviation}} week
												@else
													every week
												@endif
												at {{substr($data['schedules'][0]['schedule_time'],0,-3)}}

										@endif

										@if(isset($data['schedules'][0]['schedule_everyday']) && $data['schedules'][0]['schedule_everyday'] == 'Yes')
											Every Day at {{substr($data['schedules'][0]['schedule_time'],0,-3)}}
										@endif

									@endif
								</td>
								@if(MyHelper::hasAccess([110,112,113], $grantedFeature))
									<td>
										<div class="btn-group pull-right">
											<button class="btn blue btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Actions
											<i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right">
												@if(MyHelper::hasAccess([112], $grantedFeature))
												<li>
													<a href="{{ url('promotion/step1') }}/{{ $data['id_promotion'] }}">
													<i class="fa fa-edit"></i> Edit Information </a>
												</li>
												<li>
													<a href="{{ url('promotion/step2') }}/{{ $data['id_promotion'] }}">
													<i class="fa fa-edit"></i> Edit Content </a>
												</li>
												@endif
												@if(MyHelper::hasAccess([110], $grantedFeature))
												<li>
													<a href="{{ url('promotion/step3') }}/{{ $data['id_promotion'] }}">
													<i class="fa fa-gear"></i> Summary </a>
												</li>
												@endif
												@if(MyHelper::hasAccess([113], $grantedFeature))
												<li>
													<a class="delete" href="javascript:;" data-toggle="confirmation" data-placement="top" data-id="{{$data['id_promotion']}}">
													<i class="fa fa-trash-o"></i> Delete </a>
												</li>
												@endif
											</ul>
										</div>
									</td>
								@endif
                            </tr>
                            @php $no++; @endphp
							@endforeach
						</tbody>
                    </table>
                </div>
                <div>
                    Showing {{$from}} to {{$to}} of {{$total}} entries
                </div>
                @if ($paginator)
                <div class="pull-right">
                    {{ $paginator->links() }}
                </div>
                @endif
			</div>
		</div>
	</div>
</div>
@endsection